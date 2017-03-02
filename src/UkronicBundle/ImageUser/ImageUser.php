<?php 

namespace UkronicBundle\ImageUser;

// use UkronicBundle\Entity\User;

class ImageUser {

	public function choixAleaImage(){
		$palette = ['black','blue','dark-blue','dark-green','green','grey','orange','pink','purple'];
		
		$color_rand = $palette[array_rand($palette)];
		return "lunettes-".$color_rand.".png";

	}

}
 ?>