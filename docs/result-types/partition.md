# Partition Metric Result

<nav-back />

**Result**

| Field         | Type            | Description               |
| ------------- | --------------- | ------------------------- |
| `labels`      | `string[]`      | The partition labels      |
| `dataset`     | `int[]|float[]` | The partition value data  |

If you expect a particular label in the set, e.g. `a`, it may be accessed directly with

```php
$result = (new Partition)->count(\App\Models\Order::class, 'payment_provider')

$result->stripe;
// or
$result['stripe']
```
