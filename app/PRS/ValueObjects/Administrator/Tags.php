<?php

namespace App\PRS\ValueObjects\Administrator;

use App\PRS\ValueObjects\Administrator\TagTurbidity;
use App\PRS\ValueObjects\Administrator\Tag;

class Tags{

    protected $ph;
    protected $chlorine;
    protected $temperature;
    protected $turbidity;
    protected $salt;

    public function __construct(Tag $ph, Tag $chlorine,
                                Tag $temperature, TagTurbidity $turbidity,
                                Tag $salt)
    {
        $this->ph = $ph;
        $this->chlorine = $chlorine;
        $this->temperature = $temperature;
        $this->turbidity = $turbidity;
        $this->salt = $salt;
    }

// ********** GETTERS **********

    public function ph()
    {
        return $ph;
    }

    public function chlorine()
    {
        return $chlorine;
    }

    public function temperature()
    {
        return $temperature;
    }

    public function turbidity()
    {
        return $turbidity;
    }

    public function salt()
    {
        return $salt;
    }

}
