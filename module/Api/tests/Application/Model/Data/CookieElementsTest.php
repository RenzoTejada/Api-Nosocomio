<?php

namespace Application\Tests\Model;

use Application\Tests\Bootstrap,
    Application\Model\Data,
    Application\Tests\BaseModuleTest;

class CookieElementsTest extends BaseModuleTest
{
    public function tearDown()
    {
        $this->serviceManager = null;
        $this->formSearchService = null;
        $this->categorie = null;
        $this->cookieSearch = null;
        $this->dataDefaultElements= null;
        $this->dataDefaultBeach = null;
        $this->dataPlaya = null;
    }

    public function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->assertNotEmpty($this->serviceManager);
        $this->formSearchService = $this->serviceManager->get('Application\Service\FormSearchService');
        $this->cookieService = new Data\Cookie();
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

        $this->dataDefaultElements = array(
                'rb_antiguedad' => array('*'),
                'ck_area_construida' => array('*'),
                'ck_area_total' => array('*'),
                'rb_bath' => array(
                    '*'
                ),
                'rb_habitacion' => array(
                    '[* TO *]'
                ),
                'rb_precio' => array(),
                'rb_publicacion' => array(
                    '*'
                ),
                'ck_service_adittional' => array(),
                'ck_tipo_inmueble' => array(
                    '*'
                ),
                'rb_tipo_moneda' => array(
                    '*'
                ),
            );

        $this->dataDefaultBeach = array_merge(
            $this->dataDefaultElements, array(
            "rb_antiguedad" => ["*"],
            "ck_area_construida" => [ "*"],
            "ck_area_total" => [ "*"],
            "rb_bath" => ["*"],
            "rb_cochera" => ["*"],
            "rb_habitacion" => ["[* TO *]"],
            "rb_publicacion" => ["*"],
            'radTipoDistancia' => array(),
            'radDistancia' => array(),
            'radFila' => array("*"),
            "rb_tipo_moneda" => ["*"],
            "rb_precio" => [],
            'ck_service_adittional' => array(),
            'radCama' => array("*")
            )
        );

        $this->dataDefaultCampo = array_merge($this->dataDefaultElements, array(
            "rb_antiguedad" => ["*"],
            "ck_area_construida" => [ "*"],
            "ck_area_total" => [ "*"],
            "rb_bath" => ["*"],
            "rb_cochera" => ["*"],
            "rb_habitacion" => ["[* TO *]"],
            "rb_publicacion" => ["*"],
            "rb_tipo_moneda" => ["*"],
            "rb_precio" => [],
            'ck_service_adittional' => array(),
            )
        );

        $this->dataDefaultProyecto = array_merge($this->dataDefaultElements, array(
            "rb_antiguedad" => ["*"],
            "ck_area_construida" => [ "*"],
            "ck_area_total" => [ "*"],
            "rb_bath" => ["*"],
            "rb_cochera" => ["*"],
            "rb_habitacion" => ["[* TO *]"],
            "rb_publicacion" => ["*"],
            "rb_tipo_moneda" => ["*"],
            "rb_precio" => [],
            'radProjectState' => ['*'],
            'ck_service_adittional' => array(),
            )
        );

        $this->dataDefaultTurista = array_merge($this->dataDefaultElements, array(
            "rb_antiguedad" => ["*"],
            "ck_area_construida" => [ "*"],
            "ck_area_total" => [ "*"],
            "rb_bath" => ["*"],
            "rb_habitacion" => ["[* TO *]"],
            "rb_publicacion" => ["*"],
            "rb_tipo_moneda" => ["1"],
            "rb_precio" => [],
            'ck_service_adittional' => array(),
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
    public function testElementsByUrlPlayaForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler",
            "localizacion" => "playa",
            "tipoCategoria" => "playa",
            "tipoInmueble" => ["casa"],
            "dpto" => "lima",
            "cond" => [
                [
                    "playa" => [
                        "playa1",
                    ],
                ],
                ],
            ];

        $respCookie = array(
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
                ['playa' => array(
                    ["id" => "playa1",'value' => 'playa1',"type" => 1, "ancestors"=>
                    array(
                        ['id' => 'lima','value' => 'lima','type' => 0]
                    )
                    ],
                )]
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

        $elementsCheckeds =array(
            'rb_estado' => array('alquiler'),
            "ck_tipo_inmueble" => array("casa"),
            'rb_tipo_moneda' => ['*'],
            'radTipoDistancia' => array("*")
        );

        $dataResp = array_merge($this->dataDefaultBeach, $elementsCheckeds);
        $categorie = $this->categorie[$request['tipoCategoria']];

        $this->assertEquals($categorie,"playa");
        $contrato = ($categorie == 'turista') ? 'alquiler' : $request[
            'contrato'];
        $this->assertEquals($contrato,"alquiler");

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($this->cookieSearch);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testElementsByUrlProyectoForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "venta",
            "localizacion" => "playa",
            "tipoCategoria" => "proyecto",
            "tipoInmueble" => ["casa"],
            "dpto" => "lima",
            "cond" => [
                [
                    "playa" => [
                        "playa1",
                    ],
                ],
                ],
            ];

        $dataCookie =array(
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
                ['playa' => array(
                    ["id" => "playa1",'value' => 'playa1',"type" => 1, "ancestors"=>
                    array(
                        ['id' => 'lima','value' => 'lima','type' => 0]
                    )
                    ],
                )]
            ),
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
            "chkEstadia" => []
        );

        $cookie =array('search' => json_encode($dataCookie));

        $elementsCheckeds =array(
            'radLocalizado' => array('playa'),
            "ck_tipo_inmueble" => array("casa","departamento"),
            'rb_tipo_moneda' => ['*'],
            'rb_precio' => [],
        );

        $dataResp = array_merge($this->dataDefaultProyecto, $elementsCheckeds);
        $categorie = $this->categorie[$request['tipoCategoria']];

        $categorie = $request['tipoCategoria'];
        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($cookie);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testElementsByUrlCampoForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler",
            "localizacion" => "campo",
            "tipoCategoria" => "campo",
            "tipoInmueble" => ["casa"],
            "dpto" => "lima",
            "cond" => [
                [
                    "playa" => [
                        "playa1",
                    ],
                ],
                ],
            ];

        $dataCookie = array(
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
                ['playa' => array(
                    ["id" => "playa1",'value' => 'playa1',"type" => 1, "ancestors"=>
                    array(
                        ['id' => 'lima','value' => 'lima','type' => 0]
                    )
                    ],
                )]
            ),
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
                ],

            ],
            "chkEstadia" => []
        );

        $cookie =array('search' => json_encode($dataCookie));

        $elementsCheckeds =array(
            'rb_estado' => array('alquiler'),
            "ck_tipo_inmueble" => array("casa","departamento"),
            'rb_tipo_moneda' => ['*'],
            'rb_precio' => [],
        );

        $dataResp = array_merge($this->dataDefaultCampo, $elementsCheckeds);

        $categorie = $request['tipoCategoria'];
        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($cookie);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testElementsByUrlAndCookieTuristaForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler-turista",
            "localizacion" => "ciudad",
            "tipoCategoria" => "turista",
            "tipoInmueble" => ["casa"],
            "pais" => "peru",
            ];

        $dataCookie =array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler-turista', 'value' => 'alquiler-turista')
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
                [
                "id" => "departamento",
                "value" => "Departamento"
                ],

            ],
            "chkEstadia" => [
                [
                    "id" => "1",
                    "value" => "Viajero"
                ],
                [
                    "id" => "4",
                    "value" => "Negocios"
                ],
            ]
        );

        $cookie =array('search' => json_encode($dataCookie));

        $elementsCheckeds =array(
            "ck_tipo_inmueble" => array("casa","departamento"),
            'rb_tipo_moneda' => ['*'],
            'rb_precio' => [],
            'radLocalizado' => ["ciudad"],
            'chkEstadia' => ['1','4']
        );

        $dataResp = array_merge($this->dataDefaultTurista, $elementsCheckeds);
        $categorie = $request['tipoCategoria'];
        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($cookie);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testElementsByUrlAndCookieTuristaPreciosForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "alquiler-turista",
            "localizacion" => "ciudad",
            "tipoCategoria" => "turista",
            "tipoInmueble" => ["casa"],
            "pais" => "peru",
            ];

        $dataCookie =array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler-turista', 'value' => 'alquiler-turista')
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
                [
                "id" => "departamento",
                "value" => "Departamento"
                ],

            ],
            "chkEstadia" => [
                [
                    "id" => "1",
                    "value" => "Viajero"
                ],
                [
                    "id" => "4",
                    "value" => "Negocios"
                ],
            ],
            "rb_habitacion" => [
                [
                    "id" => "[4 TO *]",
                    "value" => "4 +"
                ]
            ]
        );

        $cookie =array('search' => json_encode($dataCookie));

        $elementsCheckeds =array(
            "ck_tipo_inmueble" => array("casa","departamento"),
            'rb_tipo_moneda' => ['*'],
            'rb_precio' => [],
            'radLocalizado' => ["ciudad"],
            'chkEstadia' => ['1','4'],
            'rb_habitacion' => ['[4 TO *]']
        );

        $dataResp = array_merge($this->dataDefaultTurista, $elementsCheckeds);
        $categorie = $request['tipoCategoria'];
        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($cookie);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

    /**
     * @depends testServicesManager
     */
    public function testElementsByVentaUrlAndCookieCiudadForm()
    {
        $depends = array('testServicesManager');

        $this->assertEquals($depends, func_get_args());
        $request =
            [
            "contrato" => "venta",
            "localizacion" => "ciudad",
            "tipoCategoria" => "ciudad",
            "tipoInmueble" => ["habitacion"],
            "pais" => "peru",
            ];

        $dataCookie =array(
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'Venta')
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
                    "value" => "Ciudad"
                ]
            ],
            "ck_tipo_inmueble" => [
                [
                    "id" => "habitacion",
                    "value" => "Habitacion"
                ],
            ],
            "chkEstadia" => [
                [
                    "id" => "1",
                    "value" => "Viajero"
                ],
                [
                    "id" => "4",
                    "value" => "Negocios"
                ],
            ],
            "rb_habitacion" => [
                [
                    "id" => "[4 TO *]",
                    "value" => "4 +"
                ]
            ]
        );

        $cookie =array('search' => json_encode($dataCookie));

        $elementsCheckeds =array(
            "rb_estado" => array("venta"),
            "ck_tipo_inmueble" => array("*"),
            'rb_habitacion' => ["[4 TO *]"],
        );

        $dataResp = array_merge($this->dataDefaultCampo, $elementsCheckeds);
        $categorie = $request['tipoCategoria'];
        $contrato = $this->filterContrato($request);

        $this->formSearchService->setConfigCategorie($categorie);
        $this->formSearchService->setConfigContrato($contrato);

        $this->cookieService->setData($cookie);
        $this->cookieService->setElements($this->formSearchService->getArrayCopy());
        $this->cookieService->setRequest($request);

        $cookieGenerate = $this->cookieService->generate();
        $checkedElements = $this->cookieService->getElements()['checked'];

        $this->assertEquals($checkedElements, $dataResp);
    }

}
