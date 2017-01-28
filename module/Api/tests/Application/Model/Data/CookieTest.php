<?php

namespace Application\Tests\Model;

use Application\Tests\Bootstrap,
    Application\Model\Data,
    Application\Tests\BaseModuleTest;

class CookieTest extends BaseModuleTest
{
    public function tearDown()
    {
        $this->serviceManager = null;
        $this->formSearchService = null;
        $this->formSearchService = null;
        $this->categorie = null;
        $this->cookieSearch = null;
        $this->dataDefault = null;
        $this->dataDefaultBeach = null;
        $this->dataPlaya = null;
        $this->dataTurista = null;
        $this->data = null;

    }

    public function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->assertNotEmpty($this->serviceManager);
        $this->formSearchService = $this->serviceManager->get('Application\Service\FormSearchService');
        $solrClient = $this->serviceManager->get('Solarium\Client');
        $this->cookieService = new Data\Cookie();
        $this->cookieService->setSolrClient($solrClient);

        $this->categoriesValueDefault = array(
            'proyecto' => null,
            'turista' => 'alquiler'
        );
        $this->categorie = [
            'proyecto' => 'proyecto',
            'ciudad' => 'ciudad',
            'playa' => 'playa',
            'turista' => 'turista',
            'campo' => 'campo'
            ];

        $this->cookieSearch = array(
                'ZF_session' => array(),
                'cX_S' => array()
            );

        $this->dataDefault = array(
            "rb_antiguedad" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            "ck_area_construida" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            "ck_area_total" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            "rb_bath" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            "rb_habitacion" => [
            [
            "id" => "[* TO *]",
            "value" => "Todos"
            ]
            ],
            "rb_publicacion" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "rb_cochera" => [
                [
                "id" => "*",
                "value" => "Todos"
                ]
            ],
            'distancia' => array(
                'radTipoDistancia' => array(),
                'radDistancia' => array()
            ),
            'fecha' => array(
                    'opcion1' => array()
            ),
            'empresasAgentes' => array(),
            "precio" => [
                "rb_tipo_moneda" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
                ],
                "rb_precio" => [
                ]
            ],
            'radFila' => array(),
            'radCama' => array(),
            'ck_service_adittional' => array(),
            'playas' => array(
                ['dep' => [] ],
                ['pro' => [] ],
                ["dis" => [] ],
                ['playa' => [] ]
            ),
            'radProjectState' => [],
            'keyword' => '',
            'core' => '*',
            'lat' => '',
            'lng' => ''
        );

        $this->dataDefaultBeach = array(
            "rb_antiguedad" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "ck_area_construida" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "ck_area_total" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "rb_bath" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "rb_cochera" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "rb_habitacion" => [
            [
            "id" => "[* TO *]",
            "value" => "Todos"
            ]
            ],
            "rb_publicacion" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            'distancia' => array(
                'radTipoDistancia' => array(
                    [
                    "id" => "*",
                    "value" => "Todos"
                    ]
                ),
                'radDistancia' => array()
            ),
            'fecha' => array(
                'opcion1' => array()
            ),
            'empresasAgentes' => array(),
            "precio" => [
            "rb_tipo_moneda" => [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "rb_precio" => [
            ]
            ],
            'radFila' => array(),
            'radCama' => array(),
            'ck_service_adittional' => array(),
            'keyword' => '',
            'radProjectState' => array(),
            'core' => '*',
            'lat' => '',
            'lng' => ''

        );

        $this->dataPlaya = array_merge(
            $this->dataDefaultBeach,
            array(
                'radFila' => array(
                    array(
                        "id" => "*",
                        "value" => "Todos"
                    )
                ),
                'radCama' => array(
                    array(
                        "id" => "*",
                        "value" => "Todos"
                    )
                ),
                'distancia' => array(
                    'radTipoDistancia' => array(
                        [
                        "id" => "*",
                        "value" => "Todos"
                        ]
                    ),
                    'radDistancia' => array()
                ),

            )
        );

        $this->dataTurista = array_merge(
            $this->dataDefault,
            array(
                "rb_cochera" => [],
            )
        );

        $this->data = array_merge(
            $this->dataDefault,
            array(
                "rb_cochera" => [
                [
                "id" => "*",
                "value" => "Todos"
                ]
                ],
                'radFila' => array(
                    array(
                        "id" => "*",
                        "value" => "Todos"
                    )
                ),
                'radCama' => array(
                    array(
                        "id" => "*",
                        "value" => "Todos"
                    )
                ),
                'distancia' => array(
                    'radTipoDistancia' => array(
                        [
                        "id" => "*",
                        "value" => "Todos"
                        ]
                    ),
                    'radDistancia' => array()
                ),
            )
        );
    }

    private function filterContrato($request)
    {
        if (in_array($request['tipoCategoria'],array_keys($this->categoriesValueDefault))) {
            return $this->categoriesValueDefault[$request['tipoCategoria']];
        }

        return $request['contrato'];
    }

    public function testServicesManager()
    {
        $this->assertNotEmpty($this->serviceManager);
        $formSearchService = $this->serviceManager->get('Application\Service\FormSearchService');
        $this->assertInstanceOf('Application\Service\FormSearchService',
            $formSearchService);

        return "testServicesManager";
    }

    /**
     * @depends testServicesManager
     */
    public function testDataVentaCiudadTipoInmueblePeru()
    {
        $depends = array(
            'testServicesManager'
        );

        $this->assertEquals($depends, func_get_args());

        $request = [
            "contrato" => "venta",
            "localizacion" => "ciudad",
            "tipoCategoria" => "ciudad",
            "search" => array(
                "url" => "busqueda-busqueda",
                "desc" => "busqueda busqueda"
            ),
            "tipoInmueble" => ["tipo1", "tipo2"],
            "pais" => "peru"
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            "radLocalizado" => [
            [
            "id" => "ciudad",
            "value" => "ciudad"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "departamento",
            "value" => "Departamento"
            ],
            [
            "id" => "casa",
            "value" => "Casa"
            ],

            ],
            "chkEstadia" => [],
            'distancia' => array(
                'radTipoDistancia' => array(
                    array('id' => 1, "value" => "Norte")
                ),
                'radDistancia' => array()
            ),
            'keyword' => 'busqueda busqueda',
            'core' => '*'
        );

        $dataCookie =array(
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            "radLocalizado" => [
            [
            "id" => "campo",
            "value" => "campo"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "Casotas",
            "value" => "Casotas"
            ],
            [
            "id" => "departamento",
            "value" => "Departamento"
            ],
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            'distancia' => array(
                'radTipoDistancia' => array(
                    array('id' => 1, "value" => "Norte")
                ),
                'radDistancia' => array()
            ),
            "chkEstadia" => [],
            'keyword' => 'busqueda',
            'core' => '1'
        );

        $cookie =array('search' => json_encode($dataCookie));

        $dataResp = array_merge($this->dataDefault, $resp);

        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->assertNotEmpty($cookie);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setData($cookie);
        $this->cookieService->setRequest($request);
        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataAlquilerCampoTipoInmuebleenPeru()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request = [
            "contrato" => "alquiler",
            "localizacion" => "campo",
            "tipoCategoria" => "campo",
            "search" => array(
                "url" => "busqueda",
                "desc" => "busqueda"
            ),
            "tipoInmueble" => ["casa", "tipo2"],
            "pais" => "peru"];
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setData($this->cookieSearch);

        $this->cookieService->setRequest($request);
        $cookieData = $this->cookieService->generate();
        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler', 'value' => 'alquiler')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            "radLocalizado" => [
            [
            "id" => "campo",
            "value" => "campo"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "keyword" => "busqueda",
            "chkEstadia" => [],
        );

        $dataResp = array_merge($this->dataDefault, $resp);

        $this->assertNotEmpty($cookieData);
        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataProyectoDistritos()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request = [
            "contrato" => "venta",
            "localizacion" => "",
            "tipoCategoria" => "proyecto",
            "tipoInmueble" => ["inmuebles"],
            "dpto" => "lima",
            "cond" => [
            [
                "dist" => [
                    "cercado-de-lima",
                ],
            ],
            [
                "dist" => [
                    "santiago-de-surco"
                ],
                "urb" => [
                    "18-de-noviembre"
                ],
            ],
            ],
            ];

        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setData($this->cookieSearch);

        $this->cookieService->setRequest($request);
        $cookieData = $this->cookieService->generate();
        $resp = array(
            'rb_estado' =>[],
            'radProjectState' =>
            [
            [
            "id" => "*",
            "value" => "Todos"
            ]
            ],
            "ubicacion" => [
            ["dep" => [ array('id' => 'lima', 'value' => 'lima','type' => 0)]],
            ["pro" => [
                ["id" => "lima","value" => "LIMA","type" => 1,
                    "ancestors" => [[ "id" => "lima","value" => "lima","type" => 0],]
                ],
            ]],
            ["dis" => [
                ["id" => "cercado-de-lima","value" => "cercado-de-lima","type" => 2,
                "ancestors" => [
                    [ "id" => "lima","value" => "lima","type" => 0],
                    ["id" => "lima","value" => "LIMA","type" => 1]
                ]
                ],
                ["id" => "santiago-de-surco","value" => "santiago-de-surco","type" => 2,
                "ancestors" => [
                    ["id" => "lima","value" => "lima", "type" => 0],
                    ["id" => "lima","value" => "LIMA","type" => 1]
                ]
                ]
            ]
            ],
            ["urb" => [
                ["id" => "18-de-noviembre","value" => "18-de-noviembre","type" => 3,
                    "ancestors" => [
                        ["id" => "lima","value" => "lima","type" => 0],
                        ["id" => "lima","value" => "LIMA","type" => 1],
                        ["id" => "santiago-de-surco","value" => "santiago-de-surco", "type" => 2]
                    ]
                ],
                ]
            ]
                ],
                "radLocalizado" => [
                [
                'id'=> '*',
                'value' => 'Todos'
                ]
                ],
                "ck_tipo_inmueble" => [
                [
                "id" => "*",
                "value" => "Todos"
                ],
                ],
                "chkEstadia" => [],
                "core" => 1
            );

        $dataResp = array_merge($this->dataDefault, $resp);

        $this->assertNotEmpty($cookieData);
        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataAlquilerCampoDepartamentoDistritoUrbanizacion()
    {
        $depends = array(
            'testServicesManager'
        );

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler",
            "localizacion" => "campo",
            "tipoCategoria" => "campo",
            "tipoInmueble" => [
            "casa",
            "departamento",
            ],
            "dpto" => "lima",
            "cond" => [
            [
            "dist" => [
            "cercado-de-lima"
            ],
            ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler', 'value' => 'alquiler')
            ),
            "ubicacion" => [
            [
            "dep" => [
            array('id' => 'lima', 'value' => 'lima','type' => 0)
            ]
            ],
            ["pro" => [
            ["id" => "lima","value" => "LIMA","type" => 1,
            "ancestors" => [[ "id" => "lima","value" => "lima","type" => 0],]
            ]
            ]],
            ["dis" => [
            ["id" => "cercado-de-lima", "value" => "cercado-de-lima", "type" => 2,
            "ancestors" => [
            ["id" => "lima","value" => "lima","type" => 0],
            ["id" => "lima","value" => "LIMA","type" => 1],
            ]
            ],
            ]
            ],
            ["urb" => []]
            ],
            "radLocalizado" => [
            [
            "id" => "campo",
            "value" => "campo"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            [
            "id" => "departamento",
            "value" => "Departamento"
            ]
            ],
            "chkEstadia" => [],
        );

        $dataResp = array_merge($resp, $this->dataDefault);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);
        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataVentaDistBeachOnlyDepartament()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =[
            "contrato" => "venta",
            "localizacion" => "playa",
            "tipoCategoria" => "playa",
            "tipoInmueble" => [
            "casa"
            ],
            "dpto" => "lima",
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            'playas' => array(
                ['dep' => [
                    array(
                        'id' => 'lima', 'value' => 'lima','type' => 0
                    )
                ]
                ],
                ['pro' => []],
                ['dis' => []],
                ['playa' => []]
            ),
            "radLocalizado" => [
            [
            "id" => "playa",
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "chkEstadia" => []
        );

        $dataResp = array_merge($this->dataPlaya, $resp);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataVentaDistBeach()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =[
            "contrato" => "venta",
            "localizacion" => "playa",
            "tipoCategoria" => "playa",
            "tipoInmueble" => [
            "casa"
            ],
            "dpto" => "lima",
            "cond" => [
                [
                    "dist" => [
                        "lurin",
                    ],
                    "playa" => [
                        "agua-dulce",
                    ]
                ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            'playas' => array(
                ['dep' => [
                array('id' => 'lima', 'value' => 'lima','type' => 0)
                ]
                ],
                ["pro" => [
                    ["id" => "lima","value" => "LIMA","type" => 1,
                    "ancestors" => [
                            [ "id" => "lima","value" => "lima","type" => 0],
                        ]
                    ],
                ]],
                ["dis" => [
                    ["id" => "lurin","value" => "lurin","type" => 2,
                    "ancestors" => [
                        [ "id" => "lima","value" => "lima","type" => 0],
                        ["id" => "lima","value" => "LIMA","type" => 1]
                    ]
                    ],
                ]
                ],
                ['playa' => [
                    ['id' => 'agua-dulce', 'value' => 'agua-dulce','type' => 3,
                    "ancestors" => [
                        ["id" => "lima","value" => "lima","type" => 0],
                        ["id" => "lima","value" => "LIMA","type" => 1],
                        ["id" => "lurin","value" => "lurin","type" => 2]
                    ]
                    ]
                ]]
            ),
            "radLocalizado" => [
            [
            "id" => "playa",
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "chkEstadia" => []
        );

        $dataResp = array_merge($this->dataPlaya, $resp);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);
        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataAlquilerBeachTipoInmuebleDepartamentMuch()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler",
            "localizacion" => "playa",
            "tipoCategoria" => "playa",
            "tipoInmueble" => [
            "casa"
            ],
            "dpto" => "lima",
            "cond" => [
                [
                    "dist" => [
                        "lurin",
                    ],
                    "playa" => [
                        "agua-dulce",
                    ]
                ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler', 'value' => 'alquiler')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            'playas' => array(
                ['dep' => [
                array('id' => 'lima', 'value' => 'lima','type' => 0)
                ]
                ],
                ["pro" => [
                    ["id" => "lima","value" => "LIMA","type" => 1,
                        "ancestors" => [[ "id" => "lima","value" => "lima","type" => 0],]
                    ],
                ]],
                ["dis" => [
                    ["id" => "lurin","value" => "lurin","type" => 2,
                    "ancestors" => [
                        [ "id" => "lima","value" => "lima","type" => 0],
                        ["id" => "lima","value" => "LIMA","type" => 1]
                    ]
                    ],
                ]
                ],
                ['playa' => [
                    ['id' => 'agua-dulce', 'value' => 'agua-dulce','type' => 3,
                    "ancestors" => [
                        [ "id" => "lima","value" => "lima","type" => 0],
                        ["id" => "lima","value" => "LIMA","type" => 1],
                        ["id" => "lurin","value" => "lurin","type" => 2]
                    ]
                    ]
                ]]
            ),
            "radLocalizado" => [
            [
            "id" => "playa",
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "chkEstadia" => []
        );

        $dataResp = array_merge($resp, $this->dataPlaya);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataAlquilerBeachTipoInmuebleDepartamentSingle()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler",
            "localizacion" => "playa",
            "tipoCategoria" => "playa",
            "tipoInmueble" => [
            "casa"
            ],
            "dpto" => "lima",
            "cond" => [
                [
                    "dist" => ["chorrillos"],
                ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler', 'value' => 'alquiler')
            ),
            "ubicacion" => [
            ["dep" => []],
            ["pro" => []],
            ["dis" => []],
            ["urb" => []]
            ],
            'playas' => array(
                ['dep' => [
                    array('id' => 'lima', 'value' => 'lima','type' => 0)
                    ]
                ],
                ["pro" => [
                    ["id" => "lima","value" => "LIMA","type" => 1,
                        "ancestors" => [
                            [ "id" => "lima", "value" => "lima", "type" => 0],
                        ]
                    ],
                ]],
                ['dis' => [
                    ["id" => "chorrillos","value" => "chorrillos","type" => 2,
                            "ancestors" => [
                                ["id" => "lima","value" => "lima","type" => 0],
                                ["id" => "lima","value" => "LIMA","type" => 1],
                            ]
                    ],
                ]],
                ['playa' => []],
            ),
            "radLocalizado" => [
            [
            "id" => "playa",
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "chkEstadia" => []
        );

        $dataResp = array_merge($resp, $this->dataPlaya);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();
        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataAlquilerTurista()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request = [
            "contrato" => "alquiler-turista",
            "localizacion" => "ciudad",
            "tipoCategoria" => "turista",
            "tipoInmueble" => [
                "casa",
                "departamento"
            ],
            "dpto" => "lima",
            "cond" => [
                [
                    "dist" => [
                        "cercado-de-lima",
                    ],
                    "urb" => [
                        "barrios-altos"
                    ],
                ],
                [
                    "dist" => [
                    "santiago-de-surco"
                    ],
                    "urb" => [
                    "18-de-noviembre"
                    ],
                ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler-turista', 'value' => 'alquiler-turista')
            ),
            "ubicacion" => [
                ["dep" => [ array('id' => 'lima', 'value' => 'lima','type' => 0)]],
                ["pro" => [
                    ["id" => "lima","value" => "LIMA","type" => 1,
                        "ancestors" => [
                            [ "id" => "lima", "value" => "lima", "type" => 0],
                        ]
                    ],
                ]],
                ["dis" => [
                    ["id" => "cercado-de-lima","value" => "cercado-de-lima","type" => 2,
                        "ancestors" => [
                            ["id" => "lima","value" => "lima","type" => 0],
                            ["id" => "lima","value" => "LIMA","type" => 1],
                        ]
                    ],
                    ["id" => "santiago-de-surco","value" => "santiago-de-surco","type" => 2,
                        "ancestors" => [
                            ["id" => "lima", "value" => "lima", "type" => 0],
                            ["id" => "lima", "value" => "LIMA", "type" => 1],
                        ]
                    ]
                ]
                ],
                ["urb" => [
                    ["id" => "barrios-altos","value" => "barrios-altos","type" => 3,
                        "ancestors" => [
                            ["id" => "lima","value" => "lima","type" => 0],
                            ["id" => "lima", "value" => "LIMA", "type" => 1],
                            ["id" => "cercado-de-lima","value" => "cercado-de-lima", "type" => 2]
                        ]
                    ],
                    ["id" => "18-de-noviembre","value" => "18-de-noviembre","type" => 3,
                        "ancestors" => [
                            ["id" => "lima","value" => "lima","type" => 0],
                            ["id" => "lima", "value" => "LIMA", "type" => 1],
                            ["id" => "santiago-de-surco","value" => "santiago-de-surco", "type" => 2]
                    ]
                    ],
                ]
                ]
                ],
                "radLocalizado" => [
                [
                "id" => "ciudad",
                "value" => "ciudad"
                ]
                ],
                "ck_tipo_inmueble" => [
                [
                "id" => "casa",
                "value" => "Casa"
                ],
                [
                "id" => "departamento",
                "value" => "Departamento"
                ],
                ],
                "chkEstadia" => [
                ['id' => '*', 'value' => 'Todos']
                ],
            );

        $dataResp = array_merge($resp, $this->dataTurista);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();

        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testDataTurista()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request = [
            "contrato" => "alquiler-turista",
            "localizacion" => "",
            "tipoCategoria" => "turista",
            "tipoInmueble" => [
            "casa",
            "departamento"
            ],
            "dpto" => "lima",
            "cond" => [
            [
            "dist" => [
            "cercado-de-lima",
            ],
            "urb" => [
            "barrios-altos"
            ],
            ],
            [
            "dist" => [
            "santiago-de-surco"
            ],
            "urb" => [
            "18-de-noviembre"
            ],
            ],
            ],
            ];

        $resp = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler-turista', 'value' => 'alquiler-turista')
            ),
            "ubicacion" => [
            ["dep" => [ array('id' => 'lima', 'value' => 'lima','type' => 0)]],
                ["pro" => [
                ["id" => "lima","value" => "LIMA","type" => 1,
                "ancestors" => [[ "id" => "lima","value" => "lima","type" => 0],]
                ]
                ]
                ],
                ["dis" => [
                ["id" => "cercado-de-lima","value" => "cercado-de-lima","type" => 2,
                "ancestors" => [
                [ "id" => "lima","value" => "lima","type" => 0],
                [ "id" => "lima","value" => "LIMA","type" => 1],
                ]
                ],
                ["id" => "santiago-de-surco","value" => "santiago-de-surco","type" => 2,
                "ancestors" => [
                [ "id" => "lima","value" => "lima","type" => 0],
                [ "id" => "lima","value" => "LIMA","type" => 1],
                ]
                ]
                ]
                ],
                ["urb" => [
                ["id" => "barrios-altos","value" => "barrios-altos","type" => 3,
                "ancestors" => [
                ["id" => "lima","value" => "lima","type" => 0],
                ["id" => "lima","value" => "LIMA","type" => 1],
                ["id" => "cercado-de-lima","value" => "cercado-de-lima", "type" => 2]
                ]
                ],
                ["id" => "18-de-noviembre","value" => "18-de-noviembre","type" => 3,
                "ancestors" => [
                ["id" => "lima","value" => "lima","type" => 0],
                ["id" => "lima","value" => "LIMA","type" => 1],
                ["id" => "santiago-de-surco","value" => "santiago-de-surco", "type" => 2]
                ]
                ],
                ]
                ]
                ],
                "radLocalizado" => [
                [
                "id" => "*",
                "value" => "Todos"
                ]
                ],
                "ck_tipo_inmueble" => [
                [
                "id" => "casa",
                "value" => "Casa"
                ],
                [
                "id" => "departamento",
                "value" => "Departamento"
                ],
                ],
                "chkEstadia" => [
                ['id' => '*', 'value' => 'Todos']
                ],
            );

        $dataResp = array_merge($resp, $this->dataTurista);
        $categorie = $request['tipoCategoria'];

        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setRequest($request);

        $cookieData = $this->cookieService->generate();

        $this->assertNotEmpty($cookieData);

        $this->assertEquals($cookieData, $dataResp);
    }

}
