<?php

	class Collaborator {
		
		// Attributes
		
		private $firstName;
		private $lastName;
		private $cost;
		
		// Constructor
		
		public function __construct() {
		
		}
		
		// Getters & setters
		
		public function getFirstName() {
			return $this->firstName;
		}
		
		public function setFirstName($fn) {
			$this->firstName = $fn;
		}
		
		public function getLastName() {
			return $this->lastName;
		}
		
		public function setLastName($ln) {
			$this->lastName = $ln;
		}
		
		public function getCost() {
			return $this->cost;
		}
		
		public function setCost($co) {
			$this->cost = $co;
		}
	}
?>
