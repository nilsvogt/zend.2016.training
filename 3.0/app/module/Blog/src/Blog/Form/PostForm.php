<?php

namespace Blog\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct($name = null, $options = null)
    {

        parent::__construct($name, $options);

        $this->add([
            'name' => 'post-fieldset',
            'type' => 'Blog\Form\PostFieldset',
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'save post'
            ]
        ]);
    }
}