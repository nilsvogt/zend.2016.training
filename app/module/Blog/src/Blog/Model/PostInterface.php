<?php

namespace Blog\Model;

interface PostInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * Retreive the title of the post
     * @return string
     */
    public function getTitle();

    /**
     * Retreive the text of the post
     * @return string
     */
    public function getText();
}