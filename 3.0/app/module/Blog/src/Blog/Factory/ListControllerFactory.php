<?php

namespace Blog\Factory;

use Blog\Controller\ListController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$serviceLocator = $container->getServiceLocator();
        $postService = $container->get('Blog\Service\PostService');
        $controller = new ListController($postService);
        return $controller;
    }
}