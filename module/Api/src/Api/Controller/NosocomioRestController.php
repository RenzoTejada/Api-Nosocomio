<?php


namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;


class NosocomioRestController extends AbstractRestfulController
{

    /**
     * Devuelve toda la data de un aviso para solr
     *
     * @return json Description
     */
    public function getList()
    {
        $page = $this->params()->fromQuery("page", 1);
        $agenteModel = $this->getServiceLocator()->get('AvisoInmuebleTable');
        $data = $agenteModel->getAvisosService($page);

        return new JsonModel($data);
    }

    public function get($id)
    {
        $page = $this->params()->fromQuery("page", 1);
        $data['pages'] = $page;
        $model = $this->getServiceLocator()->get('NosocomioModel');
        $data['data'] = $model->getAllNosocomio();

        return new JsonModel($data);
    }

    public function create($data)
    {
        return new JsonModel(array(
            'post' => '',
        ));
    }

    public function update($id, $data)
    {
        return new JsonModel(array(
            'put' => '',
        ));
    }

    public function delete($id)
    {
        return new JsonModel(array(
            'delete' => '',
        ));
    }

}
