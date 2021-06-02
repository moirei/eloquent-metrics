# Max

```php
// allows `minute`, `hour`, `day`, `week`, `month`
$metrics = Value::make()->period('today')->max(Order::class, 'hour', 'total');
```

## By minute
Get the max of the column aggregate in the period by minutes.

```php
$metrics = Value::make()->period('today')->maxByMinutes(Order::class, 'total');
```

## By hour
Get the max of the column aggregate in the period by hours.

```php
$metrics = Value::make()->period('today')->maxByHours(Order::class, 'total');
```

## By day
Get the max of the column aggregate in the period by days.

```php
$metrics = Value::make()->period('today')->maxByDays(Order::class, 'total');
```

## By week
Get the max of the column aggregate in the period by weeks.

```php
$metrics = Value::make()->period('today')->maxByWeeks(Order::class, 'total');
```

## By months
Get the max of the column aggregate in the period by months.

```php
$metrics = Value::make()->period('today')->maxByMonths(Order::class, 'total');
```
