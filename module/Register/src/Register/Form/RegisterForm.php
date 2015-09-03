<?php

namespace Register\Form;

use Zend\Form\Form;

class RegisterForm extends Form
    {

    public function __construct($name = null)
        {
        // we want to ignore the name passed
        parent::__construct('register');
       
        $this -> add(array(
            'name'=>'full_name',
            'type'=>'Text',
            'options'=>array(
                'label'=>'Full Name',
            ),
        ));
        $this -> add(array(
            'name'=>'email',
            'type'=>'Text',
            'options'=>array(
                'label'=>'Email',
            ),
        ));
        $this -> add(array(
            'name'=>'submit',
            'type'=>'Submit',
            'attributes'=>array(
                'value'=>'Go',
                'id'=>'submitbutton',
            ),
        ));

        }

    }
