<?php

namespace Register\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
    {

    public function __construct()
        {
        

        $this -> add(
                array(
                    'name'=>'email',
                    'required'=>true,
                    'validators'=>array(
                        array(
                            'name'=>'not_empty',
                        ),
                        array(
                            'name'=>'string_length',
                            'options'=>array(
                                'min'=>5
                            ),
                        ),
                    ),
                )
        );
        
        $this -> add(
                array(
                    'name'=>'password',
                    'required'=>true,
                    'validators'=>array(
                        array(
                            'name'=>'not_empty',
                        ),                        
                    ),
                )
        );

        }

    }
