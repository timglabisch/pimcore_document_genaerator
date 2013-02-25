<?php

require_once __DIR__ . '/../../Document/Parser.php';


class Document_Parser_Test extends PHPUnit_Framework_TestCase {

    function testNested() {

        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('ROOT-BLOCK3')
                ->addChild('_ROOT-BLOCK3-BLOCK4_')
                    ->addChild('ROOT-BLOCK3-BLOCK4-BLOCK5')
                        ->addChild('_ROOT-BLOCK3-BLOCK4-INP2');

        $elements = $c->getElements();
        $element = array_pop(array_keys($elements));
        $parser = new Pimcore_Document_Parser($element);
        $this->assertEquals($parser->getDepth($element), 4);
    }

    function testGetElementsNames() {
        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('A')
            ->addChild('B')
            ->addChild('C')
            ->addChild('D');


        $parser = new Pimcore_Document_Parser('refactor ...');

        $this->assertEquals(
            array('D', 'B', 'C', 'A'),
            $parser->getElementsNames($c->getElements())
        );
    }

    function testGetElementsNamesSingle() {
        $c = new Pimcore_Document_Structure();

        $c->addChild('A');

        $parser = new Pimcore_Document_Parser('refactor ...');

        $this->assertEquals(
            array('A'),
            $parser->getElementsNames($c->getElements())
        );
    }

    function testGetElementsNamesMultipleNodes() {
        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('A')
            ->addChild('B')
            ->addChild('C')
            ->addChild('D');

        $c
            ->addChild('E')
            ->addChild('F')
            ->addChild('G')
            ->addChild('H');


        $parser = new Pimcore_Document_Parser('refactor ...');


        $this->assertEquals(
            array('F', 'G', 'A', 'B', 'C', 'D', 'H', 'E'),
            $parser->getElementsNames($c->getElements())
        );
    }

    function testGetElementsTree() {
        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('A')
            ->addChild('B')
            ->addChild('C')
            ->addChild('D');


        $parser = new Pimcore_Document_Parser('refactor ...');

        $this->assertEquals(
            array(
                'DA_BA1_CA_BA11_11_1_1' => array('A','B','C', 'D'),
                'CA_BA11_1' => array('A','B', 'C'),
                'BA1' => array('A', 'B'),
                'A' => array('A')
            ),
            $parser->getElementsTree($c->getElements())
        );
    }

    function testGetElementsTreeMultipleLength() {
        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('AB')
            ->addChild('BC')
            ->addChild('CD')
            ->addChild('DE');


        $parser = new Pimcore_Document_Parser('refactor ...');

        $this->assertEquals(
            array(
                'DEAB_BCAB1_CDAB_BCAB11_11_1_1' => array('AB','BC','CD', 'DE'),
                'CDAB_BCAB11_1' => array('AB','BC','CD'),
                'BCAB1' => array('AB','BC'),
                'AB' => array('AB')
            ),
            $parser->getElementsTree($c->getElements())
        );
    }


}