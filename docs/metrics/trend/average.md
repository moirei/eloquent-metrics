# Average

```php
// allows `minute`, `hour`, `day`, `week`, `month`
$metrics = Value::make()->period('today')->average(Order::class, 'hour', 'total');
```

## By minute
Get the average of the column values in the period by minutes.

```php
$metrics = Value::make()->period('today')->averageByMinutes(Order::class, 'total');
```

## By hour
Get the average of the column values in the period by hours.

```php
$metrics = Value::make()->period('today')->averageByHours(Order::class, 'total');
```

## By day
Get the average of the column values in the period by days.

```php
$metrics = Value::make()->period('today')->averageByDays(Order::class, 'total');
```

## By week
Get the average of the column values in the period by weeks.

```php
$metrics = Value::make()->period('today')->averageByWeeks(Order::class, 'total');
```

## By months
Get the average of the column values in the period by months.

```php
$metrics = Value::make()->period('today')->averageByMonths(Order::class, 'total');
```
