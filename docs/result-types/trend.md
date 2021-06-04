# Trend Metric Result

<nav-back />

**Result**

| Field         | Type          | Description               |
| ------------- | ------------- | ------------------------- |
| `trend`       | `TrendData`   | The trend data            |
| `comparisons` | `TrendData[]` | The trend comparison data |


**TrendData**

| Field     | Type            | Description                         |
| --------- | --------------- | ----------------------------------- |
| `name`    | `string`        | The sample name for the metric      |
| `labels`  | `string[]`      | The sample labels for the data sets |
| `dataset` | `int[]|float[]` | The trend dataset                   |

