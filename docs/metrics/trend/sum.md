# Sum

```php
// allows `minute`, `hour`, `day`, `week`, `month`
$metrics = Value::make()->period('today')->sum(Order::class, 'hour', 'total');
```

## By minute
Get the sum of the column aggregate in the period by minutes.

```php
$metrics = Value::make()->period('today')->sumByMinutes(Order::class, 'total');
```

## By hour
Get the sum of the column aggregate in the period by hours.

```php
$metrics = Value::make()->period('today')->sumByHours(Order::class, 'total');
```

## By day
Get the sum of the column aggregate in the period by days.

```php
$metrics = Value::make()->period('today')->sumByDays(Order::class, 'total');
```

## By week
Get the sum of the column aggregate in the period by weeks.

```php
$metrics = Value::make()->period('today')->sumByWeeks(Order::class, 'total');
```

## By months
Get the sum of the column aggregate in the period by months.

```php
$metrics = Value::make()->period('today')->sumByMonths(Order::class, 'total');
```
