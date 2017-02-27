<?php 
namespace UkronicBundle\InfoMovie;


//require_once "api-allocine-helper.php";

//use UkronicBundle\InfoMovie\AlloHelper;
use Symfony\Component\Debug\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UkronicBundle\Entity\Movie;

class InfoMovie {
	
	/**
   * doit renvoyer la liste des films
   *
   * @param string $text
   * @return string
   */
  public function listeMovies($text)
  {
    
    $result = "";
    // Construct the object.
    

    // Define parameters.
    $keywords = implode("+",explode(' ',$text)); // "The Dark Knight";
    $page = 1;
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        // $data = $allohelper->search( $keywords, $page );
        $url = "http://www.omdbapi.com/?s=". $keywords . "&r=json&type=movie";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); // 2nd param to get as array
        }
        
        
    }
    
    // Error
    catch ( \Exception $e )
    {
        // Print a error message.
        
      $result = "Error " . $e->getCode() . " : ". $e->getMessage();
    }
    return $result;
  }

  /**
   * doit renvoyer la liste des séries
   *
   * @param string $text
   * @return string
   */
  public function listeSeries($text)
  {
    
    $result = "";
    // Construct the object.
    // $allohelper = new AlloHelper;

    // Define parameters.
    $keywords = implode("+",explode(' ',$text)); // "The Dark Knight";
    $page = 1;
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        // $data = $allohelper->search( $keywords, $page );
        $url = "http://www.omdbapi.com/?s=". $keywords . "&r=json&type=series";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); // 2nd param to get as array
        }
        
        
    }
    
    // Error
    catch ( \Exception $e )
    {
        // Print a error message.
        
      $result = "Error " . $e->getCode() . " : ". $e->getMessage();
    }
    return $result;
  }


  /**
   * doit renvoyer les informations relatives au film
   *
   * @param string $text
   * @return Movie
   */
  public function detailMovie($imdbID){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = "http://www.omdbapi.com/?i=". $imdbID . "&r=json&type=movie";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $movie = new Movie();
            $result = (array) json_decode($content,true); // 2nd param to get as array
            $movie->setTitle($result["Title"]);
            $movie->setProductionYear($result["Year"]);
            $movie->setCasting($result["Actors"]);
            $movie->setPosterURL($result["Poster"]);
            $movie->setScript($result["Plot"]);
            $movie->setNumber($imdbID);
            $movie->setTypeMovie("F");
            return $movie;
        } else return null;
        
        
    }
    
    // Error
    catch ( \Exception $e )
    {
        // Print a error message.
        
      $result = "Error " . $e->getCode() . " : ". $e->getMessage();
    }
    return $result;
  }

  /**
   * doit renvoyer les informations relatives à la série
   *
   * @param string $text
   * @return Movie
   */
  public function detailSerie($imdbID,$titleSerie){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = "http://www.omdbapi.com/?i=". $imdbID . "&r=json&type=series";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $movie = new Movie();
            $result = (array) json_decode($content,true); // 2nd param to get as array
            $movie->setTitle($titleSerie);
            $movie->setEpisodeTitle($result["Title"]);
            $movie->setProductionYear($result["Year"]);
            $movie->setCasting($result["Actors"]);
            $movie->setPosterURL($result["Poster"]);
            $movie->setScript($result["Plot"]);
            $movie->setNumber($imdbID);
            $movie->setTypeMovie("S");
            $movie->setSeason((int) $result["Season"]);
            $movie->setEpisode((int) $result["Episode"]);
            return $movie;
        } else return null;
        
        
    }
    
    // Error
    catch ( \Exception $e )
    {
        // Print a error message.
        
      $result = "Error " . $e->getCode() . " : ". $e->getMessage();
    }
    return $result;
  }


  /**
   * doit renvoyer les informations relatives à la série
   *
   * @param string $text
   * @return Movie
   */
  public function detailSaisonSerie($imdbID,$season){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = "http://www.omdbapi.com/?i=". $imdbID . "&r=json&type=series&Season=".$season;
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); // 2nd param to get as array
        } else return null;
        
        
    }
    
    // Error
    catch ( \Exception $e )
    {
        // Print a error message.
        
      $result = "Error " . $e->getCode() . " : ". $e->getMessage();
    }
    return $result;
  }
}