<?php

namespace Blog\Form;

use Blog\Model\Post;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;

class PostFieldset extends Fieldset
{
    public function __construct($name = null, $options = null)
    {
        parent::__construct($name, $options);

        /*
         * Make this fieldset returning a Post instead of a generic array
         * option:use_as_base_fieldset needs to be set when added to the form
         */#
        $this->setHydrator(new ClassMethods(false));
        $this->setObject(new Post());

        $this->add([
            'type' => 'hidden',
            'name' => 'id'
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Post Title'
            ]
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'text',
            'options' => [
                'label' => 'Post copy'
            ]
        ]);
    }
}