<?php


namespace Dontdrinkandroot\Entity;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    public function isPersisted()
    {
        return null !== $this->getId();
    }
}
