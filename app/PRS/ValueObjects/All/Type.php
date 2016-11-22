<?php

namespace App\PRS\ValueObjects\All;

class Type{

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the url keyword to access the routes
     * @return string  $urlKeyword  Example: domain.com/urlKeyword/
     * tested
     */
    public function url()
    {
        return strtolower(ltrim(substr($this->type, 4))).'s';
    }

    /**
     * @return string
     * tested
     */
    public function __toString()
    {
        // Put spaces between capital letters and remove 'App\'
        return ltrim(preg_replace('/[A-Z]/', ' $0', substr($this->type, 4)));
    }

}
