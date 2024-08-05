<?php

namespace MOIREI\Metrics;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use Cake\Chronos\Chronos;
use DateTime;
use DateTimeZone;

class TrendDateExpression
{
    /**
     * The database driver.
     *
     * @var string
     */
    public string $driver;

    /**
     * The query builder being used to build the trend.
     *
     * @var \Illuminate\Database\Query\Builder
     */
    public $query;

    /**
     * The column being measured.
     *
     * @var string
     */
    public $column;

    /**
     * The unit being measured.
     *
     * @var string
     */
    public $unit;

    /**
     * The users's local timezone.
     *
     * @var string
     */
    public $timezone;

    /**
     * Create a new class.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @param  string  $unit
     * @param  string  $timezone
     * @return void
     */
    public function __construct(Builder $query, $column, $unit, $timezone)
    {
        $driver = $query->getConnection()->getDriverName();

        if(!in_array($driver, [
            'sqlite',
            'mysql',
            'mariadb',
            'pgsql',
            'sqlsrv',
            'hogql',
        ])){
            throw new InvalidArgumentException('Unsupported database.');
        }

        if($driver === 'mariadb') $driver = 'mysql';

        $this->driver = $driver;
        $this->unit = $unit;
        $this->query = $query;
        $this->column = $column;
        $this->timezone = $timezone;
    }

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @param  string  $unit
     * @param  string  $timezone
     * @return TrendDateExpression
     */
    public static function make(Builder $query, $column, $unit, $timezone): TrendDateExpression
    {
        return new static($query, $column, $unit, $timezone);
    }

    /**
     * Get the timezone offset.
     *
     * @return int
     */
    public function offset()
    {
        if ($this->timezone) {
            return (new DateTime(Chronos::now($this->timezone)->format('Y-m-d H:i:s'), new DateTimeZone($this->timezone)))->getOffset() / 60 / 60;
        }

        return 0;
    }

    /**
     * Wrap the given value with the query's grammar.
     *
     * @param  string  $value
     * @return string
     */
    protected function wrap($value)
    {
        return $this->query->getQuery()->getGrammar()->wrap($value);
    }

    /**
     * Get the value of the expression.
     *
     * @return mixed
     */
    public function get()
    {
        if($this->driver === 'sqlite') return $this->getSqlite();
        if($this->driver === 'mysql') return $this->getMysql();
        if($this->driver === 'pgsql') return $this->getPgsql();
        if($this->driver === 'sqlsrv') return $this->getSqlsrv();
        if($this->driver === 'hogql') return $this->getHogql();
    }

    /**
     * Get the sqlite value of the expression.
     *
     * @return mixed
     */
    public function getSqlite()
    {
        $offset = $this->offset();

        if ($offset > 0) {
            $interval = '\'+'.$offset.' hour\'';
        } elseif ($offset === 0) {
            $interval = '\'+0 hour\'';
        } else {
            $interval = '\'-'.($offset * -1).' hour\'';
        }

        switch ($this->unit) {
            case 'month':
                return "strftime('%Y-%m', datetime({$this->wrap($this->column)}, {$interval}))";
            case 'week':
                return "strftime('%Y-', datetime({$this->wrap($this->column)}, {$interval})) ||
                        (
                            strftime('%W', datetime({$this->wrap($this->column)}, {$interval})) +
                            (1 - strftime('%W', strftime('%Y', datetime({$this->wrap($this->column)}, {$interval})) || '-01-04'))
                        )";
            case 'day':
                return "strftime('%Y-%m-%d', datetime({$this->wrap($this->column)}, {$interval}))";
            case 'hour':
                return "strftime('%Y-%m-%d %H:00', datetime({$this->wrap($this->column)}, {$interval}))";
            case 'minute':
                return "strftime('%Y-%m-%d %H:%M:00', datetime({$this->wrap($this->column)}, {$interval}))";
        }
    }

    /**
     * Get the postgres value of the expression.
     *
     * @return mixed
     */
    public function getPgsql()
    {
        $offset = $this->offset();

        if ($offset > 0) {
            $interval = '+ interval \''.$offset.' hour\'';
        } elseif ($offset === 0) {
            $interval = '';
        } else {
            $interval = '- interval \''.($offset * -1).' HOUR\'';
        }

        switch ($this->unit) {
            case 'month':
                return "to_char({$this->wrap($this->column)} {$interval}, 'YYYY-MM')";
            case 'week':
                return "to_char({$this->wrap($this->column)} {$interval}, 'IYYY-IW')";
            case 'day':
                return "to_char({$this->wrap($this->column)} {$interval}, 'YYYY-MM-DD')";
            case 'hour':
                return "to_char({$this->wrap($this->column)} {$interval}, 'YYYY-MM-DD HH24:00')";
            case 'minute':
                return "to_char({$this->wrap($this->column)} {$interval}, 'YYYY-MM-DD HH24:mi:00')";
        }
    }

    /**
     * Get the mysql value of the expression.
     *
     * @return mixed
     */
    public function getMysql()
    {
        $offset = $this->offset();

        if ($offset > 0) {
            $interval = '+ INTERVAL '.$offset.' HOUR';
        } elseif ($offset === 0) {
            $interval = '';
        } else {
            $interval = '- INTERVAL '.($offset * -1).' HOUR';
        }

        switch ($this->unit) {
            case 'month':
                return "date_format({$this->wrap($this->column)} {$interval}, '%Y-%m')";
            case 'week':
                return "date_format({$this->wrap($this->column)} {$interval}, '%x-%v')";
            case 'day':
                return "date_format({$this->wrap($this->column)} {$interval}, '%Y-%m-%d')";
            case 'hour':
                return "date_format({$this->wrap($this->column)} {$interval}, '%Y-%m-%d %H:00')";
            case 'minute':
                return "date_format({$this->wrap($this->column)} {$interval}, '%Y-%m-%d %H:%i:00')";
        }
    }

    /**
     * Get the Sqlsrv value of the expression.
     *
     * @return mixed
     */
    public function getSqlsrv()
    {
        $column = $this->wrap($this->column);
        $offset = $this->offset();

        if ($offset >= 0) {
            $interval = $offset;
        } else {
            $interval = '-'.($offset * -1);
        }

        $date = "DATEADD(hour, {$interval}, {$column})";

        switch ($this->unit) {
            case 'month':
                return "FORMAT({$date}, 'yyyy-MM')";
            case 'week':
                return "concat(
                    YEAR({$date}),
                    '-',
                    datepart(ISO_WEEK, {$date})
                )";
            case 'day':
                return "FORMAT({$date}, 'yyyy-MM-dd')";
            case 'hour':
                return "FORMAT({$date}, 'yyyy-MM-dd HH:00')";
            case 'minute':
                return "FORMAT({$date}, 'yyyy-MM-dd HH:mm:00')";
        }
    }

    /**
     * Get the Sqlsrv value of the expression.
     *
     * @return mixed
     */
    public function getHogql()
    {
        $offset = $this->offset();

        if ($offset > 0) {
            $interval = '+ INTERVAL '.$offset.' HOUR';
        } elseif ($offset === 0) {
            $interval = '';
        } else {
            $interval = '- INTERVAL '.($offset * -1).' HOUR';
        }

        switch ($this->unit) {
            case 'month':
                return "formatDateTime({$this->wrap($this->column)} {$interval}, '%Y-%m')";
            case 'week':
                return "formatDateTime({$this->wrap($this->column)} {$interval}, '%Y-%u')";
            case 'day':
                return "formatDateTime({$this->wrap($this->column)} {$interval}, '%Y-%m-%d')";
            case 'hour':
                return "formatDateTime({$this->wrap($this->column)} {$interval}, '%Y-%m-%d %H:00')";
            case 'minute':
                return "formatDateTime({$this->wrap($this->column)} {$interval}, '%Y-%m-%d %H:%i:00')";
        }
    }
}

