<?php


namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;


class NosocomioRestController extends AbstractRestfulController
{

    public function getList()
    {
      $model = $this->getServiceLocator()->get('NosocomioModel');
      $data['data'] = $model->getAllNosocomio();

        return new JsonModel($data);
    }

    public function get($id)
    {
        $data['id'] = $id;
        $model = $this->getServiceLocator()->get('NosocomioModel');
        $data['data'] = $model->getByIdNosocomio($id);

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
