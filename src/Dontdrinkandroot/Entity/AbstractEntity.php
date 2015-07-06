<?php


namespace Dontdrinkandroot\Entity;

abstract class AbstractEntity implements EntityInterface
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isPersisted()
    {
        return null !== $this->getId();
    }
}
