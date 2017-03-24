<?php 

// src/UkronicBundle/Entity/MovieQuery.php

namespace UkronicBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

class MovieQuery
{
    protected $title;
    public $liste;
   
   public function __construct() {
    $this->liste = new ArrayCollection();
   }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function addMovie(Movie $movie){
        $this->liste->append($movie);
    }
}
