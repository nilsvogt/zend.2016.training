<?php

namespace Blog\Controller;

use Blog\Model\PostInterface;
use Blog\Service\PostServiceInterface;
use Zend\Debug\Debug;
use Zend\Form\View\Helper\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;

class EditPostController extends AbstractActionController
{
    /**
     * @var PostService
     */
    protected $postService;

    /**
     * @var PostForm
     */
    protected $postForm;

    public function __construct(PostServiceInterface $postService, FormInterface $postForm)
    {
        $this->postService = $postService;
        $this->postForm = $postForm;
    }

    public function createAction()
    {
        if ($post = $this->processForm()) {
            $this->redirect()->toRoute('blog/edit', ['id' => $post->getId()]);
        }

        return new ViewModel([
            'form' => $this->postForm
        ]);
    }

    public function editAction()
    {
        $id = $this->params('id');
        $post = $this->postService->findPost($id);

        if($this->processForm($post)){
            // prevent form from being submitted again just by user refreshing the page
            $this->redirect()->toRoute('blog/edit', ['id' => $post->getId()]);
        }

        return new ViewModel([
            'post' => $post,
            'form' => $this->postForm
        ]);
    }

    protected function processForm(PostInterface $post = null)
    {
        if($post){
            $this->postForm->bind($post);
        }

        $request = $this->getRequest();

        if($request->isPost()){
            $this->postForm->setData($request->getPost());

            if($this->postForm->isValid()){
                try{
                    $post = $this->postService->savePost($this->postForm->getData());
                    $this->postForm->bind($post);
                    return $post;
                }catch (\Exception $e){
                    // TODO: Handle error appropriately
                    die(sprintf("%s: %s", self::class, $e->getMessage()));
                }
            }
        }
    }
}