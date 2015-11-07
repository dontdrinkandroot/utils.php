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
    public function save($entity, $flush = true)
    {
        if (is_a($entity, 'Dontdrinkandroot\Entity\EntityInterface')) {
            if (null === $entity->getId()) {
                $this->getEntityManager()->persist($entity);
            } else {
                $entity = $this->getEntityManager()->merge($entity);
            }
        } else {
            if (!$this->getEntityManager()->contains($entity)) {
                $this->getEntityManager()->persist($entity);
            }
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity, $flush = true)
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, $flush = true)
    {
        $this->beginTransaction();
        try {
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
    public function removeAll($flush = true, $iterate = true)
    {
        if ($iterate) {
            $this->removeAllByIterating();
        } else {
            $this->removeAllByQuery();
        }
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    protected function removeAllByIterating($batchSize = 100)
    {
        $this->beginTransaction();
        try {
            $entities = $this->findAll();
            $count = 0;
            foreach ($entities as $entity) {
                $this->remove($entity, false);
                $count++;
                if ($count >= $batchSize) {
                    $this->getEntityManager()->flush();
                    $count = 0;
                }
            }
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    protected function removeAllByQuery()
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->delete();
        $query = $queryBuilder->getQuery();
        $query->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function findPaginatedBy($page = 1, $perPage = 10, array $criteria = [], array $orderBy = null)
    {
        $persister = $this->getEntityManager()->getUnitOfWork()->getEntityPersister($this->_entityName);

        $this->beginTransaction();
        try {
            $total = $persister->count($criteria);
            $results = $persister->loadAll($criteria, $orderBy, $perPage, ($page - 1) * $perPage);

            $pagination = new Pagination($page, $perPage, $total);
            $paginatedResult = new PaginatedResult($pagination, $results);

            $this->commitTransaction();

            return $paginatedResult;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function countAll()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('count(entity)')
            ->from($this->getClassName(), 'entity');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function beginTransaction()
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
