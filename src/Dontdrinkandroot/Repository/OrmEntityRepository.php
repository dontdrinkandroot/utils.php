<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Dontdrinkandroot\Entity\EntityInterface;

class OrmEntityRepository extends EntityRepository
{
    /**
     * @param  EntityInterface $entity
     *
     * @return EntityInterface
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
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * @param mixed $id
     */
    public function removeById($id)
    {
        /** @var EntityInterface $entity */
        $entity = $this->find($id);
        $this->remove($entity);
    }

    public function deleteAll()
    {
        $queryBuilder = $this->createQueryBuilder('entity');

        $queryBuilder->delete();

        $query = $queryBuilder->getQuery();

        $query->execute();
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
