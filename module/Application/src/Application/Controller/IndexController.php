<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $layout = $this->layout();
        $layout->setTemplate('layout/login');
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function registrarseAction()
    {
        if ($this->getRequest()->isPost()) {
           $data= $this->getRequest()->getPost();
           $model = $this->getServiceLocator()->get('UsuarioModel');

           if (!$model->buscarUsuario($data['correo'])) {
                $datos = array(
                    'email' => $data['correo'],
                    'password' => $data['pass']
                );
                $rpt = $model->guardarUsuario($datos);
                if ($rpt) {
                    $this->redirect()->toUrl('/dashboard');
                } else {
                    $this->flashMessenger()->addErrorMessage("Ocurrio un error inesperado, contacte al administrador.");
                    $this->redirect()->toUrl('/registrarse');
                }
            } else {
                $this->flashMessenger()->addErrorMessage("El Email ya existe, Inicie Sesión.");
                    $this->redirect()->toUrl('/');
            }
        }
        $layout = $this->layout();
        $layout->setTemplate('layout/login');
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function dashboardAction()
    {
        return new ViewModel();
    }

    public function modelAction()
    {
        $model = $this->getServiceLocator()->get('TestModel');
        $data = $model->getTestAll();
        return new ViewModel(array("data" => $data));
    }

    public function mongodbAction()
    {
        $Colection = $this->getServiceLocator()->get('TestCollection');
        $data = $Colection->getTest();
        \Zend\Debug\Debug::dump($data);
        return new ViewModel(array("data" => $data));
    }

}
