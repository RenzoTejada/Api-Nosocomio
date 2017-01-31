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
        if (!$this->verificarSesion()) {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $model = $this->getServiceLocator()->get('UsuarioModel');
                $user = $model->validarUsuario($data['correo'], $data['pass']);
                if ($user) {
                    $session = new \Zend\Session\Container('session');
                    $session->offsetSet('dataUser', $user);
                    $this->redirect()->toUrl('/dashboard');
                } else {
                    $this->flashMessenger()->addErrorMessage("El Email no existe, Registrarse.");
                    $this->redirect()->toUrl('/registrarse');
                }
            }

            $layout = $this->layout();
            $layout->setTemplate('layout/login');
            $viewModel = new ViewModel();
            return $viewModel;
        } else {
            $this->redirect()->toUrl('/dashboard');
        }
    }

    public function registrarseAction()
    {
        if (!$this->verificarSesion()) {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
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
        } else {
            $this->redirect()->toUrl('/dashboard');
        }
    }

    public function dashboardAction()
    {
        $session = $this->verificarSesion();
        if ($session) {
            $this->layout()->user = $session['email'];
            return new ViewModel();
        } else {
            $this->redirect()->toUrl('/');
        }
    }
    
    public function callAction()
    {
        $session = $this->verificarSesion();
        if ($session) {
            
            return new ViewModel();
        } else {
            $this->redirect()->toUrl('/');
        }
    }
    
    public function mapsAction()
    {
        $session = $this->verificarSesion();
        if ($session) {
            
            return new ViewModel();
        } else {
            $this->redirect()->toUrl('/');
        }
    }

    public function logoutAction()
    {
        $session = new \Zend\Session\Container('session');
        if ($session->offsetExists('dataUser')) {
            $session->offsetUnset('dataUser');
        }
        $this->redirect()->toUrl('/');
    }

    function verificarSesion()
    {
        $session = new \Zend\Session\Container('session');
        $rpt = FALSE;
        if ($session->offsetExists('dataUser')) {
            $rpt = $session->offsetGet('dataUser');
        }
        return $rpt;
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
