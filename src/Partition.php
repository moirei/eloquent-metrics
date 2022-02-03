<?php

namespace MOIREI\Metrics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Partition extends Metric
{
    /**
     * Get a count value partition over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $group_by
     * @param  string|null  $column
     * @return Chartisan
     */
    public function count($model, $group_by, $column = null)
    {
        return $this->aggregate($model, 'count', $column, $group_by);
    }

    /**
     * Get an average value partition over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @param  string  $group_by
     * @return Chartisan
     */
    public function average($model, $column, $group_by)
    {
        return $this->aggregate($model, 'avg', $column, $group_by);
    }

    /**
     * Get a sum value partition over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @param  string  $group_by
     * @return Chartisan
     */
    public function sum($model, $column, $group_by)
    {
        return $this->aggregate($model, 'sum', $column, $group_by);
    }

    /**
     * Get a maximum value partition over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @param  string  $group_by
     * @return Chartisan
     */
    public function max($model, $column, $group_by)
    {
        return $this->aggregate($model, 'max', $column, $group_by);
    }

    /**
     * Get a minimum value partition over time.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string|null  $column
     * @param  string  $group_by
     * @return Chartisan
     */
    public function min($model, $column, $group_by)
    {
        return $this->aggregate($model, 'min', $column, $group_by);
    }

    /**
     * Get the partition values of a function on a model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|string  $model
     * @param  string  $function
     * @param  string  $column
     * @param  string  $group_by
     * @return PartitionResult
     */
    public function aggregate($model, $function, $column, $group_by)
    {
        $query = $model instanceof Builder ? $model : (new $model)->newQuery();
        $column = $column ?? $query->getModel()->getQualifiedKeyName();

        $wrapped_column = $query->getQuery()->getGrammar()->wrap($column);

        $results = $query->select($group_by, DB::raw("{$function}({$wrapped_column}) as aggregate"))->groupBy($group_by)->get();

        $results = $results->mapWithKeys(function ($result) use ($group_by) {
            return $this->formatResult($result, $group_by);
        })->all();

        return PartitionResult::make([
            'labels' => array_keys($results),
            'dataset' => array_values($results),
        ]);
    }

    /**
     * Format the result for the partition.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $result
     * @param  string  $group_by
     * @return array
     */
    protected function formatResult($result, $group_by)
    {
        $key = $result->{last(explode('.', $group_by))};

        return [$key => $result->aggregate];
    }
}
