<?php
    class Pimcore_Document_Structure {
        protected $blocks = array();
        protected $numeration = array();
        protected $nodeName = '';
        protected $type;
        protected $generatedName = '';
        protected $depth;
        protected $currentNummeration;
        /** @var \Pimcore_Document_Structure */
        protected $parent = null;

        const NTH_CURRENT = 'current';
        const NTH_NEXT = 'current';

        function __construct($name = '', $tag = null, Pimcore_Document_Structure $parent = null, $type = 'node', $currentNummeration = 1) {
            $this->nodeName = $name;
            $this->type = $type;
            $this->setParent($parent);
            $this->setCurrentNummeration($currentNummeration);
        }

        function getName() {

            if($this->generatedName)
                return $this->generatedName;

            $name = $this->nodeName;

            if($this->getParent())
                $blocks = $this->getParent()->getBlocks();
            else
                $blocks = array();

            $tmpNumeration = $this->getNumeration();

            if (is_array($blocks) and count($blocks) > 0) {
                if ($this->type == "block") {
                    $tmpBlocks = $blocks;
                    array_pop($tmpBlocks);
                    array_pop($tmpNumeration);

                    $tmpName = $this->nodeName;
                    if (is_array($tmpBlocks)) {
                        $tmpName = $name . implode("_", $tmpBlocks) . implode("_", $tmpNumeration);
                    }

                    if ($blocks[count($blocks) - 1] == $tmpName) {
                        array_pop($blocks);
                        array_pop($tmpNumeration);
                    }
                }
                $name = $name . implode("_", $blocks) . implode("_", $this->getNumeration());

            }

            $this->generatedName = $name;

            return $name;
        }

        function addTag($name, Document_Tag $tag = null, $nth = self::NTH_CURRENT) {

            if($nth == self::NTH_CURRENT)
                $nth = $this->getCurrentNummeration();

            if($nth == self::NTH_NEXT)
                $nth = $this->getCurrentNummeration() + 1;

            $node = new static($name, $tag, $this, 'block', $nth);
            return $node;
        }

        function addSibling($name, Document_Tag $tag = null, $nth = self::NTH_CURRENT) {

            if($nth == self::NTH_CURRENT)
                $nth = $this->getCurrentNummeration();

            if($nth == self::NTH_NEXT)
                $nth = $this->getCurrentNummeration() + 1;

            $node = new static($name, $tag, $this->getParent(), 'block', $this->currentNummeration);
            return $node;
        }

        function Up() {
            return $this->getParent();
        }

        public function getBlocks() {

            $tmpBlocks = array();

            if($this->getParent())
                $tmpBlocks = $this->getParent()->getBlocks();

            if($this->getName())
                $tmpBlocks[] = $this->getName();

            return $tmpBlocks;
        }

        public function setNumeration($numeration) {
            $this->numeration = $numeration;
        }

        public function getNumeration() {

            $tmpNumeration = array();

            if($this->getDepth() > 1) {
                $tmpNumeration = $this->getParent()->getNumeration();
                $tmpNumeration[] = $this->getCurrentNummeration();
            }

            return $tmpNumeration;
        }

        public function setNodeName($nodeName) {
            $this->nodeName = $nodeName;
        }

        public function getNodeName() {
            return $this->nodeName;
        }

        public function setCurrentNummeration($currentNummeration)
        {
            $this->currentNummeration = $currentNummeration;
        }

        public function getCurrentNummeration()
        {
            return $this->currentNummeration;
        }

        public function getDepth()
        {
            if(!$this->getParent())
                return 0;

            return $this->getParent()->getDepth() + 1;
        }

        public function setGeneratedName($generatedName)
        {
            $this->generatedName = $generatedName;
        }

        public function getGeneratedName()
        {
            return $this->generatedName;
        }

        public function setParent($parent)
        {
            $this->parent = $parent;
        }

        public function getParent()
        {
            return $this->parent;
        }

        public function setType($type)
        {
            $this->type = $type;
        }

        public function getType()
        {
            return $this->type;
        }
    }

