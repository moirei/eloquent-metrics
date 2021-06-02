# Min

```php
// allows `minute`, `hour`, `day`, `week`, `month`
$metrics = Value::make()->period('today')->min(Order::class, 'hour', 'total');
```

## By minute
Get the min of the column aggregate in the period by minutes.

```php
$metrics = Value::make()->period('today')->minByMinutes(Order::class, 'total');
```

## By hour
Get the min of the column aggregate in the period by hours.

```php
$metrics = Value::make()->period('today')->minByHours(Order::class, 'total');
```

## By day
Get the min of the column aggregate in the period by days.

```php
$metrics = Value::make()->period('today')->minByDays(Order::class, 'total');
```

## By week
Get the min of the column aggregate in the period by weeks.

```php
$metrics = Value::make()->period('today')->minByWeeks(Order::class, 'total');
```

## By months
Get the min of the column aggregate in the period by months.

```php
$metrics = Value::make()->period('today')->minByMonths(Order::class, 'total');
```
