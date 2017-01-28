<?php

namespace Application\Tests\Model\Data;

use Application\Model\Data\Solr,
    Application\Tests\BaseModuleTest;

class SolrTest extends BaseModuleTest
{

    public function setUp()
    {
        parent::setUp();

        $this->data = array(
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
            "ck_tipo_inmueble" => [
                [
                    "id" => "casas",
                    "value" => "Casas"
                ],
                [
                    "id" => "departamentos",
                    "value" => "Departamento"
                ]
            ],
            "chkEstadia" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            'empresasAgentes' => array(),
            'distancia' => array(
                'radTipoDistancia' => array(),
                'radDistancia' => array()
            ),
            'fecha' => array(
                'opcion1' => array(
                    'id' =>"17/10/2013 TO 13/11/2013",'value' => "17/10/2013 TO 13/11/2013"
                )
            ),
            'ubicacion' => array(
                ["dep" => [
                    [
                        "id" => "departamento",
                        "value" => "departamento",
                        "type" => 0,
                        "ancestors" => [
                        ]
                    ]
                ]],
                ["pro" => [
                    [
                        "id" => "provincia",
                        "value" => "provincia",
                        "type" => 1,
                        "ancestors" => [
                            ["id" => "departamento","value" => "departamento","type" => 0]
                        ]
                    ]
                ]],
                ["dis" => [
                    [
                        "id" => "distrito1",
                        "value" => "distrito1",
                        "type" => 2,
                        "ancestors" => [
                            [
                                "id" => "24",
                                "value" => "AMAZONAS"
                            ]
                        ]
                    ],
                    [
                        "id" => "28",
                        "value" => "SAN ISIDRO",
                        "type" => 2,
                        "ancestors" => [
                            [
                                "id" => "1",
                                "value" => "LIMA"
                            ]
                        ]
                    ]
                ]],
                ["urb" => [
                ]]
            ),
            "precio" => [
                "rb_tipo_moneda" => [
                    [
                        "id" => "1",
                        "value" => "S/."
                    ]
                ],
                "rb_precio" => [
                    [
                        "id" => "*",
                        "value" => "Cualquiera"
                    ]
                ]
            ],
            'lat' => '',
            'lng' => '',
        );
    }

    public function testUbicacionDepart()
    {
        $this->assertNotEmpty($this->data);
    }

    public function testJsonUbicacionEmpty()
    {
        $data = array(
            'core' => '*',
            "ubicacion" => [
                ["dep" => []],
                ["pro" => []],
                ["dis" => []],
                ["urb" => []]
            ],
            "rb_habitacion" => [
                [
                    "id" => "[* TO *]",
                    "value" => "Todos"
                ]
            ],
            "radDistancia" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            "chkEstadia" => [
                [
                    "id" => "*",
                    "value" => "Todos"
                ]
            ],
            'radProjectState' => [
                [
                    "id" => "1",
                    "value" => "En planos"
                ],
            ],
            "empresasAgentes" => [
                [
                    "id" => "10",
                    "value" => "empresa1"
                ],
                [
                    "id" => "20",
                    "value" => "empresa2"
                ],
                [
                    "id" => "30",
                    "value" => "empresa3"
                ]
            ],
            "precio" => [
                "rb_tipo_moneda" => [
                    [
                        "id" => "1",
                        "value" => "S/."
                    ]
                ],
                "rb_precio" => [
                    [
                        "id" => "*",
                        "value" => "Cualquiera"
                    ]
                ]
            ],
        );

        $resp = array(
            'tipo_mon' => '1',
            'tienda' => [10,20,30]
        );

        $solr = new Solr($data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataProyecto()
    {
        $data = array(
            'core' => 1,
            'fecha' => array(
                'opcion1' => array(
                   array('id' =>"17/10/2013 TO 13/11/2013",'value' => "17/10/2013 TO 13/11/2013")
                )
            ),
            "empresasAgentes" => [
                [
                    "id" => "10",
                    "value" => "empresa1"
                ],
            ],
            "ck_service_adittional" => [
                [
                    "id" => "deposito",
                    "value" => "Deposito"
                ],
                [
                    "id" => "terraza",
                    "value" => "Terraza"
                ],
                [
                    "id" => "cable",
                    "value" => "Cable"
                ],
            ],
            'keyword' => 'busqueda',
            'radProjectState' => [
                [
                    "id" => "1",
                    "value" => "En Planos"
                ],
            ],
            'lat' => 150,
            'lng' => 200,
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
        );
        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'tienda' => 10,
            'deposito' => 1,
            'cable' => 1,
            'terraza' => 1,
            '_search' => [
                'nombre' => 'busqueda',
                'descripcion' => 'busqueda',
                'codigo' => 'busqueda',
                'id' => 'busqueda',
            ],
            'estado_fisico' => '1',
            'entrega' => "[2013-10-17T00:00:00Z TO 2013-11-13T00:00:00Z]",
            'core' => 1,
            'lat' => 150 ,
            'lng' => 200 ,
        );
        $solr = new Solr($data);
        $dataSolr = $solr->generate();

        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataUbicacion()
    {
        $data = array(
            'fecha' => array(
                'opcion1' => array(
                    array('id' =>"13/11/2013",'value' => "13/11/2013")
                )
            ),
            "empresasAgentes" => [
            [
            "id" => "10",
            "value" => "empresa1"
            ],
            ],
            "ck_service_adittional" => [
            [
            "id" => "deposito",
            "value" => "Deposito"
            ],
            [
            "id" => "terraza",
            "value" => "Terraza"
            ],
            [
            "id" => "cable",
            "value" => "Cable"
            ],
            ],
            'keyword' => 'busqueda',
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
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'tienda' => 10,
            'deposito' => 1,
            'cable' => 1,
            'terraza' => 1,
            'fecha_dis1' => "[2013-11-13T00:00:00Z TO *]",
            'fecha_dis2' => "[2013-11-13T00:00:00Z TO *]",
            '_search' => [
            'nombre' => 'busqueda',
            'descripcion' => 'busqueda',
            'codigo' => 'busqueda',
            'id' => 'busqueda',
            ],
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();

        $this->assertEquals($resp, $dataSolr);
        $this->assertArrayHasKey("fecha_dis1",$dataSolr);
        $this->assertArrayHasKey("fecha_dis2",$dataSolr);
    }

    public function testArrayDataUbicacionProvincia()
    {
        $data = array(
            'fecha' => array(
                'opcion1' => array(
                    array('id' =>"17/10/2013 TO 13/11/2013",'value' => "17/10/2013 TO 13/11/2013")
                )
            ),
            'ubicacion' => array(
                [
                    "dep" => [
                        ["id" => "lima", "value" => "LIMA","type" => 0],
                    ]
                ],
                ["pro" => [
                    ["id" => "cajatambo", "value" => "CAJATAMBO","type" => 1,
                        "ancestors" => [
                            ["id" => "lima","value" => "LIMA","type" => 0],
                        ]
                    ]
                ]
                ],
                ["dis" => []],
                ["urb" => []]
            ),
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'cajatambo'],
            ),
            'fecha_dis1' => "[2013-10-17T00:00:00Z TO 2013-11-13T00:00:00Z]",
            'fecha_dis2' => "[2013-10-17T00:00:00Z TO 2013-11-13T00:00:00Z]"
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();

        $this->assertEquals($resp, $dataSolr);
        $this->assertArrayHasKey("fecha_dis1",$dataSolr);
        $this->assertArrayHasKey("fecha_dis2",$dataSolr);
    }

    public function testArrayDataAlquilerTurista()
    {
        $data = array(
            'fecha' => array(
                'opcion1' => array()
            ),
            'rb_estado' =>
            array(
                array('id' => 'alquiler-turista', 'value' => 'alquiler-turista')
            ),
            "radLocalizado" => [
            [
            "id" => "ciudad",
            "value" => "ciudad"
            ]
            ],
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
            "ck_area_construida" => [
            [
            "id" => "area-1",
            "value" => "Area 1"
            ],
            [
            "id" => "area-2",
            "value" => "Area 1"
            ]

            ],
            "ck_area_total" => [
            [
            "id" => "area-1",
            "value" => "Area"
            ],
            [
            "id" => "area-2",
            "value" => "Todos"
            ]

            ],

        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'estado' => 3,
            'localizado' => 1,
            'area_total' => ['area-1','area-2'],
            'area_const' => ['area-1','area-2']
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
        $this->assertArrayNotHasKey("fecha_dist1",$dataSolr);
        $this->assertArrayNotHasKey("fecha_dist2",$dataSolr);
    }

    public function testArrayDataVentaCiudadMinidepartamentoEmptyRoom()
    {
        $data = array(
            "rb_habitacion" => [
            [
            "id" => "[* TO *]",
            "value" => "1 +"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "minidepartamento",
            "value" => "minidepartamento"
            ],
            [
            "id" => "departamento",
            "value" => "departamento"
            ],
            [
            "id" => "casa",
            "value" => "casa"
            ],

            ],
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "radLocalizado" => [
            [
            "id" => 'ciudad',
            "value" => "ciudad"
            ]
            ],
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
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'estado' => 1,
            'localizado' => 1,
            'alias_tipo' => ['minidepartamento','departamento','casa'],
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataVentaCiudadMinidepartamentos()
    {
        $data = array(
            "rb_habitacion" => [
            [
            "id" => "[1 TO *]",
            "value" => "1 +"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "minidepartamento",
            "value" => "minidepartamento"
            ],
            [
            "id" => "departamento",
            "value" => "departamento"
            ],
            [
            "id" => "casa",
            "value" => "casa"
            ],

            ],
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "radLocalizado" => [
            [
            "id" => 'ciudad',
            "value" => "ciudad"
            ]
            ],
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
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'estado' => 1,
            'localizado' => 1,
            'alias_tipo' => ['minidepartamento','departamento','casa'],
            'habitaciones' => "[1 TO *]",
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataVentaCiudad()
    {
        $data = array(
            'rb_estado' =>
            array(
                array('id' => 'venta', 'value' => 'venta')
            ),
            "radLocalizado" => [
            [
            "id" => "ciudad",
            "value" => "ciudad"
            ]
            ],
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
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'estado' => 1,
            'localizado' => 1
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataAlquilerCampo()
    {
        $data = array(
            'rb_estado' =>
            array(
                array('id' => 'alquiler', 'value' => 'alquiler')
            ),
            "radLocalizado" => [
            [
            "id" => "campo",
            "value" => "campo"
            ]
            ],
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
         );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
            'localizado' => 2,
            'estado' => 2
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataUbicacionWithDepAndProvinciaAndDistritoWithOneValue()
    {
        $data = array(
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
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testArrayDataUbicacionWithDepAndProvinciaAndUrb()
    {
        $data = array(
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
            ]
        );

        $resp = array(
            '_ubicacion' => array(
                ['dpto' => 'lima','prov' => 'lima','dist' => 'cercado-de-lima','urb' => 'barrios-altos'],
                ['dpto' => 'lima','prov' => 'lima','dist' => 'santiago-de-surco','urb' => '18-de-noviembre'],
            ),
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

    public function testAlquilerBeachMuchBalnearioWithDistDepartament()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "Casa"
            ],
            ],
            "chkEstadia" => [],
            'distancia' => array(
                'radTipoDistancia' => array(),
                'radDistancia' => array(
                    array(
                        "id" => "*",
                        "value" => "Todos"
                    )
                )
            ),
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'estado'=> 2,
            'localizado' => 3,
            'alias_tipo' => 'casa'
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testAlquilerBeachDistBalnearioWithDistDepartament()
    {
        $data = array(
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
            "id" => 'playa',
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

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'estado'=> 2,
            'localizado' => 3,
            'alias_tipo' => 'casa'

        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachWithDistBalneario()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casas",
            "value" => "casas"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'estado'=> 2,
            'localizado' => 3,
            'alias_tipo' => 'casas'

        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachWithDistTipoInmuebleDepartamentSingle()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casas",
            "value" => "casas"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'estado'=> 2,
            'localizado' => 3,
            'alias_tipo' => 'casas'

        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachTipoInmuebleDepartamentSingle()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casas",
            "value" => "casas"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'estado'=> 2,
            'localizado' => 3,
            'alias_tipo' => 'casas'

        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachDistTipoInmuebleDepartamentMuch()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "casa"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'localizado'=> 3,
            'alias_tipo' => "casa",
            'estado' => 2
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachTipoInmuebleDepartamentMuch()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "casa"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'localizado'=> 3,
            'alias_tipo' => "casa",
            'estado' => 2
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testDataAlquilerBeachDistMuch()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "casa"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'localizado'=> 3,
            'alias_tipo' => "casa",
            'estado' => 2
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);

    }

    public function testAlquilerBeachMuch()
    {
        $data = array(
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
            "id" => 'playa',
            "value" => "playa"
            ]
            ],
            "ck_tipo_inmueble" => [
            [
            "id" => "casa",
            "value" => "casa"
            ],
            ],
            "chkEstadia" => []
        );

        $resp = array(
            '_playa' => array(
                ['dpto'=>'lima' ,'prov' => 'lima' ,'dist' => 'lurin', 'bal' => 'agua-dulce'],
            ),
            'localizado'=> 3,
            'alias_tipo' => "casa",
            'estado' => 2
        );

        $solr = new Solr($data);
        $this->assertEquals($solr->getData(), $data);
        $dataSolr = $solr->generate();
        $this->assertEquals($resp, $dataSolr);
    }

}
