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

}
