<?php

namespace MOIREI\Metrics;

use Cake\Chronos\Chronos;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;


class Trend extends PeriodMetric
{
    const BY_MINUTES = 'minute';
    const BY_HOURS = 'hour';
    const BY_DAYS = 'day';
    const BY_WEEKS = 'week';
    const BY_MONTHS = 'month';

    /**
     * Whether metric labels should be displayed in 12-hour/24-hour.
     *
     * @var string
     */
    protected bool $twelve_hour = false;

    /**
     * Set twelve/24 hour.
     *
     * @param  bool  $value
     * @return Trend
     */
    public function twelveHour($value = true)
    {
        $this->twelve_hour = $value;
        return $this;
    }

    /**
     * Get the count trend by months.
     *
     * @param  \Illuminate\Http\  $request
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @return Chartisan
     */
    public function countByMonths($model, $column = null)
    {
        return $this->count($model, self::BY_MONTHS, $column);
    }

    /**
     * Get the count trend by weeks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @return Chartisan
     */
    public function countByWeeks($model, $column = null)
    {
        return $this->count($model, self::BY_WEEKS, $column);
    }

    /**
     * Get the count trend by days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @return Chartisan
     */
    public function countByDays($model, $column = null)
    {
        return $this->count($model, self::BY_DAYS, $column);
    }

    /**
     * Get the count trend by hours.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @return Chartisan
     */
    public function countByHours($model, $column = null)
    {
        return $this->count($model, self::BY_HOURS, $column);
    }

    /**
     * Get the count trend by minutes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @return Chartisan
     */
    public function countByMinutes($model, $column = null)
    {
        return $this->count($model, self::BY_MINUTES, $column);
    }

    /**
     * Execute and get a count trend.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string|null  $column
     * @return Chartisan
     */
    public function count($model, $unit, $column = null)
    {
        if ($model instanceof Builder) {
            /** @var \Illuminate\Database\Eloquent\Model */
            $instance = $model->getModel();
            $query = $model->getConnection()->getDriverName() === 'hogql'? $model : get_class($instance);
        } else {
            /** @var \Illuminate\Database\Eloquent\Model */
            $instance = new $model;
            $query = $model;
        }

        $column = $column ?? $instance->getCreatedAtColumn();

        return $this->aggregate($query, $unit, 'count', $instance->getQualifiedKeyName(), $column);
    }

    /**
     * Get the average value trend by months.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function averageByMonths($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MONTHS, 'avg', $column, $date_column);
    }

    /**
     * Get the average value trend by weeks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function averageByWeeks($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_WEEKS, 'avg', $column, $date_column);
    }

    /**
     * Get the average value trend by days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function averageByDays($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_DAYS, 'avg', $column, $date_column);
    }

    /**
     * Get the average value trend by hours.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function averageByHours($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_HOURS, 'avg', $column, $date_column);
    }

    /**
     * Get the average value trend by minutes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function averageByMinutes($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MINUTES, 'avg', $column, $date_column);
    }

    /**
     * Execute and get an average value trend.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function average($model, $unit, $column, $date_column = null)
    {
        return $this->aggregate($model, $unit, 'avg', $column, $date_column);
    }

    /**
     * Get the sum value trend by months.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sumByMonths($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MONTHS, 'sum', $column, $date_column);
    }

    /**
     * Get the sum value trend by weeks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sumByWeeks($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_WEEKS, 'sum', $column, $date_column);
    }

    /**
     * Get the sum value trend by days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sumByDays($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_DAYS, 'sum', $column, $date_column);
    }

    /**
     * Get the sum value trend by hours.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sumByHours($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_HOURS, 'sum', $column, $date_column);
    }

    /**
     * Get the sum value trend by minutes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sumByMinutes($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MINUTES, 'sum', $column, $date_column);
    }

    /**
     * Execute and get a sum trend.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function sum($model, $unit, $column, $date_column = null)
    {
        return $this->aggregate($model, $unit, 'sum', $column, $date_column);
    }

    /**
     * Get the max value trend by months.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Database\Eloquent\Builder|string $model
     * @param  string  $column
     * @param  string  $date_column
     * @return TrendResult
     */
    public function maxByMonths($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MONTHS, 'max', $column, $date_column);
    }

    /**
     * Get the max value trend by weeks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function maxByWeeks($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_WEEKS, 'max', $column, $date_column);
    }

    /**
     * Get the max value trend by days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function maxByDays($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_DAYS, 'max', $column, $date_column);
    }

    /**
     * Get the max value trend by hours.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function maxByHours($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_HOURS, 'max', $column, $date_column);
    }

    /**
     * Get the max value trend by minutes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function maxByMinutes($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MINUTES, 'max', $column, $date_column);
    }

    /**
     * Execute and get a maximum value trend.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function max($model, $unit, $column, $date_column = null)
    {
        return $this->aggregate($model, $unit, 'max', $column, $date_column);
    }

    /**
     * Get the min value trend by months.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function minByMonths($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MONTHS, 'min', $column, $date_column);
    }

    /**
     * Get the min value trend by weeks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function minByWeeks($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_WEEKS, 'min', $column, $date_column);
    }

    /**
     * Get the min value trend by days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function minByDays($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_DAYS, 'min', $column, $date_column);
    }

    /**
     * Get the min value trend by hours.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function minByHours($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_HOURS, 'min', $column, $date_column);
    }

    /**
     * Get the min value trend by minutes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function minByMinutes($model, $column, $date_column = null)
    {
        return $this->aggregate($model, self::BY_MINUTES, 'min', $column, $date_column);
    }

    /**
     * Execute and get a minimum value trend.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $column
     * @param  string  $date_column
     * @return Chartisan
     */
    public function min($model, $unit, $column, $date_column = null)
    {
        return $this->aggregate($model, $unit, 'min', $column, $date_column);
    }

    /**
     * Get the trend values of a function on a model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $unit
     * @param  string  $function
     * @param  string  $column
     * @param  string  $date_column
     * @return TrendResult
     */
    public function aggregate($model, $unit, $function, $column, $date_column = null)
    {
        if (!in_array($unit, [
            self::BY_MINUTES,
            self::BY_HOURS,
            self::BY_DAYS,
            self::BY_WEEKS,
            self::BY_MONTHS,
        ])) {
            throw new InvalidArgumentException('Invalid interval provided.');
        }

        $query = $model instanceof Builder ? $model : (new $model)->newQuery();

        $expression = TrendDateExpression::make(
            $query,
            $date_column = $date_column ?? $query->getModel()->getCreatedAtColumn(),
            $unit,
            $this->timezone
        )->get();

        $wrapped_column = $query->getQuery()->getGrammar()->wrap($column);

        $this->data = $this->queryHeap($query, $expression, $function, $unit, $wrapped_column, $date_column, [
            new Chronos((string)$this->period[0], $this->timezone),
            new Chronos((string)$this->period[1], $this->timezone),
        ]);

        $this->comparisons = array_map(function ($comparison) use ($query, $expression, $function, $unit, $wrapped_column, $date_column) {
            $results = $this->queryHeap($query, $expression, $function, $unit, $wrapped_column, $date_column, [
                new Chronos((string)$comparison['period'][0], $this->timezone),
                new Chronos((string)$comparison['period'][1], $this->timezone),
            ]);

            array_push($this->comparison_values, [
                'name' => $comparison['name'],
                'data' => $results,
            ]);
        }, $this->comparisons);

        $results = [
            'trend' => [
                'name' => $this->period_name,
                'labels' => array_keys($this->data),
                'dataset' => array_values($this->data)
            ],
            'comparisons' => array_map(function ($comparison) {
                return [
                    'name' => $comparison['name'],
                    'labels' => array_keys($comparison['data']),
                    'dataset' => array_values($comparison['data']),
                ];
            }, $this->comparison_values)
        ];

        return TrendResult::make($results);
    }

    /**
     * Perform a metric's query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $expression
     * @param  bool  $is_twelve_hour
     * @return array
     */
    protected function queryHeap(Builder $query, string $expression, string $function, string $unit, string $wrapped_column, string $date_column, array $period)
    {
        $available_date_results = $this->getAvalaibleDateResults(
            $period[0],
            $period[1],
            $unit,
            $this->timezone,
            $is_twelve_hour = $this->twelve_hour
        );

        $select_statement = DB::raw("{$expression} as date_result, {$function}({$wrapped_column}) as aggregate");

        if($query->getConnection()->getDriverName() === 'hogql'){
            $query = $query->addSelect($select_statement);
        }else{
            $query = $query->select($select_statement);
        }

        $results = $query
            ->whereBetween($date_column, $period)
            ->groupBy(DB::raw($expression))
            ->orderBy('date_result')
            ->get();

        return array_merge($available_date_results, $results->mapWithKeys(function ($result) use ($unit, $is_twelve_hour) {
            return [
                $this->formatHeapResultDate($result->date_result, $unit, $is_twelve_hour) => round($result->aggregate, $this->precision)
            ];
        })->all());
    }

    /**
     * Format the result date label.
     *
     * @param  string  $result
     * @param  string  $unit
     * @param  bool  $is_twelve_hour
     * @return string
     */
    protected function formatHeapResultDate($result, $unit, $is_twelve_hour)
    {
        switch ($unit) {
            case self::BY_MINUTES:
                return with(Chronos::createFromFormat('Y-m-d H:i:00', $result), function ($date) use ($is_twelve_hour) {
                    return $is_twelve_hour
                        ? __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('g:i A')
                        : __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('G:i');
                });
            case self::BY_HOURS:
                return with(Chronos::createFromFormat('Y-m-d H:00', $result), function ($date) use ($is_twelve_hour) {
                    return $is_twelve_hour
                        ? __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('g:00 A')
                        : __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('G:00');
                });
            case self::BY_DAYS:
                return with(Chronos::createFromFormat('Y-m-d', $result), function ($date) {
                    return __($date->format('F')) . ' ' . $date->format('j') . ', ' . $date->format('Y');
                });
            case self::BY_WEEKS:
                return $this->formatHeapWeekDate($result);
            case self::BY_MONTHS:
                return $this->formatHeapMonthDate($result);
        }
    }

    /**
     * Format the month result date into a proper string.
     *
     * @param  string  $result
     * @return string
     */
    protected function formatHeapMonthDate($result)
    {
        [$year, $month] = explode('-', $result);

        return with(Chronos::create((int) $year, (int) $month, 1), function ($date) {
            return __($date->format('F')) . ' ' . $date->format('Y');
        });
    }

    /**
     * Format the week result date into a proper string.
     *
     * @param  string  $result
     * @return string
     */
    protected function formatHeapWeekDate($result)
    {
        [$year, $week] = explode('-', $result);

        $iso_date = (new DateTime)->setISODate($year, $week)->setTime(0, 0);

        [$start, $end] = [
            Chronos::instance($iso_date),
            Chronos::instance($iso_date)->endOfWeek(),
        ];

        return __($start->format('F')) . ' ' . $start->format('j') . ' - ' .
            __($end->format('F')) . ' ' . $end->format('j');
    }

    /**
     * Get all available date results for the given unit.
     *
     * @param  \Cake\Chronos\Chronos  $start
     * @param  \Cake\Chronos\Chronos  $end
     * @param  string  $unit
     * @param  mixed  $timezone
     * @param  bool  $is_twelve_hour
     * @return array
     */
    protected function getAvalaibleDateResults(Chronos $start, Chronos $end, $unit, $timezone, $is_twelve_hour)
    {
        $next_date = $start;

        if (!empty($timezone)) {
            $next_date = $start->setTimezone($timezone);
            $end = $end->setTimezone($timezone);
        }

        $available_dates[$this->formatPossibleHeapResultDate($next_date, $unit, $is_twelve_hour)] = 0;

        while ($next_date->lt($end)) {
            if ($unit === self::BY_MONTHS) {
                $next_date = $next_date->addMonths(1);
            } elseif ($unit === self::BY_WEEKS) {
                $next_date = $next_date->addWeeks(1);
            } elseif ($unit === self::BY_DAYS) {
                $next_date = $next_date->addDays(1);
            } elseif ($unit === self::BY_HOURS) {
                $next_date = $next_date->addHours(1);
            } elseif ($unit === self::BY_MINUTES) {
                $next_date = $next_date->addMinutes(1);
            }

            if ($next_date->lte($end)) {
                $available_dates[$this->formatPossibleHeapResultDate($next_date, $unit, $is_twelve_hour)] = 0;
            }
        }

        return $available_dates;
    }

    /**
     * Format the possible aggregate result date into a proper string.
     *
     * @param  \Cake\Chronos\Chronos  $date
     * @param  string  $unit
     * @param  bool  $is_twelve_hour
     * @return string
     */
    protected function formatPossibleHeapResultDate(Chronos $date, $unit, $is_twelve_hour)
    {
        switch ($unit) {
            case 'minute':
                return $is_twelve_hour
                    ? __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('g:i A')
                    : __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('G:i');
            case 'hour':
                return $is_twelve_hour
                    ? __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('g:00 A')
                    : __($date->format('F')) . ' ' . $date->format('j') . ' - ' . $date->format('G:00');
            case 'day':
                return __($date->format('F')) . ' ' . $date->format('j') . ', ' . $date->format('Y');
            case 'week':
                return __($date->startOfWeek()->format('F')) . ' ' . $date->startOfWeek()->format('j') . ' - ' .
                    __($date->endOfWeek()->format('F')) . ' ' . $date->endOfWeek()->format('j');
            case 'month':
                return __($date->format('F')) . ' ' . $date->format('Y');
        }
    }
}
