<?php

namespace MOIREI\Metrics;

use ArrayAccess;
use Exception;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Result implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Make a new instance
     *
     * @param array $data
     * @return \MOIREI\Metrics\Result
     */
    public static function make(array $data): Result{
        return new static($data);
    }

    /**
     * Access any existing data as object
     *
     * @return object
     */
    public function __get($key)
    {
        $data = $this->toObject();
        return $data->$key;
    }

    /**
     * Convert the result into an object
     *
     * @return object
     */
    public function toObject(){
        return json_decode (json_encode ($this->data), false);
    }

    /**
     * Get the result array data.
     *
     * @return array
     */
    public function toArray(): array{
        return $this->data;
    }

    /**
     * Convert the result into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the result instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Exception
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception(json_last_error_msg());
        }

        return $json;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }
}
