<?php

namespace Omega\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class OmegaFilter extends InputFilter
    {

    public function __construct()
        {
        $this -> add(
                array(
                    'name'=>'title',
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
                    'name'=>'artist',
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

        }

    }
