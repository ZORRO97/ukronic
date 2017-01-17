<?php

namespace UkronicBundle\Repository;

use UkronicBundle\Entity\User;
use UkronicBundle\Entity\Comment;

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

	
}
