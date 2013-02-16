<?php

require_once __DIR__.'/../../Document/Structure.php';

class tl extends PHPUnit_Framework_TestCase {

    function testNested() {

        $c = new Pimcore_Document_Structure();

        $tag = $c->addTag('_ROOT-BLOCK3_')->addTag('_ROOT-BLOCK3-BLOCK4_')->addTag('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addTag('_ROOT-BLOCK3-BLOCK4-INP2_');

        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
            $tag->getName()
        );

    }

    function testSibling1() {
        $c = new Pimcore_Document_Structure();
        $tag = $c->addTag('_ROOT-BLOCK3_')->addTag('_ROOT-BLOCK3-BLOCK4_')->addTag('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->addTag('_ROOT-BLOCK3-BLOCK4-INP1_');
        $this->assertEquals(
            '_ROOT-BLOCK3-BLOCK4-INP2__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_1__ROOT-BLOCK3-BLOCK4-BLOCK5__ROOT-BLOCK3___ROOT-BLOCK3-BLOCK4__ROOT-BLOCK3_11_11_1_1',
            $tag->addSibling('_ROOT-BLOCK3-BLOCK4-INP2_')->getName()
        );
    }
}