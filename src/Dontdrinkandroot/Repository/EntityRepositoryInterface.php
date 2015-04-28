<?php


namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Dontdrinkandroot\Entity\EntityInterface;

interface EntityRepositoryInterface extends ObjectRepository
{

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
     * Removes all entities managed by the repository.
     */
    public function removeAll();
}
