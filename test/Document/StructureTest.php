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
        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP1_', null, 2);
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_2',
            $tag->getName()
        );
    }

    function testBockSibling() {

        $c = new Pimcore_Document_Structure();
        $tag = $c->addChild('_ROOT-BLOCK3_')->addChild('_ROOT-BLOCK3-BLOCK4_')->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addChild('_ROOT-BLOCK3-BLOCK4-INP1_');
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_2',
            $tag->addSibling('_ROOT-BLOCK3-BLOCK4-INP2_', null, 2)->getName()
        );
    }


    function testBasicApi() {

        require_once __DIR__.'/../../../../../pimcore/cli/startup.php';

        $c = new Pimcore_Document_Structure();

        $getNewDocumentTag = function($txt) {
            $tag = new \Document_Tag_Input('just ignore the name here...');
            $tag->setDataFromEditmode('TEXT_'.$txt);
            return $tag;
        };

        $getNewDocumentTagBlock = function($txt) {
            $tag = new \Document_Tag_Block('just ignore the name here...');
            $tag->setDataFromEditmode('TEXT_'.$txt);
            return $tag;
        };


        $c
            ->addChild('_ROOT-INP_', $getNewDocumentTag('_ROOT-INP_'))
            ->addSblng('_ROOT-INP2_', $getNewDocumentTag('_ROOT-INP2_'))
            ->addSblng('_ROOT-BLOCK3_', $getNewDocumentTagBlock('_ROOT-BLOCK3_'))
                ->addChild('_ROOT-BLOCK3-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-INP1_'))
                ->addSblng('_ROOT-BLOCK3-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-INP2_'))
                ->addSblng('_ROOT-BLOCK3-INP3_', $getNewDocumentTag('_ROOT-BLOCK3-INP3_'))
                ->addSblng('_ROOT-BLOCK3-BLOCK4_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4_'))
                    ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_'))
                        ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_'))
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_'))
                    ->Up()
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP1_'))
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP2_'))
                ->Up()
            ->Up()
            ->addSblng('_ROOT-BLOCK3_', $getNewDocumentTagBlock('_ROOT-BLOCK3_'))
                ->addChild('_ROOT-BLOCK3-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-INP1_2'), 2)
                    ->addSblng('_ROOT-BLOCK3-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-INP2_2'), 2)
                    ->addSblng('_ROOT-BLOCK3-INP3_', $getNewDocumentTag('_ROOT-BLOCK3-INP3_2'), 2)
                    ->addSblng('_ROOT-BLOCK3-BLOCK4_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4_2'), 2)
                        ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_2'))
                        ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_2'))
                        ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_2'))
                    ->Up()
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_2'))
                    ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_NEXT_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_2'), 2)
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_NEXT_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_2'), 2)
                ->Up()
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP1_2'))
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP2_2'))
        ;

        $this->assertEquals(
            array_keys($c->getElements()),
            array(
                '_ROOT-INP_',
                '_ROOT-INP2_',
                '_ROOT-BLOCK3_',
                '_ROOT-BLOCK3-INP1__ROOT-BLOCK3_1',
                '_ROOT-BLOCK3-INP2__ROOT-BLOCK3_1',
                '_ROOT-BLOCK3-INP3__ROOT-BLOCK3_1',
                '_ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1',
                '_ROOT-BLOCK3-BLOCK4-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1',
                '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
                '_ROOT-BLOCK3-INP1__ROOT-BLOCK3_2',
                '_ROOT-BLOCK3-INP2__ROOT-BLOCK3_2',
                '_ROOT-BLOCK3-INP3__ROOT-BLOCK3_2',
                '_ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_2',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_1',
                '_ROOT-BLOCK3-BLOCK4-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_1',
                '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_2__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_12_1_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_2__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_12_1_1',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_2__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_12_1_2',
                '_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_2__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_22_12_1_2',
            )
        );
    }
}