<?php

namespace Omega\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use Omega\Form\OmegaForm;
use Omega\Form\OmegaFilter;

class IndexController extends AbstractActionController
    {
    private $usersTable;

    public function indexAction()
        {

        return new ViewModel(
                array(
            'rowset'=>$this -> getUsersTable() -> select()
                )
        );

        }

    public function updateAction()
        {
        $id = $this -> params() -> fromRoute('id');
        if($id)
            {
            $form = new OmegaForm();
            $request = $this -> getRequest();
            if($request -> isPost())
                {
                $form -> setInputFilter(new OmegaFilter());
                $form -> setData($request -> getPost());
                if($form -> isValid())
                    {
                    $data = $form -> getData();
                    unset($data['submit']);
                    $this -> getUsersTable() -> update($data,array('id'=>$id));
                    return $this -> redirect() -> toRoute('omega/default',array('controller'=>'index','action'=>'index'));
                    }
                } else
                {
                $form -> setData($this -> getUsersTable() -> select(array('id'=>$id)) -> current());
                }
            } else
            {
            $this -> redirect() -> toRoute('omega/default',array('controller'=>'index','action'=>'index'));
            }
        return new ViewModel(array('form'=>$form,'id'=>$id));

        }

    public function createAction()
        {
        $form = new OmegaForm();
        $request = $this -> getRequest();
        if($request -> isPost())
            {
            $form -> setInputFilter(new OmegaFilter());
            $form -> setData($request -> getPost());
            if($form -> isValid())
                {
                $data = $form -> getData();
                unset($data['submit']);
                $this -> getUsersTable() -> insert($data);
                return $this -> redirect() -> toRoute('omega/default',array('controller'=>'index','action'=>'index'));
                }
            }
        return new ViewModel(array('form'=>$form));

        }

    public function deleteAction()
        {
        $id = $this -> params() -> fromRoute('id');
        if($id)
            {
            $this -> getUsersTable() -> delete(array('id'=>$id));
            }
        $this -> redirect() -> toRoute('omega/default',array('controller'=>'index','action'=>'index'));

        }

    public function getUsersTable()
        {
        if(!$this -> usersTable)
            {
            $this -> usersTable = new TableGateway(
                    'album',$this -> getServiceLocator() -> get('Zend\Db\Adapter\Adapter')
                );
            }
        return $this -> usersTable;

        }

    }
