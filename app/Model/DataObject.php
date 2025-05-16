<?php

declare(strict_types=1);

namespace App\Model;

class DataObject
{
    /**
     * @var array
     */
    protected array $data = [];

    public function setData(mixed $key, $value = null): DataObject
    {
        if ($key === (array)$key) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * @param mixed $key
     * @return mixed|null
     */
    public function getData(mixed $key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }
}
