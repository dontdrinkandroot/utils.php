<?php

namespace Dontdrinkandroot\Entity;

interface UuidEntityInterface extends IntegerIdEntityInterface
{

    /**
     * @return string
     */
    public function getUuid();

    /**
     * @param string $uuid
     */
    public function setUuid($uuid);
}
