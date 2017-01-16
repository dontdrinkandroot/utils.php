<?php

namespace Dontdrinkandroot\Test;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @deprecated Use dontdrinkandroot/utils-bundle.php instead.
 */
abstract class AbstractContainerAwareFixture extends AbstractFixture
    implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
