<?php

namespace Dontdrinkandroot\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Validator\Constraints\Null;

class AbstractService
{

    /** @var  LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if (null == $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
