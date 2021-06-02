# Count


```php
// allows `minute`, `hour`, `day`, `week`, `month`
$metrics = Value::make()->period('today')->count(Order::class, 'hour');
```

## By minute
Count the total results in the period by minutes.

```php
$metrics = Value::make()->period('today')->countByMinutes(Order::class);
```

## By hour
Count the total results in the period by hours.

```php
$metrics = Value::make()->period('today')->countByHours(Order::class);
```

## By day
Count the total results in the period by days.

```php
$metrics = Value::make()->period('today')->countByDays(Order::class);
```

## By week
Count the total results in the period by weeks.

```php
$metrics = Value::make()->period('today')->countByWeeks(Order::class);
```

## By months
Count the total results in the period by months.

```php
$metrics = Value::make()->period('today')->countByMonths(Order::class);
```
