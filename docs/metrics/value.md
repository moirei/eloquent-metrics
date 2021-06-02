# Value

Value metrics retreive a signle value from a given period. As a [Period Metric](/metrics/period-metric.html), the sample period and comparison periods may be fine-tuned.

```php
use MOIREI\Metrics\Value;
use App\Models\Order;

...

$metrics = Value::make()
                ->period('today')
                ->add('pevious-period')
                ->count(Order::class);

```

## `count`
Count the total results in the period.

```php
$metrics = Value::make()->period('today')->count(Order::class);
```

## `average`
Get the average of the column values in the period.

```php
$metrics = Value::make()->period('today')->average(Order::class, 'total');
```

## `sum`
Sum the column values in the period.

```php
$metrics = Value::make()->period('today')->sum(Order::class, 'total');
```

## `max`
Get the maximum value of the column aggregate values in the period.

```php
$metrics = Value::make()->period('today')->max(Order::class, 'total');
```

## `min`
Get the minimum value of the column aggregate values in the period.

```php
$metrics = Value::make()->period('today')->min(Order::class, 'total');
```
