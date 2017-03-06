<?php 
namespace UkronicBundle\Entity;
class Recherche {
	public $title;

	public function getTitle(){
		return $this->title;
	}

	public function __construct(){
		$this->title = "";
	}
}
 ?>
