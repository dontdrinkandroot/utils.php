<?php


namespace Dontdrinkandroot\Service;

use Doctrine\ORM\EntityNotFoundException;
use Dontdrinkandroot\Entity\EntityInterface;

interface EntityServiceInterface
{

    /**
     * @return EntityInterface[]
     */
    public function findAll();

    /**
     * @param mixed $id
     *
     * @return EntityInterface|null
     */
    public function findById($id);

    /**
     * @param mixed $id
     *
     * @return mixed
     *
     * @throws EntityNotFoundException
     */
    public function fetchById($id);

    /**
     * @param EntityInterface $entity
     *
     * @return EntityInterface
     */
    public function save(EntityInterface $entity);

    /**
     * @param mixed $id
     */
    public function removeById($id);

    /**
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity);

    /**
     * Removes all entity of the corresponding type.
     */
    public function removeAll();
}
