<?php

namespace UkronicBundle\Repository;
use UkronicBundle\Entity\User;
use Doctrine\DBAL\Query\Doctrine_Query;

/**
 * DecryptRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DecryptRepository extends \Doctrine\ORM\EntityRepository
{
/*
	public function nbComment(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(d.id) FROM UkronicBundle:Decrypt d JOIN d.user u");
    	
 
  	$nb = $q->getSingleResult();
		return $nb;

	}
*/

	public function movieMoreDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT d.id) as dcount FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' GROUP BY m.id ORDER BY dcount DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
    	return $decrypts;
	}

	public function serieMoreDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT d.id) as dcount FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' GROUP BY m.id ORDER BY dcount DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
    	return $decrypts;
	}

	public function movieLastDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  ORDER BY d.dateDecrypt DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
		return $decrypts;

	}

	public function serieLastDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d WHERE d.typeDecrypt = 'S' ORDER BY d.dateDecrypt DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
		return $decrypts;

	}



	public function getDecrypts($idMovie , $filter, $typeDecrypt) {
		// $monId = $user->getId();

		switch ($filter) {
        	case '-100':
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND d.wordCount < 100 AND m.id = $idMovie " );
        		break;
        	case '-300':
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND d.wordCount < 300 AND d.wordCount >= 100 AND m.id = $idMovie" );
        		break;
        	case '+300':
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND d.wordCount > 300  AND m.id = $idMovie" );
        		break;
        	default:
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND m.id = $idMovie ");
        		break;
        }
        return $q->getResult();

	}

	public function sequenceDecrypted(User $user){
		// TODO requête comptant le nombre de séquences décryptées
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d  JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'S' AND u.id = $monId ");
    	$nb = $q->getSingleScalarResult();

		return $nb;
		
	}

	public function sequenceM100Decrypted(User $user){
		// TODO nombre de séquences de moins de 100 mots
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'S' AND d.wordCount < 100 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function sequenceM300Decrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'S' AND d.wordCount < 300 aND d.wordCount >= 100 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function sequenceO300Decrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'S' AND d.wordCount > 300 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function endDecrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(d.id) FROM UkronicBundle:Decrypt d JOIN d.user u WHERE d.typeDecrypt = 'F' AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function endM100Decrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'F' AND d.wordCount < 100 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function endM300Decrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'F' AND d.wordCount < 300 AND d.wordCount >= 100 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

	public function endO300Decrypted(User $user){
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'F' AND d.wordCount > 300 AND u.id = $monId" );
    	$nb = $q->getSingleScalarResult();
		return $nb;
	}

}
