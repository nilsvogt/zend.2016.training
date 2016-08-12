<?php

namespace Blog\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Blog\Controller\EditPostController;
use Blog\Form\PostForm;
use Blog\Service\PostService;

class EditPostControllerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $postService = $container->get(PostService::class);
        $postForm = $container->get('Zend\Form\FormElementManager')->get('Blog\Form\PostForm');
        $controller = new EditPostController($postService, $postForm);
        return $controller;
    }
}