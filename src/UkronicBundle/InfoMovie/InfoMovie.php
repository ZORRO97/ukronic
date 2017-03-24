<?php 
namespace UkronicBundle\InfoMovie;



use Symfony\Component\Debug\Exception;
use UkronicBundle\Entity\Movie;

class InfoMovie {

  
  private $api_key;
  
   
  const BASE_URL = "https://api.themoviedb.org/3";

  public function __construct($tmdb_api_key){
    $this->api_key = $tmdb_api_key;
    // on récupère la clé de l'API en paramètres pour permettre une gestion de la clé API plus aisée dans les paramètres

  }
  
	
	/**
   * doit renvoyer la liste des films
   *
   * @param string $text
   * @return string
   */
  public function listeMovies($text)
  {
    
    $result = "";

    // remplace les espaces par des +
    $keywords = implode("+",explode(' ',$text)); 
    
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = "http://www.omdbapi.com/?s=". $keywords . "&r=json&type=movie";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
   * doit renvoyer la liste des films
   *
   * @param string $text
   * @return string
   */
  public function listeMoviesTMDB($text)
  {
    
    $result = "";
    // Construct the object.
    

    // Define parameters.
    $keywords = implode("+",explode(' ',$text)); 
    
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = self::BASE_URL."/search/movie?api_key=".$this->api_key."&query=". $keywords . "&language=fr";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
    // Define parameters.
    $keywords = implode("+",explode(' ',$text)); 
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = "http://www.omdbapi.com/?s=". $keywords . "&r=json&type=series";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
  public function listeSeriesTMDB($text)
  {
    
    $result = "";
       
    $keywords = implode("+",explode(' ',$text)); 
    // Remplace les espaces par des + pour la chaîne de recherche
    
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.
        $url = self::BASE_URL."/search/tv?api_key=".$this->api_key."&query=". $keywords . "&language=fr";
        
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
  public function infoSerieTMDB($id)
  {
    
    $result = "";
      
    // It's important to catch Exceptions.
    try
    {
        // Request data with parameters, and save the response in $data.  
        $url = self::BASE_URL."/tv/".$id."?api_key=".$this->api_key."&language=fr";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
  public function detailMovieTMDB($tmdbID){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        
        $url = self::BASE_URL."/movie/".$tmdbID."?api_key=".$this->api_key."&language=fr&append_to_response=credits";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $movie = new Movie();
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
            $movie->setTitle($result["title"]); 

            $release_date = $result["release_date"];
            $madate = explode("-",$release_date);
            $year = $madate[0];
            $movie->setProductionYear($year);

            if (array_key_exists('credits', $result)){
              if (array_key_exists("cast", $result['credits'])){
                $actors = array();
                foreach ($result['credits']['cast'] as $actor) {
                  array_push($actors,$actor["name"]);
                }
                $listeActors = implode(',',$actors);
              }
            } else {
              $listeActors = "";
            }
            $movie->setCasting($listeActors); 
            // ajouter les guest_stars

            
            $movie->setPosterURL("https://image.tmdb.org/t/p/w300".$result["poster_path"]);
            $movie->setScript($result["overview"]);
            $movie->setNumber($tmdbID);
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
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
  public function detailSerieTMDB($id,$saison,$episode,$titleSerie){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        
        $url = self::BASE_URL."/tv/".$id."/season/".$saison."/episode/".$episode."?api_key=".$this->api_key."&language=fr&append_to_response=credits";

        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $movie = new Movie();
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
            $movie->setTitle($titleSerie);
            $movie->setEpisodeTitle($result["name"]);
            if (array_key_exists("air_date", $result)){
              $release_date = $result["air_date"];
            
              $madate = explode("-",$release_date);
              $year = $madate[0];
              $movie->setProductionYear($year);
            } else {
              $movie->setProductionYear("");
            }

            if (array_key_exists('guest_stars', $result)) {
              $actors = array();
              foreach ($result["guest_stars"] as $star) {
                array_push($actors, $star["name"]);
              }
              $listeActors = implode(',',$actors);
            } else {
              $listeActors = "";
            }
            if (array_key_exists('credits', $result)){
              if (array_key_exists("cast", $result['credits'])){
                $actors = array();
                foreach ($result['credits']['cast'] as $actor) {
                  array_push($actors,$actor["name"]);
                }
                $listeActors .= ', '.implode(',',$actors);
              }
            }
            $movie->setCasting($listeActors); // ajouter les guest_stars
            $movie->setPosterURL("https://image.tmdb.org/t/p/w300".$result["still_path"]);
            $movie->setScript($result["overview"]);
            $movie->setNumber($id);
            $movie->setTypeMovie("S");
            $movie->setSeason((int) $saison);
            $movie->setEpisode((int) $episode);
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
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
  public function detailSaisonSerieTMDB($tmdbID,$season){
    try
    {
        // Request data with parameters, and save the response in $data.
        
        $url = self::BASE_URL."/tv/".$tmdbID."/season/".$season."?api_key=".$this->api_key."&language=fr";
        
        $content = file_get_contents($url);
        if (!empty($content))
        {
            $result = (array) json_decode($content,true); 
            // 2nd param to get as array
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
