<?php

namespace UkronicBundle\Repository;




/**
 * LikeCommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LikeCommentRepository extends \Doctrine\ORM\EntityRepository
{

	function isLiked($id, $userId){
		

		$q = $this->getEntityManager()
		->createQuery("SELECT b FROM UkronicBundle:LikeComment b  JOIN b.user u JOIN b.comment c WHERE c.id = $id AND u.id = $userId " );
    	$exists = $q->getResult();
		if ($exists) {
			return true;
		} else {
			return false;
		}
	}

	function nbLiked($id){
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT b.id) FROM UkronicBundle:LikeComment b JOIN b.comment c WHERE c.id = $id");
		return $q->getSingleScalarResult();
	}

	public function countLikeComments(){
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT u.id) FROM UkronicBundle:LikeComment u");
    	$nb = $q->getSingleScalarResult();

		return $nb;
	}

	
}
