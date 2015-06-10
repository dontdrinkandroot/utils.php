<?php


namespace Dontdrinkandroot\Service;

use Doctrine\ORM\EntityManagerInterface;

class TransactionManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->entityManager->commit();
    }

    public function rollbackTransaction()
    {
        $this->entityManager->rollback();
    }

    /**
     * @param callable $func
     *
     * @return mixed
     */
    public function transactional($func)
    {
        return $this->entityManager->transactional($func);
    }
}
