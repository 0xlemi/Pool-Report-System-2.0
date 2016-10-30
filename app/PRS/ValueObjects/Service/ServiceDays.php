<?php

namespace App\PRS\ValueObjects\Service;

use App\Service;

class ServiceDays{

    protected $serviceDays;

    public function __construct(int $serviceDays)
    {
        $this->serviceDays = $serviceDays;
    }

    /**
     * Get the days of the week in 3 letter format.
     * @return string
     * tested
     */
    public function shortNames()
    {
        $result = '';
        foreach ($this->asArray() as $day => $active) {
            if($active){
                $result .= substr($day, 0, 3).', ';
            }
        }
        return rtrim($result, ", ");
    }

    /**
     * Get the days of the week in 3 letter format and styled as span.
     * @param  string $label
     * @return string       html span with the days
     * tested
     */
    public function shortNamesStyled($label = "default")
    {
        return "<span class=\"label label-pill label-{$label}\">{$this->shortNames()}</span>";
    }

    /**
     * Get the days of the week in full name format.
     * @return string
     * tested
     */
    public function fullNames()
    {
        $result = '';
        foreach ($this->asArray() as $day => $active) {
            if($active){
                $result .= $day.', ';
            }
        }
        return rtrim($result, ", ");
    }

    public function __toString()
    {
        return $this->shortNames();
    }

    /**
     * Transform service days number to a array of days
     * We are expecting a number between 0 and 127
     * where active days are set to true.
     * @return array      array of the days of the week
     * tested
     */
    public function asArray()
    {
                // Transform ints to booleans
        $days = array_map(function($num){
                    return (boolean) $num;
                },
                    // reverse the order so it starts at monday
                    array_reverse(
                        // make it an array
                        str_split(
                            // fill missing zeros
                            sprintf( "%07d",
                                // transform num to binary
                                decbin($this->serviceDays)
                            )
                        )
                    )
                );
        return array(
            'monday'    => $days[0],
            'tuesday'   => $days[1],
            'wednesday' => $days[2],
            'thursday'  => $days[3],
            'friday'    => $days[4],
            'saturday'  => $days[5],
            'sunday'    => $days[6],
        );
    }

}
