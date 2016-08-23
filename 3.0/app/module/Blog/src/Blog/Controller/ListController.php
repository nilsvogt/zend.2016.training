<?php

namespace Blog\Controller;

use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Blog\Service\PostServiceInterface;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    /**
     * @var \Blog\Service\PostServiceInterface;
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postService->findAllPosts()
        ]);
    }

    public function singleAction()
    {
        $id = $this->params()->fromRoute('id');

        return new ViewModel([
            'post' => $this->postService->findPost($id)
        ]);
    }
}