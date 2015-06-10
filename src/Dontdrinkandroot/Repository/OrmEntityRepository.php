<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Pagination\PaginatedResult;
use Dontdrinkandroot\Pagination\Pagination;

class OrmEntityRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(EntityInterface $entity, $flush = false)
    {
        try {
            $this->beginTransation();

            if (null === $entity->getId()) {
                $this->_em->persist($entity);
            } else {
                $this->_em->merge($entity);
            }

            if ($flush) {
                $this->_em->flush();
            }
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EntityInterface $entity, $flush = false)
    {
        try {
            $this->beginTransation();
            $this->_em->remove($entity);
            if ($flush) {
                $this->_em->flush();
            }
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, $flush = false)
    {
        try {
            $this->beginTransation();
            /** @var EntityInterface $entity */
            $entity = $this->find($id);
            $this->remove($entity, $flush);
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll()
    {
        try {
            $queryBuilder = $this->createQueryBuilder('entity');

            $queryBuilder->delete();

            $query = $queryBuilder->getQuery();

            $query->execute();
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * @deprecated
     */
    public function deleteAll()
    {
        try {
            $this->removeAll();
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findPaginatedBy($page = 1, $perPage = 10, array $criteria = [], array $orderBy = null)
    {
        $persister = $this->getEntityManager()->getUnitOfWork()->getEntityPersister($this->_entityName);

        $this->getEntityManager()->beginTransaction();
        try {
            $total = $persister->count($criteria);
            $results = $persister->loadAll($criteria, $orderBy, $perPage, ($page - 1) * $perPage);

            $pagination = new Pagination($page, $perPage, $total);
            $paginatedResult = new PaginatedResult($pagination, $results);

            $this->getEntityManager()->commit();

            return $paginatedResult;
        } catch (\Exception $e) {
            $this->getEntityManager()->rollback();
            throw $e;
        }
    }

    public function beginTransation()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->getEntityManager()->commit();
    }

    public function rollbackTransaction()
    {
        $this->getEntityManager()->rollback();
    }

    /**
     * @param callable $callable
     *
     * @return mixed The non-empty value returned from the closure or true instead.
     */
    public function transactional($callable)
    {
        $this->getEntityManager()->transactional($callable);
    }
}
