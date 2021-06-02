<?php

namespace MOIREI\Metrics;

use Illuminate\Support\Carbon;
use InvalidArgumentException;
use Illuminate\Support\Str;
use LogicException;

abstract class PeriodMetric extends Metric
{
    /**
     * The period of for the metric.
     *
     * @var array
     */
    public $period;

    /**
     * The displayable name for the period of the metric.
     *
     * @var string
     */
    public $period_name;

    /**
     * The metric's data
     *
     * @var array
     */
    protected $data;

    /**
     * The metric's comparisons data
     *
     * @var array
     */
    protected $comparison_values = [];

    /**
     * The metric's comparison datasets
     *
     * @var array
     */
    protected array $comparisons = [];

    /**
     * Set the period for the dataset.
     *
     * @param \Illuminate\Support\Carbon|string|int $start
     * @param \Illuminate\Support\Carbon|null $end
     * @return PeriodMetric
     */
    public function period(Carbon | string | int $start, Carbon $end = null): PeriodMetric
    {
        if(is_string($start)){
            $start = $this->getKnownPeriod($start);
            $name = (string)$start;
        }elseif(is_numeric($start)){
            $start = now($this->timezone)->subHours($start);
            $name = (string)$start;
        }

        $this->period = [$start, $end?? now($this->timezone)];

        if(empty($name)){
            $name = $start->isoFormat('dddd D');
        }

        $this->period_name = $name;

        return $this;
    }

    /**
     * Add a comparison(s) period to the dataset.
     *
     * @param \Illuminate\Support\Carbon|string|float|int|array $comparison
     * @param string|null $qualifier
     * @return PeriodMetric
     */
    public function add(Carbon|string|float|int|array $comparison, string|null $qualifier = null): PeriodMetric
    {
        if(!is_array($comparison)){
            return $this->comparison($comparison, $qualifier);
        }

        foreach($comparison as $item){
            if(is_string($item)){
                call_user_func_array([$this, "comparison"], explode(' ', $item));
            }else{
                $this->comparison($item);
            }
        }

        return $this;
    }


    /**
     * Add a comparison period to the dataset.
     * Before calling this method, period should be set first
     *
     * @param \Illuminate\Support\Carbon|string|float|int $comparison
     * @param string|null $qualifier
     * @return PeriodMetric
     */
    public function comparison(Carbon | string | float | int $comparison, string | null $qualifier = null): PeriodMetric
    {
        if(!$this->period){
            throw new LogicException('Intitialise period before adding comparisons.');
        }

        $amount = 1;

        if(is_numeric($comparison)){
            $amount = floatval($comparison);
            $function = $qualifier?? 'day';
            $unit = $comparison == 1? Str::singular($function) : Str::plural($function);
            $name = "$comparison $unit before";
        }else{
            $comparison = Str::after($comparison, 'previous-');
            if($comparison == 'period') $comparison = 'week';
            $function = $comparison;
            $name = Helpers::asDisplayableName($comparison);
        }

        if(!in_array(Str::singular($function), [
            'hour',
            'day',
            'week',
            'month',
            'year',
        ])){
            throw new InvalidArgumentException('Invalid comparison period provided.');
        }

        // if($function == 'quarter'){
        //     Carbon::firstDayOfPreviousQuarter($this->timezone)->setTimezone($this->timezone)->setTime(0, 0);
        // }

        $function = (string)Str::of($function)->plural()->ucfirst()->prepend('sub');

        // return $now->subDays($range - 1)->setTime(0, 0);
        // case self::BY_WEEKS:
        //     return $now->subWeeks($range - 1)->startOfWeek()->setTime(0, 0);
        // case self::BY_MONTHS:
        //     return $now->subMonths($range - 1)->firstOfMonth()->setTime(0, 0);

        array_push($this->comparisons, [
            'name' => $name,
            'period' => [
                (clone $this->period[0])->$function($amount),
                (clone $this->period[1])->$function($amount),
            ],
        ]);

        return $this;
    }

    /**
     * Get the current period.
     *
     * @param \Illuminate\Support\Carbon|null $now
     * @return array
     */
    protected function currentPeriod(Carbon $now = null): array
    {
        return [
            $this->period[0],
            $now?? $this->period[1]?? now($this->timezone)
        ];
    }
}

