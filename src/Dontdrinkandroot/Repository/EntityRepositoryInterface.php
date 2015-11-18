<?php


namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Pagination\PaginatedResult;

interface EntityRepositoryInterface extends ObjectRepository
{

    /**
     * @deprecated Use persist and merge instead.
     *
     * @param EntityInterface $entity
     * @param bool            $flush
     *
     * @return EntityInterface
     */
    public function save(EntityInterface $entity, $flush = true);

    /**
     * @param bool $all
     */
    public function flush($all = false);

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     */
    public function persist($entity, $flush = true);

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     */
    public function merge($entity, $flush = true);

    /**
     * @param mixed $id
     * @param bool  $flush
     */
    public function removeById($id, $flush = true);

    /**
     * @param mixed $entity
     * @param bool  $flush
     */
    public function remove($entity, $flush = true);

    /**
     * @param bool $flush
     * @param bool $iterate Iterate over each entity so all triggers are called.
     *
     * Removes all entities managed by the repository.
     */
    public function removeAll($flush = true, $iterate = true);

    /**
     * @param int        $page
     * @param int        $perPage
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return PaginatedResult
     */
    public function findPaginatedBy($page = 1, $perPage = 10, array $criteria = [], array $orderBy = null);

    /**
     * @return int
     */
    public function countAll();
}
