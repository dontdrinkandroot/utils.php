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
    public function save(EntityInterface $entity)
    {
        if (null === $entity->getId()) {
            $this->_em->persist($entity);
        } else {
            $this->_em->merge($entity);
        }
        $this->_em->flush();

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EntityInterface $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id)
    {
        /** @var EntityInterface $entity */
        $entity = $this->find($id);
        $this->remove($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll()
    {
        $queryBuilder = $this->createQueryBuilder('entity');

        $queryBuilder->delete();

        $query = $queryBuilder->getQuery();

        $query->execute();
    }

    /**
     * @deprecated
     */
    public function deleteAll()
    {
        $this->removeAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated($page, $perPage)
    {
        $this->beginTransation();
        try {
            $countQueryBuilder = $this->getEntityManager()->createQueryBuilder();
            $countQueryBuilder
                ->select('count(*)')
                ->from($this->getEntityName(), 'entity');

            $countQueryBuilder = $this->buildFindAllQuery($countQueryBuilder);

            $countQuery = $countQueryBuilder->getQuery();
            $total = $countQuery->getSingleScalarResult();

            $findQueryBuilder = $this->getEntityManager()->createQueryBuilder();
            $findQueryBuilder
                ->select('entity')
                ->from($this->getEntityName(), 'entity');

            $findQueryBuilder = $this->buildFindAllQuery($findQueryBuilder);

            $findQuery = $findQueryBuilder->getQuery();
            $findQuery->setFirstResult(($page - 1) * $perPage);
            $findQuery->setMaxResults($perPage);
            $result = $findQuery->getResult();

            $pagination = new Pagination($page, $perPage, $total);
            $paginatedResult = new PaginatedResult($pagination, $result);

            $this->commitTransaction();

            return $paginatedResult;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }

    /**
     * @param QueryBuilder $countQueryBuilder
     *
     * @return QueryBuilder
     */
    protected function buildFindAllQuery(QueryBuilder $countQueryBuilder)
    {
        return $countQueryBuilder;
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
}
