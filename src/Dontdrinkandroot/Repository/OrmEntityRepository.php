<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Pagination\PaginatedResult;
use Dontdrinkandroot\Pagination\Pagination;

class OrmEntityRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($entity, $flush = false)
    {
        $this->beginTransaction();
        try {
            $this->getEntityManager()->persist($entity);

            if ($flush) {
                $this->getEntityManager()->flush($entity);
            }

            $this->commitTransaction();

            return $entity;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function merge($entity, $flush = false)
    {
        $this->beginTransaction();
        try {
            $entity = $this->getEntityManager()->merge($entity);

            if ($flush) {
                $this->getEntityManager()->flush($entity);
            }

            $this->commitTransaction();

            return $entity;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity, $flush = false)
    {
        $this->beginTransaction();
        try {
            $this->getEntityManager()->remove($entity);

            if ($flush) {
                $this->getEntityManager()->flush($entity);
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
    public function removeAll($flush = false, $iterate = true)
    {
        $this->beginTransaction();
        try {
            if ($iterate) {
                $this->removeAllByIterating();
            } else {
                $this->removeAllByQuery();
            }

            if ($flush) {
                $this->getEntityManager()->flush();
            }

            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
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
        $this->beginTransaction();
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
        $this->beginTransaction();
        try {
            $queryBuilder = $this->getEntityManager()->createQueryBuilder();
            $queryBuilder
                ->select('count(entity)')
                ->from($this->getClassName(), 'entity');

            $result = $queryBuilder->getQuery()->getSingleScalarResult();

            $this->commitTransaction();

            return $result;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    public function beginTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction()
    {
        $nestingLevel = $this->getEntityManager()->getConnection()->getTransactionNestingLevel();
        if (1 === $nestingLevel) {
            $this->getEntityManager()->flush();
        }
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

    /**
     * @return QueryBuilder
     */
    protected function createBlankQueryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
