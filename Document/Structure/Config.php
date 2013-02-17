<?php
    class Pimcore_Document_Structure_Config {
        protected $currentNummeration;

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