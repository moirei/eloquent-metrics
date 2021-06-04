# Chartisan

This package can easily be configured with [Laravel Charts](https://github.com/ConsoleTVs/Charts).

Below is a Trend Metric example with Chartisan and customised params.

### Create a middleware to intercept chart queries.

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ChartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->validate([
            'period' => 'array|max:2',
            'period.*' => 'required|iso_date',
            'comparisons' => 'array',
            'comparisons.*' => 'required|in:previous-period,previous-month,previous-quarter,previous-year',
            'unit' => 'in:minute,hour,day,week,month',
        ]);

        $period = $request->get('period', []);
        $to = data_get($period, '1');
        $from = data_get($period, '0');
        $to = $to? Carbon::parse($to) : Carbon::now();
        $from = $from? Carbon::parse($from) : $to->subWeek();

        $comparisons = $request->get('comparisons', []);

        $request->merge([
            'period' => [
                'from' => $from,
                'to' => $to,
            ],
            'comparisons' => $comparisons,
            'unit' => $request->get('unit', 'hour'),
        ]);

        return $next($request);
    }
}
```

### Add it to your `chart.php` config

```php
<?php

return [
    ...
    'global_middlewares' => [
        ...
        App\Http\Middleware\ChartMiddleware::class,
    ],
];
```

### Create an example chart

```bash
php artisan make:chart OrderSales
```

```php
<?php

declare(strict_types = 1);

namespace App\Charts;

use MOIREI\Metrics\Trend;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Models\Ecommerce\Order;

class OrderSales extends BaseChart
{
    public ?string $name = 'order-value';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $period = $request->get('period');

        $metrics = Trend::make()
        ->period($period['from'], $period['to'])
        ->add($request->get('comparisons'))
        ->sum(Order::class, $request->get('unit'), 'total')
        ->extra([
            'prefix' => '$',
        ]);

        $chart = Chartisan::build()
        ->labels($metrics->trend->labels)
        ->dataset($metrics->trend->name, $metrics->trend->dataset)
        ->extra([
            'prefix' => '$',
        ]);
        foreach($metrics->comparisons as $comparison){
            $chart->dataset($comparison->name, $comparison->dataset);
        }

        return $chart;
    }
}
```
Don't for get to [register the chart](https://charts.erik.cat/guide/create_charts.html#register-the-chart).

### Retrieve the chart from the fontend
```javascript
const metrics = axios
      .get('/api/chart/order-value', {
        params: {
          period: [
            moment().subtract(2, 'days').toISOString(),
            moment().toISOString()
          ],
          comparisons: ['previous-week'],
          interval: 'day',
        },
      })
```
