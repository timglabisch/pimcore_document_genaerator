<?php
    class Pimcore_Document_Structure {
        protected $blocks = array();
        protected $numeration = array();
        protected $nodeName = '';
        protected $type;
        protected $generatedName = '';
        protected $depth;
        protected $currentNummeration;

        function __construct($name = '', $blocks = null, $numeration = array(), $type = 'node', $depth = 0, $currentNummeration = 1) {
            $this->setBlocks($blocks);
            $this->setNumeration($numeration);
            $this->nodeName = $name;
            $this->type = $type;
            $this->depth = $depth;
            $this->currentNummeration = $currentNummeration;

            if($this->getName())
                $this->blocks[] = $this->getName();
        }

        function getName() {

            if($this->generatedName)
                return $this->generatedName;

            $name = $this->nodeName;

            if (is_array($this->blocks) and count($this->blocks) > 0) {
                if ($this->type == "block") {
                    $tmpBlocks = $this->blocks;
                    $tmpNumeration = $this->numeration;
                    array_pop($tmpBlocks);
                    array_pop($tmpNumeration);

                    $tmpName = $this->nodeName;
                    if (is_array($tmpBlocks)) {
                        $tmpName = $name . implode("_", $tmpBlocks) . implode("_", $tmpNumeration);
                    }

                    if ($this->blocks[count($this->blocks) - 1] == $tmpName) {
                        array_pop($this->blocks);
                        array_pop($this->numeration);
                    }
                }
                $name = $name . implode("_", $this->blocks) . implode("_", $this->numeration);

            }

            $this->generatedName = $name;

            return $name;
        }

        function addTag($name) {

            $tmpNumeration = array();

            if($this->depth > 0) {
                $tmpNumeration = $this->numeration;
                $tmpNumeration[] = $this->currentNummeration;
            }

            $node = new static($name, $this->blocks, $tmpNumeration, 'block', $this->depth + 1);
            return $node;
        }

        function addSibling($name, $nth = null) {

            if($nth !== null)
                $nth = $this->currentNummeration + 1;

            $node = new static($name, $this->blocks, $this->numeration, 'block', $this->depth + 1, $nth);
            return $node;
        }

        public function setBlocks($blocks) {
            $this->blocks = $blocks;
        }

        public function getBlocks() {
            return $this->blocks;
        }

        public function setNumeration($numeration) {
            $this->numeration = $numeration;
        }

        public function getNumeration() {
            return $this->numeration;
        }

        public function setNodeName($nodeName) {
            $this->nodeName = $nodeName;
        }

        public function getNodeName() {
            return $this->nodeName;
        }
    }

