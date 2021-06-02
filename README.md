# Eloquent Metrics

All documentation is available at [the documentation site](https://moirei.github.io/eloquent-metrics).



Example


```php
...
use MOIREI\Metrics\Trend;

$metrics = Trend::make()
            ->name('Order Sales')
            ->period('week') // sample a week ago intil now
            ->add('previous-period') // add a comparison period
            ->sumByDays(\App\Models\Order::class, 'total');
```



## Installation

```bash
composer require moirei/eloquent-metrics
```



## Changelog

Please see [CHANGELOG](./CHANGELOG.md).



## Credits

- [Augustus Okoye](https://github.com/augustusnaz)



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.