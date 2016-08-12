<?php

namespace Blog\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Blog\Service\PostService;

class PostServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostService($container->get('Blog\Mapper\PostMapperInterface'));
    }

}