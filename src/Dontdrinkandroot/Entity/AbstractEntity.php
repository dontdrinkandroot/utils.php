<?php


namespace Dontdrinkandroot\Entity;

abstract class AbstractEntity implements EntityInterface
{
    public function __construct()
    {
    }

    /**
     * @deprecated
     */
    public function isPersisted()
    {
        return null !== $this->getId();
    }
}
