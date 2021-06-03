<?php

namespace MOIREI\Metrics;

use Illuminate\Database\Eloquent\Builder;
use LogicException;

class Value extends PeriodMetric
{
    /**
     * The metric's function.
     *
     * @var string
     */
    public string $function;

    /**
     * Get the value of a count over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    public function count($model, $column = null, $date_column = null)
    {
        return $this->aggregate($model, 'count', $column, $date_column);
    }

    /**
     * Get the value of an average over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    public function average($model, $column, $date_column = null)
    {
        return $this->aggregate($model, 'avg', $column, $date_column);
    }

    /**
     * Get the value of a sum over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    public function sum($model, $column, $date_column = null)
    {
        return $this->aggregate($model, 'sum', $column, $date_column);
    }

    /**
     * Get the value of a maximum over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    public function max($model, $column, $date_column = null)
    {
        return $this->aggregate($model, 'max', $column, $date_column);
    }

    /**
     * Get the value of a minimum over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    public function min($model, $column, $date_column = null)
    {
        return $this->aggregate($model, 'min', $column, $date_column);
    }

    /**
     * Get the value of a function on a model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $function
     * @param  string|null  $column
     * @param  string|null  $date_column
     * @return Chartisan
     */
    protected function aggregate($model, $function, $column = null, $date_column = null)
    {
        $this->function = $function;

        $query = $model instanceof Builder ? $model : (new $model)->newQuery();
        $column = $column ?? $query->getModel()->getQualifiedKeyName();

        $date_column = $date_column ?? $query->getModel()->getCreatedAtColumn();
        $query = with(clone $query);

        if(!$this->period){
            throw new LogicException('Intitialise period before creating metric.');
        }

        $this->data = round($query->whereBetween($date_column, $this->period)->{$function}($column), $this->precision);

        // comparisons
        foreach($this->comparisons as $comparison){
            array_push($this->comparison_values, [
                'name' => $comparison['name'],
                'data' => round($query->whereBetween($date_column, $comparison['period'])->{$function}($column), $this->precision)
            ]);
        }

        $results = [
            'value' => [
                'name' => $this->period_name,
                'data' => $this->data
            ],
            'comparisons' => array_map(function($comparison){
                return [
                    'name' => $comparison['name'],
                    'data' => $comparison['data'],
                ];
            }, $this->comparison_values)
        ];

        return ValueResult::make($results);
    }
}