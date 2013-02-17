<?php

require_once __DIR__ . '/../../Document/Structure.php';
require_once __DIR__ . '/../../Document/Structure/Config.php';

class tl extends PHPUnit_Framework_TestCase {

    function testNested() {

        $c = new Pimcore_Document_Structure();

        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP2_');

        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
            $tag->getName()
        );

    }

    function testSibling1() {
        $c = new Pimcore_Document_Structure();
        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP1_');
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
            $tag->addSibling('_ROOT-BLOCK3-BLOCK4-INP2_')->getName()
        );
    }

    function testBlock() {
        $c = new Pimcore_Document_Structure();
        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP1_', null, Pimcore_Document_Structure::NTH_NEXT);
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_2',
            $tag->getName()
        );
    }

    function testBockSibling() {

        $c = new Pimcore_Document_Structure();
        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP1_', null, Pimcore_Document_Structure::NTH_NEXT);
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_2',
            $tag->addSibling('_ROOT-BLOCK3-BLOCK4-INP2_')->getName()
        );
    }


    function testBasicApi() {
        $c = new Pimcore_Document_Structure();
        $c
            ->addChild('_ROOT-BLOCK3_')
                ->addChild('_ROOT-BLOCK3-BLOCK4_')
            ->nextBlock()
                ->addChild('_ROOT-BLOCK3-BLOCK4_')
                ->addSblng('_ROOT-BLOCK3-BLOCK4_2_')
                ->addSblng('_ROOT-BLOCK3-BLOCK4_3_')
                    ->addChild('_SUBBLOCK_')
                        ->addChild('_IN_SUBBLOCK_')
                            ->addChild('_IN_SUBBLOCK_1_')
                            ->addSblng('_IN_SUBBLOCK_2_')
        ;

        $this->assertEquals(
            array(
                '_ROOT-BLOCK3_' => NULL,
                '_ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1' => NULL,
                '_ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1_2' => NULL,
                '_ROOT-BLOCK3-BLOCK4_2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1' => NULL,
                '_ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1' => NULL,
                '_SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1' => NULL,
                '_IN_SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1__SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_11_1_1_1' => NULL,
                '_IN_SUBBLOCK_1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1__SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1__IN_SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1__SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_11_1_1_11_1_1_1_1' => NULL,
                '_IN_SUBBLOCK_2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1__SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1__IN_SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1__SUBBLOCK__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4_3__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_11_1_1_11_1_1_1_1' => NULL,
            ),
            $c->getElements()
        );
    }
}