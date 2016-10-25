<?php

namespace App\PRS\ValueObjects\Administrator;

interface BaseTag{

    public function fromReading(int $num);

    public function asArray();

}
