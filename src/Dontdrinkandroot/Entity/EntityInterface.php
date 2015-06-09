<?php

namespace Dontdrinkandroot\Entity;

interface EntityInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return bool
     */
    public function isPersisted();
}
