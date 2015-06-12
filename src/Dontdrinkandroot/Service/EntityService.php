<?php


namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Exception\NoResultFoundException;
use Dontdrinkandroot\Repository\EntityRepositoryInterface;

class EntityService extends AbstractService implements EntityServiceInterface
{

    /**
     * @var EntityRepositoryInterface
     */
    protected $repository;

    /**
     * @param EntityRepositoryInterface $repository
     */
    public function __construct(EntityRepositoryInterface $repository)
    {

        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function listAll()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchById($id)
    {
        $entity = $this->findById($id);
        if (null === $entity) {
            throw new NoResultFoundException('No entity with id: ' . $id);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function save(EntityInterface $entity)
    {
        return $this->repository->save($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id)
    {
        $this->repository->removeById($id);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EntityInterface $entity)
    {
        $this->repository->remove($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll()
    {
        $this->repository->removeAll();
    }

    /**
     * {@inheritdoc}
     */
    public function listPaginated($page, $perPage)
    {
        return $this->repository->findPaginatedBy($page, $perPage);
    }

    /**
     * @return EntityRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}
