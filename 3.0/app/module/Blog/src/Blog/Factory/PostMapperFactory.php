<?php

namespace Blog\Factory;

use Blog\Model\Post;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;
use Blog\Mapper\ZendDbSqlMapper;

class PostMapperFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ZendDbSqlMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            new Post(),
            new ClassMethods(),
            'posts'
        );
    }
}