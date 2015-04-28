<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Dontdrinkandroot\Entity\EntityInterface;

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
