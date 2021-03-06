<?php

namespace UkronicBundle\Repository;

use UkronicBundle\Entity\Rating;
use UkronicBundle\Entity\User;


/**
 * RatingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RatingRepository extends \Doctrine\ORM\EntityRepository
{
	public function trouve($idUser, $idMovie){
		
		
		$q = $this->getEntityManager()
		->createQuery("SELECT r FROM UkronicBundle:Rating r  JOIN r.user u JOIN r.movie m WHERE u.id = $idUser AND m.id = $idMovie");
    	$result = $q->getResult();
    	if (!$result) {
    		$rating = new Rating();
    		$rating->setNote(0);
    		$rating->setAmbiguous(0);
    		$rating->setUnderstand(0);
    	} else {
    		$rating = $q->getSingleResult();
    	}
		return $rating;


	}

	public function preferedMovie(User $user){
		$idUser = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT r FROM UkronicBundle:Rating r  JOIN r.user u JOIN r.movie m WHERE u.id = $idUser ORDER BY r.note DESC");
    	$result = $q->getResult();
    	if ($result) {
    		return $result[0]->getMovie();
    	} else {
    		return null;
    	}
		
	}

	public function ambiguousMovie(User $user){
		$idUser = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT r FROM UkronicBundle:Rating r  JOIN r.user u JOIN r.movie m WHERE u.id = $idUser ORDER BY r.ambiguous ASC");
    	$result = $q->getResult();
    	if ($result) {
    		return $result[0]->getMovie();
    	} else {
    		return null;
    	}
	}

	public function balaiseMovie(User $user){
		$idUser = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT r FROM UkronicBundle:Rating r  JOIN r.user u JOIN r.movie m WHERE u.id = $idUser ORDER BY r.understand DESC");
    	$result = $q->getResult();
    	if ($result) {
    		return $result[0]->getMovie();
    	} else {
    		return null;
    	}
	}
}
