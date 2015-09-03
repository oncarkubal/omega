<?php

namespace Register\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail;
use Zend\Session\Container;
use Register\Form\RegisterForm;
use Register\Form\RegisterFilter;
use Register\Form\LoginForm;
use Register\Form\LoginFilter;

class IndexController extends AbstractActionController
    {
    private $salt = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $method = 'sha1';
    private $usersTable = null;

    public function indexAction()
        {
        $form = new RegisterForm();
        $request = $this -> getRequest();
        if($request -> isPost())
            {
            $form -> setInputFilter(new RegisterFilter());
            $form -> setData($request -> getPost());
            if($form -> isValid())
                {
                $data = $form -> getData();
                unset($data['submit']);
                $data['password'] = $this -> generateRandomString();
                $this -> sendpassword($data['password']);
                $data['password_hash'] = $this -> create($data['password']);
                $data['status'] = 'Y';
                $this -> getUsersTable() -> insert($data);
                return $this -> redirect() -> toRoute('register/default',array('controller'=>'index','action'=>'login'));
                }
            }
        return new ViewModel(array('form'=>$form));

        }

    public function getUsersTable()
        {
        if(!$this -> usersTable)
            {
            $this -> usersTable = new TableGateway(
                    'users',$this -> getServiceLocator() -> get('Zend\Db\Adapter\Adapter')
            );
            }
        return $this -> usersTable;

        }

    public function generateRandomString($length = 10)
        {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0,$charactersLength - 1)];
        }
        return $randomString;

        }

    public function create($password)
        {
        if($this -> method == 'md5')
            {
            return md5($this -> salt . $password);
            } elseif($this -> method == 'sha1')
            {
            return sha1($this -> salt . $password);
            } elseif($this -> method == 'bcrypt')
            {
            $bcrypt = new Bcrypt();
            $bcrypt -> setCost(14);
            return $bcrypt -> create($password);
            }

        }

    public function verify($password,$hash)
        {
        if($this -> method == 'md5')
            {
            return $hash == md5($this -> salt . $password);
            } elseif($this -> method == 'sha1')
            {
            return $hash == sha1($this -> salt . $password);
            } elseif($this -> method == 'bcrypt')
            {
            $bcrypt = new Bcrypt();
            $bcrypt -> setCost(14);
            return $bcrypt -> verify($password,$hash);
            }

        }

    public function sendpassword($password)
        {
        $mail = new Mail\Message();
        $mail -> setBody($password);
        $mail -> setFrom('Freeaqingme@example.org','Sender\'s name');
        $mail -> addTo('Matthew@example.com','Name of recipient');
        $mail -> setSubject('Password');
        $transport = new Mail\Transport\Sendmail();
        $transport -> send($mail);

        }

    public function loginAction()
        {
        $form = new LoginForm();
        $request = $this -> getRequest();
        if($request -> isPost())
            {
            $form -> setInputFilter(new LoginFilter());
            $form -> setData($request -> getPost());
            if($form -> isValid())
                {
                $data = $form -> getData();
                $email = $data['email'];
                $password = $data['password'];
                $data = $this -> getUsersTable() -> select(array('email'=>$email)) -> current();
                if($this -> verify($password,$data['password_hash']))
                    {
                    $user_session = new Container('user');
                    $user_session -> email = $email;
                    return $this -> redirect() -> toRoute('dashboard/default',array('controller'=>'index','action'=>'index'));
                    } else
                    {
                    return $this -> redirect() -> toRoute('register/default',array('controller'=>'index','action'=>'login'));
                    }
                }
            }
        return new ViewModel(array('form'=>$form));

        }

    }
