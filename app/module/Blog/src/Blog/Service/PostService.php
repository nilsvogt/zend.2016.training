<?php

namespace Blog\Service;

use Blog\Mapper\PostMapperInterface;
use Blog\Service\PostServiceInterface;
use Blog\Model\Post;
use Blog\Model\PostInterface;


class PostService implements PostServiceInterface
{
    /**
     * @var PostMapperInterface
     */
    protected $postMapper;

    public function __construct(PostMapperInterface $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * @inheritDoc
     */
    public function findAllPosts()
    {
        return $this->postMapper->findAll();
    }

    /**
     * @inheritDoc
     */
    public function findPost($id)
    {
        return $this->postMapper->find($id);
    }

    /**
     * @inheritDoc
     */
    public function savePost(PostInterface $post)
    {
        $this->postMapper->save($post);
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function deletePost(PostInterface $post)
    {
        return $this->postMapper->delete($post);
    }


}