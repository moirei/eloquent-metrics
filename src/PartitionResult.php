<?php

namespace MOIREI\Metrics;

class PartitionResult extends Result{
    /**
     * Access any existing data as object
     *
     * @return object
     */
    public function __get($key)
    {
        return $this->get($key)?? parent::__get($key);
    }

    public function offsetGet($offset) {
        return $this->get($offset)?? parent::offsetGet($offset);
    }

    /**
     * Get partition data by key
     *
     * @param string $key
     * @return int|float|null
     */
    public function get(string $key): int|float|null {
        $index = array_search ($key, $this->data['labels']);
        return $index !== false? $this->data['dataset'][$index] : null;
    }
}