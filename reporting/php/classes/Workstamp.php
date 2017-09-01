<?php

	class Workstamp {
		
		// Attributes
		
		private $checkTime;
		private $type;
		private $collaborator;
		private $activity;
		private $date;
		
		// Constructor
		
		public function __construct() {
			
		}
		
		// Getters & setters
		
		public function getCheckTime() {
			return $this->checkTime;
		}
		
		public function setCheckTime($ct) {
			$this->checkTime = $ct;
		}
		
		public function getType() {
			return $this->type;
		}
		
		public function setType($ty) {
			$this->type = $ty;
		}
		
		public function getCollaborator() {
			return $this->collaborator;
		}
		
		public function setCollaborator($co) {
			$this->collaborator = $co;
		}
		
		public function getActivity() {
			return $this->activity;
		}
		
		public function setActivity($a) {
			$this->activity = $a;
		}
		
		public function getDate() {
			return $this->date;
		}
		
		public function setDate($d) {
			$this->date = $d;
		}
	}
?>
