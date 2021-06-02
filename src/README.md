# Laravel Metrics

```php
$metric = ValueMetric::make()
          ->period('week')
          ->add('previous-week')
          ->count(User::class);

$chart = $metric->get()
```

## Dependencies
- [Cake\Chronos](https://github.com/cakephp/chronos)
- Illuminate\Support\Carbon
- Illuminate\Support\Str
- Illuminate\Database\Eloquent\Builder
- Illuminate\Support\Facades\DB