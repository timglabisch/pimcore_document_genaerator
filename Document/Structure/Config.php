<?php
    class Pimcore_Document_Structure_Config {
        protected $currentNummeration;

        static function fromStructure(Pimcore_Document_Structure $structure) {
            $s = new static;
            $s->setCurrentNummeration($structure->getCurrentNummeration());
        }

        public function __construct() {
            $this->setCurrentNummeration(1);
        }

        public function setCurrentNummeration($currentNummeration) {
            $this->currentNummeration = $currentNummeration;
        }

        public function getCurrentNummeration() {
            return $this->currentNummeration;
        }
    }