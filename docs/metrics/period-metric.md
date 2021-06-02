# Period Metric


## `period`

Sets the period for range for the metric.

### With string

```php
$metric->period('yesterday'); // yesterday until now
```
Allowed strings
| Value        | Description           |
| ------------- | -----|
| `today` | From `00:00` until now |
| `yesterday` | From `00:00` yesterday until now |
| `week` | From `00:00` a week ago until now |
| `period` | Same as `week` |
| `month` | From `00:00` a month ago until now |
| `quarter` | From `00:00` of the first day of the quarter until now |
| `year` | From `00:00` a year ago until now |



### With range

```php
// 2 days ago until now
$metric->period(
  now()->subDays(1),
  now(),
);
```

## `add`
Adds a comparison period to the metric.
The resulting data is a sample of the original period, shifted by the comparison period.
Before calling this method, `period` should first be called.

```php
$metric->add(3, 'months');
```

### With string
```php
$metric->add('previous-week');
```
Allowed strings
| Value        | Description           |
| ------------- | -----|
| `previous-hour` | A comparison of the period shifted a hour before |
| `previous-day` | A comparison of the period shifted a day before |
| `previous-week` | A comparison of the period shifted a week before |
| `previous-period` | Same as `previous-day` |
| `previous-month` | A comparison of the period shifted a month before |
| `previous-year` | A comparison of the period shifted a year before |


### With array
```php
$metric->add([
  '2 days', // adds a shift of the metric's period by 2 days before
  '4 weeks', //  adds a shift of the metric's period by 4 weeks before
]);
```
