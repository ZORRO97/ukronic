<?php

namespace UkronicBundle\Repository;
use UkronicBundle\Entity\User;


/**
 * DecryptRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DecryptRepository extends \Doctrine\ORM\EntityRepository
{

	public function countDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT u.id) FROM UkronicBundle:Decrypt u");
    	$nb = $q->getSingleScalarResult();

		return $nb;
	}

	public function movieMoreDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT d.id) as dcount FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' GROUP BY m.id ORDER BY dcount DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
    	return $decrypts;
	}

	public function movieMoreAllDecrypted(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT d.id) as dcount FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' GROUP BY m.id ORDER BY dcount DESC" );
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

	public function serieMoreAllDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT d.id) as dcount FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' GROUP BY m.id ORDER BY dcount DESC" );
    	$decrypts = $q->getResult();
    	return $decrypts;
	}

	public function movieLastDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  JOIN d.movie m WHERE m.typeMovie = 'F' ORDER BY d.dateDecrypt DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
		return $decrypts;

	}
	
	public function movieDateDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  JOIN d.movie m WHERE m.typeMovie = 'F' ORDER BY d.dateDecrypt DESC" );
    	$decrypts = $q->getResult();
		return $decrypts;

	}


	public function serieLastDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' ORDER BY d.dateDecrypt DESC" )
		->setMaxresults(5);
    	$decrypts = $q->getResult();
		return $decrypts;

	}

	public function serieDateDecrypted() {
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' ORDER BY d.dateDecrypt DESC" );
    	$decrypts = $q->getResult();
		return $decrypts;

	}

	public function movieLikeAllDecrypted(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT b.id) AS clike FROM UkronicBundle:Decrypt d UkronicBundle:Beloved b INNER JOIN b.decrypt d GROUP BY d.id ORDER BY clike DESC" );
    	$decrypts = $q->getResult();
		return $decrypts;
	}

	public function serieLikeAllDecrypted(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT b.id) AS clike FROM UkronicBundle:Decrypt d UkronicBundle:Beloved b INNER JOIN b.decrypt d JOIN decrypt.movie m WHERE m.typeMovie='S' GROUP BY d.id ORDER BY clike DESC" );
    	$decrypts = $q->getResult();
		return $decrypts;		
	}



	public function getDecrypts($idMovie , $filter, $typeDecrypt) {
		
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
        	case 'liked' :
        	$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND d.nbLiked > 0  AND m.id = $idMovie ORDER BY d.nbLiked DESC" );
        	break;
        
        	case 'read' :
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND d.nbRead > 0  AND m.id = $idMovie ORDER BY d.nbRead DESC" );
        	break;

        	case 'comment' : 
        	$q = $this->getEntityManager()
		->createQuery("SELECT d  FROM UkronicBundle:Decrypt d JOIN d.movie m INNER JOIN d.comments c WHERE d.typeDecrypt = '$typeDecrypt'   AND m.id = $idMovie " );

        	break;
        	default:
        		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d  JOIN d.movie m WHERE d.typeDecrypt = '$typeDecrypt' AND m.id = $idMovie ");
        		break;
        }
        return $q->getResult();

	}

	public function moreLikedDecrypts(){
			$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' AND d.nbLiked > 0  ORDER BY d.nbLiked DESC" )
		->setMaxresults(5);
		return $q->getResult();
	}

	public function moreLikedSerieDecrypts(){
			$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' AND d.nbLiked > 0  ORDER BY d.nbLiked DESC" )
		->setMaxresults(5);
		return $q->getResult();
	}


	public function moreReadMovieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' AND d.nbRead > 0  ORDER BY d.nbRead DESC" )
		->setMaxresults(5);
		return $q->getResult();
	}

	public function moreReadSerieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' AND d.nbRead > 0  ORDER BY d.nbRead DESC" )
		->setMaxresults(5);
		return $q->getResult();
	}

	public function movieMoreReadAllDecrypted(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'F' AND d.nbRead > 0  ORDER BY d.nbRead DESC" );
		return $q->getResult();
	}

	public function serieMoreReadAllDecrypted(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d FROM UkronicBundle:Decrypt d JOIN d.movie m WHERE m.typeMovie = 'S' AND d.nbRead > 0  ORDER BY d.nbRead DESC" );
		return $q->getResult();
	}

	public function moreCommentMovieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT c.id) as ccount  FROM UkronicBundle:Decrypt d JOIN d.movie m INNER JOIN d.comments c WHERE m.typeMovie='F' GROUP BY d.id ORDER BY ccount DESC " )
		->setMaxresults(5);
		return $q->getResult();
	}

	public function moreCommentSerieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT c.id) as ccount  FROM UkronicBundle:Decrypt d JOIN d.movie m INNER JOIN d.comments c WHERE m.typeMovie='S' GROUP BY d.id ORDER BY ccount DESC " )
		->setMaxresults(5);
		return $q->getResult();
	}

	public function allCommentMovieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT c.id) as ccount  FROM UkronicBundle:Decrypt d JOIN d.movie m INNER JOIN d.comments c WHERE m.typeMovie='F' GROUP BY d.id ORDER BY ccount DESC " );
		return $q->getResult();
	}

	public function allCommentSerieDecrypts(){
		$q = $this->getEntityManager()
		->createQuery("SELECT d , COUNT(DISTINCT c.id) as ccount  FROM UkronicBundle:Decrypt d JOIN d.movie m INNER JOIN d.comments c WHERE m.typeMovie='S' GROUP BY d.id ORDER BY ccount DESC " );
		return $q->getResult();
	}

	public function sequenceDecrypted(User $user){
		// requête comptant le nombre de séquences décryptées
		$monId = $user->getId();
		$q = $this->getEntityManager()
		->createQuery("SELECT COUNT(DISTINCT d.id) FROM UkronicBundle:Decrypt d  JOIN d.user u JOIN d.movie m WHERE d.typeDecrypt = 'S' AND u.id = $monId ");
    	$nb = $q->getSingleScalarResult();

		return $nb;
		
	}

	public function sequenceM100Decrypted(User $user){
		//  nombre de séquences de moins de 100 mots
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
