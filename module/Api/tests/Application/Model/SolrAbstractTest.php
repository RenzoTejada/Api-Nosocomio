<?php

namespace Application\Tests\Controller;

use Application\Model\SolrAbstract;
use \PHPUnit_Framework_TestCase;
use Application\Tests\Bootstrap;

/**
 * Prueba unitaria de obtencion de datos de solr
 * @author root
 */
class SolrAbstractTest extends PHPUnit_Framework_TestCase
{

    protected $model = null;

//    protected function setUp()
//    {
//        $this->sm = Bootstrap::getServiceManager();
//        $this->model = new SolrAbstract($this->sm->get('Solarium\Client'),
//            'aviso');
//        parent::setUp();
//    }

    public function testReturnDataSolr()
    {
//        $resSolrAvisos = $this->model->setQuery()->getData(1, 10);

    }

}
