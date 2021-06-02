<?php

namespace MOIREI\Metrics;

use Illuminate\Support\Carbon;
use Closure;
use InvalidArgumentException;

abstract class Metric
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public string $name;

    /**
     * The metric's timezone
     *
     * @var string
     */
    protected string $timezone;

    /**
     * The metric's display label callback
     *
     * @var Closure
     */
    protected Closure $label;

    /**
     * The precision when rounding.
     *
     * @var int
     */
    public $precision = 0;


    public function __construct()
    {
        $this->timezone = date_default_timezone_get();
    }

    /**
     * Create an instance.
     *
     * @return string
     */
    public static function make(): Metric
    {
        return new static;
    }

    /**
     * Set the precision level used when rounding the value.
     *
     * @param  int  $precision
     * @return $this
     */
    public function precision($precision = 0)
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Get or set the name of the metric.
     *
     * @param string|null $name
     * @return Metric|string
     */
    public function name(string $name = null): Metric | string
    {
        if($name){
            $this->name = $name;
            return $this;
        }

        if(!empty($this->name)) return $this->name;
        $name = (new \ReflectionClass(get_class($this)))->getShortName();
        return Helpers::asDisplayableName($name);
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return Metric
     */
    public function timezone(string $timezone): Metric
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Resolve label name
     *
     * @param Closure $timezone
     * @return Metric
     */
    public function label(Closure $callback): Metric
    {
        $this->label = $callback;
        return $this;
    }

    /**
     * Get a known period Carbon instance
     *
     * @param string|int $period
     * @return \Illuminate\Support\Carbon
     */
    protected function getKnownPeriod(string|int $period): Carbon
    {
        if ($period == 'today') {
            return now($this->timezone)->today();
        }

        if ($period == 'yesterday') {
            return now($this->timezone)->yesterday();
        }

        if ($period == 'week') {
            return now($this->timezone)->today()->subWeek();
        }

        if ($period == 'month') {
            return now($this->timezone)->firstOfMonth();
        }

        if ($period == 'quarter') {
            return Carbon::firstDayOfQuarter($this->timezone);
        }

        if ($period == 'year') {
            return now($this->timezone)->firstOfYear();
        }

        if(is_string($period)){
            throw new InvalidArgumentException('Unknown period name.');
        }

        return now($this->timezone)->subDays($period);
    }
}
