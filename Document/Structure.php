<?php
    class Pimcore_Document_Structure {
        protected $blocks = array();
        protected $numeration = array();
        protected $nodeName = '';
        protected $generatedName = '';
        protected $depth;
        protected $currentNummeration;
        /** @var \Pimcore_Document_Structure */
        protected $parent = null;
        /** @var \Pimcore_Document_Structure_Config */
        protected $config = null;
        protected $structure_children = array();
        protected $tag;

        const NTH_CURRENT = 'current';
        const NTH_NEXT = 'next';

        function __construct($name = '', $tag = null, Pimcore_Document_Structure $parent = null, $currentNummeration = 1, $config = null) {
            $this->nodeName = $name;
            $this->setParent($parent);
            $this->setCurrentNummeration($currentNummeration);
            $this->setTag($tag);

            if($config === null)
                $this->config = Pimcore_Document_Structure_Config::fromStructure($this);

            $this->config = $config;

            if($this->getParent())
                $this->getParent()->addStructureChild($this);
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

                $name = $name . implode("_", $blocks) . implode("_", $this->getNumeration());
            }

            $this->generatedName = $name;

            return $name;
        }

        function addChild($name, Document_Tag $tag = null, $nth = self::NTH_CURRENT) {

            $currentNummeration = $this->getCurrentNummeration();
            $nodeConfig = new Pimcore_Document_Structure_Config();

            if($this->getConfig())
                $currentNummeration = $this->getConfig()->getCurrentNummeration();

            if($nth == self::NTH_NEXT) {
                $currentNummeration += 1;
            }

            $nodeConfig->setCurrentNummeration($currentNummeration);

            return new static($name, $tag, $this, $currentNummeration, $nodeConfig);
        }

        function addSblng($name, Document_Tag $tag = null, $nth = self::NTH_CURRENT) {
            return $this->addSibling($name, $tag, $nth);
        }

        function addSibling($name, Document_Tag $tag = null, $nth = self::NTH_CURRENT) {

            $currentNummeration = $this->getCurrentNummeration();
            $nodeConfig = new Pimcore_Document_Structure_Config();

            if($this->getConfig())
                $currentNummeration = $this->getConfig()->getCurrentNummeration();

            if($nth == self::NTH_NEXT) {
                $currentNummeration += 1;
            }

            $nodeConfig->setCurrentNummeration($currentNummeration);

            return new static($name, $tag, $this->getParent(), $currentNummeration, $nodeConfig);
        }

        function Up() {
            return $this->getParent();
        }

        public function getNodes() {

            $nodes = $this->getStructureChildren();
            foreach($this->getStructureChildren() as $n)
                $nodes = array_merge($nodes, $n->getNodes());

            return $nodes;
        }

        public function getElements() {

            $nodes = $this->getNodes();

            if(empty($nodes))
                return array();

            $buffer = array();
            foreach($nodes as $node) {

                if($node->getTag() instanceof \Document_Tag_Block)
                    $node->getTag()->indices = range(1, $node->getConfig()->getCurrentNummeration());

                $node->getTag()->setName($node->getName());
                $buffer[$node->getName()] = $node->getTag();
            }

            return $buffer;
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

        public function nextBlock($cnt = 1) {
            if(!$this->getConfig())
                throw new \Exception('cant use nextBlock on Root Element');

            $this->getConfig()->setCurrentNummeration($this->getConfig()->getCurrentNummeration() + $cnt);
            return $this;
        }

        public function prevBlock($cnt = 1) {
            return $this->nextBlock($cnt * -1);
        }

        public function block($position) {
            if($this->getConfig())
                throw new \Exception('cant use nextBlock on Root Element');

            $this->getConfig()->setCurrentNummeration($position);
            return $this;
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

        public function addStructureChild(Pimcore_Document_Structure $child) {
            $this->structure_children[] = $child;
        }

        /** @return Pimcore_Document_Structure[] */
        public function getStructureChildren()
        {
            return $this->structure_children;
        }

        public function setTag($tag)
        {
            $this->tag = $tag;
        }

        public function getTag()
        {
            return $this->tag;
        }

        public function setConfig($config)
        {
            $this->config = $config;
        }

        public function getConfig()
        {
            return $this->config;
        }
    }

