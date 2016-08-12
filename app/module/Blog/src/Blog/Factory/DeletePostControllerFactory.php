<?php

namespace Blog\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Blog\Controller\DeletePostController;

class DeletePostControllerFactory implements  FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $postService = $container->get('Blog\Service\PostService');
        $controller = new DeletePostController($postService);
        return $controller;
    }

}