<?php

namespace Blog\Service;

use Blog\Model\PostInterface;

interface PostServiceInterface
{
    /**
     * Retreive all Posts
     * @return array|PostInterface[]
     */
    public function findAllPosts();

    /**
     * @param int $id The id of the Post being queried
     * @return PostInterface
     */
    public function findPost($id);

    /**
     * Creates or updates the passed post
     *
     * @param PostInterface $post
     * @return PostInterface
     */
    public function savePost(PostInterface $post);

    /**
     * Delete the passed post
     *
     * @param PostInterface $post
     * @return bool
     */
    public function deletePost(PostInterface $post);
}