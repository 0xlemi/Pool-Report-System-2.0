<?php

/**
 * Common tester assert functions
 */
trait TesterTrait
{

    public function assertSameObject($object1, $object2, $associative = false)
    {
        return $this->assertSameArray(
            $object1->toArray(),
            $object2->toArray(),
            $associative
        );
    }

    public function assertSameArray($array1, $array2, $associative = false)
    {
        if($associative){
            $difference = array_diff_assoc(
                    $array1,
                    $array2
                );
        }else{
            $difference = array_diff(
                    $array1,
                    $array2
                );
        }
        return $this->assertTrue(empty($difference));
    }

    public function assertSameArrayOfObjects($array1, $array2)
    {
        foreach ($array1 as $key => $object) {
            if($object != $array2[$key])
            {
                return $this->assertTrue(false);
            }
        }
        return $this->assertTrue(true);
    }

}
