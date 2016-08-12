<?php

namespace Blog\Controller;

use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Blog\Service\PostServiceInterface;
use Zend\View\Model\ViewModel;

class DeletePostController extends AbstractActionController
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService){
        $this->postService = $postService;
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $post = $this->postService->findPost($id);

        $request = $this->getRequest();
        if($request->isPost()){
            if ($request->getPost('validate') === 'delete') {
                $this->postService->deletePost($post);
                $this->redirect()->toRoute('blog');
            } else {
                $this->redirect()->toRoute('blog');
            }
        }

        return new ViewModel([
            'post' => $post
        ]);
    }

}