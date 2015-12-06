<?php


namespace Dontdrinkandroot\Test;

trait ReferenceTrait
{

    /**
     * @param string $name
     *
     * @return mixed
     */
    abstract protected function getReference($name);
}
