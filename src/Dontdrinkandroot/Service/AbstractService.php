<?php

namespace Dontdrinkandroot\Service;

use Psr\Log\LoggerInterface;

class AbstractService
{

    /** @var  LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
