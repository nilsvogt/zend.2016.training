<?php

namespace Blog\Mapper;

use Blog\Model\PostInterface;

interface PostMapperInterface
{
    /**
     * Find the post by the given id
     * @param uint $id
     * @return PostInterface
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     * @return array|PostInterface[]
     */
    public function findAll();

    /**
     * @param PostInterface $post
     * @return PostInterface
     * @throws \Exception
     */
    public function save(PostInterface $post);

    /**
     * Delete the passed post
     * @param PostInterface $post
     * @return bool
     * @throws \Exception
     */
    public function delete(PostInterface $post);

}