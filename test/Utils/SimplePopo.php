<?php

namespace Dontdrinkandroot\Utils;


class SimplePopo 
{
    public $property1;

    public $property2;

    public function __construct($property1 = null, $property2 = null) {
        $this->property1 = $property1;
        $this->property2 = $property2;
    }

    /**
     * @return mixed
     */
    public function getProperty1()
    {
        return $this->property1;
    }

    /**
     * @param mixed $property1
     */
    public function setProperty1($property1)
    {
        $this->property1 = $property1;
    }

    /**
     * @return mixed
     */
    public function getProperty2()
    {
        return $this->property2;
    }

    /**
     * @param mixed $property2
     */
    public function setProperty2($property2)
    {
        $this->property2 = $property2;
    }
}