# Partition

A call to any of the operations returns a [Partition Result](/result-types/partition.html).

```php
use MOIREI\Metrics\Partition;
...
```

## `count`
Count the total results segmented by column.

```php
$partition = Value::make()->count(Order::class, 'payment_channel');
```

## `average`
Get the average result segmented by column.

```php
$partition = Value::make()->average(Order::class, 'total', 'payment_channel');
```

## `sum`
Sum the total results segmented by column.

```php
$partition = Value::make()->sum(Order::class, 'total', 'payment_channel');
```

## `max`
Get the maximum result segmented by column.

```php
$partition = Value::make()->max(Order::class, 'total', 'payment_channel');
```

## `min`
Get the minimum result segmented by column.

```php
$partition = Value::make()->min(Order::class, 'total', 'payment_channel');
```
