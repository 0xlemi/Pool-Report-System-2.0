<?php

namespace App\PRS\ValueObjects\Administrator;

abstract class BaseTag{

    /**
     * Get tag depending on reading
     * @param  int    $num  value reading
     * @return string       tag
     * tested
     */
    public function fromReading(int $num)
    {
        return $this->asArray()[$num];
    }

    /**
     * Get an array with the colors for each tag
     * @return array
     * tested
     */
    public function asArrayWithColor()
    {
        $styled = [];
        foreach ($this->asArray() as $key => $value) {
            $styled[$key] = (object)[ 'text' => $value, 'color' => $this->colors[$key]];
        }
        return $styled;
    }

    public abstract function asArray();

}
