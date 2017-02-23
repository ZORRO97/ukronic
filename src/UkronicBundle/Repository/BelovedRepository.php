<?php

namespace UkronicBundle\Repository;

use UkronicBundle\Entity\User;
use UkronicBundle\Entity\Decrypt;
// use UkronicBundle\Entity\Beloved;

/**
 * BelovedRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BelovedRepository extends \Doctrine\ORM\EntityRepository
{
	function isLiked(User $user, Decrypt $decrypt){
		$monId = $user->getId();
		$decryptId = $decrypt->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT b FROM UkronicBundle:Beloved b  JOIN b.user u JOIN b.decrypt d WHERE d.id = $decryptId AND u.id = $monId " );
    	$exists = $q->getResult();
		if ($exists) {
			return true;
		} else {
			return false;
		}
	}

	function nbLiked(User $user){
		$monId = $user->getId();
		
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT b.id) FROM UkronicBundle:Beloved b  JOIN b.user u WHERE u.id = $monId " );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	function nbLikedDecrypt($decryptId){
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT b.id) FROM UkronicBundle:Beloved b  JOIN b.decrypt d WHERE d.id = $decryptId " );
    	$nb = $q->getSingleScalarResult();
		return $nb;

	}

	function allLikedDecrypt(){
		$q = $this->getEntityManager()
		->createQuery("SELECT b , COUNT(DISTINCT b.id) AS bcount FROM UkronicBundle:Beloved b JOIN b.decrypt d GROUP BY d.id ORDER BY bcount DESC"); 
		
		$results = $q->getResult();
		return $results;
	}
	
	function moreLikedDecrypt(){
		$q = $this->getEntityManager()
		->createQuery("SELECT b , COUNT(DISTINCT b.id) AS bcount FROM UkronicBundle:Beloved b JOIN b.decrypt d GROUP BY d.id ORDER BY bcount DESC")
		->setMaxresults(5); 
		
		$results = $q->getResult();
		return $results;
	}

	function moreLikedSerieDecrypt(){
		$q = $this->getEntityManager()
		->createQuery("SELECT b , COUNT(DISTINCT b.id) AS bcount FROM UkronicBundle:Beloved b JOIN b.decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' GROUP BY d.id   ORDER BY bcount DESC")
		->setMaxresults(5); 
		
		$results = $q->getResult();
		return $results;
	}


	public function countLikes(){
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT u.id) FROM UkronicBundle:Beloved u");
    	$nb = $q->getSingleScalarResult();

		return $nb;
	}

}
