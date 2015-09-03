<?php

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
    {

    public function indexAction()
        {
        $user_session = new Container('user');
        $email = $user_session -> email;
        if($user_session -> email)
            {
            echo 'session is active';
            } else
            {
            return $this -> redirect() -> toRoute('register/default',array('controller'=>'index','action'=>'login'));
            }
        return new ViewModel();

        }

    }
