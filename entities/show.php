<?php 
    
    // Show class definition
    class Show {

        // Properties
        private $id;
        private $startingDate;
        private $endingDate;
        private $name;
        private $description;
        private $imgUrl;

        // Get method
        public function __get($prop) {
            return $this->$prop;
        }

        // Set method
        public function __set($prop, $val) {
            $this->$prop = $val;
        }

        // Isset method
        public function __isset($prop) {
            return isset($this->$prop);
        }

        // ToString method
        public function __toString() {
            return "Id: {$this->id} / ".
                   "Starting date: {$this->startingDate} / ".
                   "Ending date: {$this->endingDate} / ".
                   "Name: {$this->name} / ".
                   "Description: {$this->description}";                             
        }
    }

?>