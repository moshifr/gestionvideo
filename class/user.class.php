<?php
class User{
	function login($post){
		if($post['user_pseudo'] == "admin" && $post['user_password'] == "Sporever"){
			//creer la session
			$_SESSION['user'] = $post['user_pseudo'];
			
			header("Location: list_video.php");
		}else{
			$message['txt'][] = "Identifiant ou mot de passe incorrect.";
			
			return $message;
		}
	}
	
	function loginClient($post){
		if($post['user_pseudo'] == "MSD" && $post['user_password'] == "JTMSD"){
			//creer la session
			$_SESSION['client'] = $post['user_pseudo'];
			
			if(isset($post['remember'])){
				$expiration = time() + 365*24*3600; // Le cookie expirera dans un an, modifie ça pour le faire durer plus longtemps
				setcookie('remember', 'machin', $expiration); // On écrit un cookie pour le pseudo (remplace 'machin' par une variable qui correspond au visiteur
			}
			
			header("Location: private.php");
		}else{
			$message['txt'][] = "Identifiant ou mot de passe incorrect.";
			
			return $message;
		}
	}
}

?>