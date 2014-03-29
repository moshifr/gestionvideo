<?php
include_once 'generic.class.php';

class Video extends generic{
	var $_video_path = '../upload/videos/';
	var $_video_path_chap1 = '../upload/chapitre/';
	var $_video_path_chap2 = '../upload/chapitre/';
	var $_video_path_chap3 = '../upload/chapitre/';
	var $_img_path = '../upload/img/';
	var $_chap1 = 'News';
	var $_chap2 = 'Reportage';
	var $_chap3 = 'interview';
	
	function del($video_id){
		$message = false;
		$data = $this->get(array('video_id'=>$video_id));
		
		if(file_exists(substr($this->_video_path.$data[0]['video_file_path'], 2))){
			$message['txt'][] = "La video n'existe pas.";
		}
		if(file_exists(substr($this->_video_path_chap1.$data[0]['video_chap1_file_path'], 2))){
			$message['txt'][] = "La video du chapitre 1 n'existe pas.";
		}
		if(file_exists(substr($this->_video_path_chap2.$data[0]['video_chap2_file_path'], 2))){
			$message['txt'][] = "La video du chapitre 2 n'existe pas.";
		}
		if(file_exists(substr($this->_video_path_chap3.$data[0]['video_chap3_file_path'], 2))){
			$message['txt'][] = "La video du chapitre 3 n'existe pas.";
		}
		if(file_exists(substr($this->_video_path.$data[0]['video_img_path'], 2))){
			$message['txt'][] = "La vignette n'existe pas.";
		}
		
		if(!$message){
			//supprime l'image
			unlink($this->_video_path.$data[0]['video_file_path']);
			unlink($this->_video_path_chap1.$data[0]['video_chap1_file_path']);
			unlink($this->_video_path_chap2.$data[0]['video_chap2_file_path']);
			unlink($this->_video_path_chap3.$data[0]['video_chap3_file_path']);
			unlink($this->_img_path.$data[0]['video_img_path']);
			
			$query = 'DELETE FROM video WHERE video_id = '.$video_id;
			$this->execute($query);
			
			return false;
		}else{
			return $message;
		}
		
	}
	
	function get($param=null){
		//print_r($param);die;
	
		$where = "";
		$limit = "";
		
		if(isset($param['video_id'])){
			$where .= sprintf(" AND video_id = %s", $param['video_id']);
		}
		
		if(isset($param['private']) && $param['private'] ){
			$where .= sprintf(" AND video_page_private = 1");
		} elseif(isset($param['private']) && !$param['private'] ){
			$where .= sprintf(" AND video_only_page_private = 0");
		}
		
		if(isset($param['limit'])){
			if(isset($param['offset'])){
				$limit = ' LIMIT '.$param['offset'].', '.$param['limit'];
			}else{
				$limit = ' LIMIT '.$param['limit'];
			}
		}
		
		
		
		if(isset($param['video_private_position'])){
			$order = 'ORDER BY video_private_position '.$param['video_private_position'];
		}elseif(isset($param['video_private_display'])){
			$where .= sprintf(" AND (video_private_position = 1 OR video_private_position = 2) ");
			$order = 'ORDER BY video_private_position '.$param['video_private_position'];
		}elseif(isset($param['video_private_archive'])){
			$where .= sprintf(" AND (video_private_position != 1 AND video_private_position != 2) ");
			$order = 'ORDER BY video_private_position '.$param['video_private_position'];
		}elseif(isset($param['order']))
		{
			$order = 'ORDER BY '.$param['order'];
			}
		else{
			$order = 'ORDER BY video_id desc';
		}
		
		
		if(!empty($where)){
			$where = " WHERE".substr($where, 4);
		}
		
		$query = 'SELECT * FROM video'.$where.' '.$order.' '.$limit;
		//print_r($query);die;
		$data = $this->execute($query);
		
		if(count($data[0])>0){
			$data_tmp = $data;
			unset($data);
			
			foreach($data_tmp as $data_tmp_key => $data_tmp_item){
				$data[$data_tmp_key] = $data_tmp_item;
				
				$data[$data_tmp_key]['video_date'] = $this->formatDate($data_tmp_item['video_date_create']);
				
				$data[$data_tmp_key]['video_chap1_time_s'] = $this->convertToSec($data_tmp_item['video_chap1_time']);
				$data[$data_tmp_key]['video_chap2_time_s'] = $this->convertToSec($data_tmp_item['video_chap2_time']);
				$data[$data_tmp_key]['video_chap3_time_s'] = $this->convertToSec($data_tmp_item['video_chap3_time']);
				
			}
			
			return $data;
		}else{
			return false;
		}
		
		
		
		
	}
	
	function savePosPrivate($post){
	
		foreach($post['pos'] as $posK => $posV){
			$query = 'UPDATE video set video_private_position= '.$posV.'  WHERE video_id = '.$posK;
			
			$data = $this->execute($query);
		}
	}
	
	function savePos($post){
	
		foreach($post['pos'] as $posK => $posV){
			$query = 'UPDATE video set video_position= '.$posV.'  WHERE video_id = '.$posK;
			
			$data = $this->execute($query);
		}
	}
	
	function formatDate($date){
		list($y,$m,$d) = explode('-',$date);  
		$dateFormated = $d.'/'.$m.'/'.$y;
		
		return $dateFormated;
	}
	
	function convertToSec($time){
		list($h,$m,$s) = explode(':',$time);  
		$seconds = $s + (60*$m) + (120*$h) ;
		
		return $seconds;
	}

	function save($post){
		$where = "";
		$action = "add";
		$message = false;
		
		//print_r($post);
		//die();
		
		if(!isset($post['video_title']) || empty($post['video_title'])){
			$message['txt'][] = "Veuillez saisir un titre.";
			$message["video_title"] = true;
		}
		
		if(!isset($post['video_description']) || empty($post['video_description'])){
			$message['txt'][] = "Veuillez saisir une description.";
			$message["video_description"] = true;
		}
		
		//par defaut
		if(empty($post['video_chap1_name'])){
			$post['video_chap1_name'] = $this->_chap1;
		}
		if(empty($post['video_chap2_name'])){
			$post['video_chap2_name'] = $this->_chap2;
		}
		if(empty($post['video_chap3_name'])){
			$post['video_chap3_name'] = $this->_chap3;
		}
		
		if(empty($post['video_date_create']) || !empty($post['video_date_create']) && $post['video_date_create'] == '0000-00-00'){
			$tab['video_date_create'] = "NOW()";
		}
		else{
			//$tab['video_date_create'] = $this->escape_str($post['video_date_create']);
			$tab['video_date_create'] = $this->formatDate($post['video_date_create']);
			$tab['video_date_create'] = $this->escape_str($tab['video_date_create']);
			//list($d, $m, $y) = explode('-', $post['video_date_create']);
			//$tab['video_date_create'] = $this->escape_str($y.'-'.$m.'-'.$d); //str_replace('/', '-', $post['video_date_create']);]
		}
		
		if(isset($post['video_page_private'])){
			$tab['video_page_private'] = 1;
		}else{
			$tab['video_page_private'] = 0;
		}
		
		if(isset($post['video_only_page_private'])){
			$tab['video_only_page_private'] = 1;
		}else{
			$tab['video_only_page_private'] = 0;
		}
		
		//- On ne gere pas les image lors d'un update
		//if(!isset($post['video_id'])){
		if(1){
			//check if is file 
			if ($_FILES['video_file']['error'] && !empty($_FILES['video_file']['name'])) {    
				$message["video_file"] = true;
				switch ($_FILES['video_file']['error']){    
					case 1: // UPLOAD_ERR_INI_SIZE    
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e par le serveur (fichier php.ini) !";
					break;    
					case 2: // UPLOAD_ERR_FORM_SIZE    
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e dans le formulaire HTML !";
					break;    
					case 3: // UPLOAD_ERR_PARTIAL    
						$message['txt'][] = "L'envoi de la vid&eacute;o a �t� interrompu pendant le transfert !";    
					break;    
					case 4: // UPLOAD_ERR_NO_FILE    
						$message['txt'][] = "La vid&eacute;o que vous avez envoy� a une taille nulle !";
					break;    
				}
			}
			if ($_FILES['video_chap1_file']['error'] && !empty($_FILES['video_chap1_file']['name'])) {
				$message["video_chap1_file"] = true;
				switch ($_FILES['video_chap1_file']['error']){
					case 1: // UPLOAD_ERR_INI_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e par le serveur (fichier php.ini) !";
						break;
					case 2: // UPLOAD_ERR_FORM_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e dans le formulaire HTML !";
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						$message['txt'][] = "L'envoi de la vid&eacute;o a �t� interrompu pendant le transfert !";
						break;
					case 4: // UPLOAD_ERR_NO_FILE
						$message['txt'][] = "La vid&eacute;o que vous avez envoy� a une taille nulle !";
						break;
				}
			}
			if ($_FILES['video_chap2_file']['error'] && !empty($_FILES['video_chap2_file']['name'])) {
				$message["video_chap2_file"] = true;
				switch ($_FILES['video_chap2_file']['error']){
					case 1: // UPLOAD_ERR_INI_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e par le serveur (fichier php.ini) !";
						break;
					case 2: // UPLOAD_ERR_FORM_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e dans le formulaire HTML !";
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						$message['txt'][] = "L'envoi de la vid&eacute;o a �t� interrompu pendant le transfert !";
						break;
					case 4: // UPLOAD_ERR_NO_FILE
						$message['txt'][] = "La vid&eacute;o que vous avez envoy� a une taille nulle !";
						break;
				}
			}
			if ($_FILES['video_chap3_file']['error'] && !empty($_FILES['video_chap3_file']['name'])) {
				$message["video_chap3_file"] = true;
				switch ($_FILES['video_chap3_file']['error']){
					case 1: // UPLOAD_ERR_INI_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e par le serveur (fichier php.ini) !";
						break;
					case 2: // UPLOAD_ERR_FORM_SIZE
						$message['txt'][] = "La vid&eacute;o d�passe la limite autoris�e dans le formulaire HTML !";
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						$message['txt'][] = "L'envoi de la vid&eacute;o a �t� interrompu pendant le transfert !";
						break;
					case 4: // UPLOAD_ERR_NO_FILE
						$message['txt'][] = "La vid&eacute;o que vous avez envoy� a une taille nulle !";
						break;
				}
			}
			//check if is video_image
			if ($_FILES['video_image']['error'] && !empty($_FILES['video_image']['name'])) {    
				$message["video_image"] = true;
				switch ($_FILES['video_image']['error']){    
					case 1: // UPLOAD_ERR_INI_SIZE    
						$message['txt'][] = "La vignette d�passe la limite autoris�e par le serveur (fichier php.ini) !";
					break;    
					case 2: // UPLOAD_ERR_FORM_SIZE    
						$message['txt'][] = "La vignette d�passe la limite autoris�e dans le formulaire HTML !";
					break;    
					case 3: // UPLOAD_ERR_PARTIAL    
						$message['txt'][] = "L'envoi de la vignette a �t� interrompu pendant le transfert !";    
					break;    
					case 4: // UPLOAD_ERR_NO_FILE    
						$message['txt'][] = "La vignette que vous avez envoy� a une taille nulle !";
					break;    
				}
			}
		}
		$prefixe = time().'_';
		//check if has error
		if(!$message){
		
			//if(!isset($post['video_id'])){
			if(1){
				//upload file
				if ((isset($_FILES['video_file'])&&(!$_FILES['video_file']['error']))) {    				
					$chemin_destination = $this->_video_path;
					move_uploaded_file($_FILES['video_file']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_file']['name']);    
					
					$tab['video_file_path'] = $this->escape_str($prefixe.$_FILES['video_file']['name']);
				}    
				if ((isset($_FILES['video_chap1_file'])&&(!$_FILES['video_chap1_file']['error']))) {
					$chemin_destination = $this->_video_path_chap1;
					move_uploaded_file($_FILES['video_chap1_file']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap1_file']['name']);
						
					$tab['video_chap1_file_path'] = $this->escape_str($prefixe.$_FILES['video_chap1_file']['name']);
				}
				if ((isset($_FILES['video_chap2_file'])&&(!$_FILES['video_chap2_file']['error']))) {
					$chemin_destination = $this->_video_path_chap2;
					move_uploaded_file($_FILES['video_chap2_file']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap2_file']['name']);
				
					$tab['video_chap2_file_path'] = $this->escape_str($prefixe.$_FILES['video_chap2_file']['name']);
				}
				if ((isset($_FILES['video_chap3_file'])&&(!$_FILES['video_chap3_file']['error']))) {
					$chemin_destination = $this->_video_path_chap3;
					move_uploaded_file($_FILES['video_chap3_file']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap3_file']['name']);
				
					$tab['video_chap3_file_path'] = $this->escape_str($prefixe.$_FILES['video_chap3_file']['name']);
				}
				//upload vignette
				if ((isset($_FILES['video_image'])&&(!$_FILES['video_image']['error']))) { 
					$chemin_destination = $this->_img_path;
					move_uploaded_file($_FILES['video_image']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_image']['name']);    
					
					$tab['video_img_path'] = $this->escape_str($prefixe.$_FILES['video_image']['name']);				
				}
				if ((isset($_FILES['video_chap1_image'])&&(!$_FILES['video_chap1_image']['error']))) { 
					//die($_FILES['video_chap1_image']['tmp_name']);
					$chemin_destination = $this->_img_path;
					move_uploaded_file($_FILES['video_chap1_image']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap1_image']['name']);    
					
					$tab['video_chap1_image'] = $this->escape_str($prefixe.$_FILES['video_chap1_image']['name']);				
				}
				if ((isset($_FILES['video_chap2_image'])&&(!$_FILES['video_chap2_image']['error']))) {    
					$chemin_destination = $this->_img_path;
					move_uploaded_file($_FILES['video_chap2_image']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap2_image']['name']);    
					
					$tab['video_chap2_image'] = $this->escape_str($prefixe.$_FILES['video_chap2_image']['name']);				
				}  
				if ((isset($_FILES['video_chap3_image'])&&(!$_FILES['video_chap3_image']['error']))) {    
					$chemin_destination = $this->_img_path;
					move_uploaded_file($_FILES['video_chap3_image']['tmp_name'], $chemin_destination.$prefixe.$_FILES['video_chap3_image']['name']);    
					
					$tab['video_chap3_image'] = $this->escape_str($prefixe.$_FILES['video_chap3_image']['name']);				
				} 
			}
			
			if(isset($post['video_id'])){
				$where .= sprintf(" AND video_id = %s", $post['video_id']);
				$action = "up";
			}
			
			if(isset($post['video_title'])){
				$tab['video_title'] = $this->escape_str($post['video_title']);
			}
			if(isset($post['video_description'])){
				$tab['video_description'] = $this->escape_str($post['video_description']);
			}
			if(isset($post['video_duree'])){
				$tab['video_duree'] = $this->escape_str($post['video_duree']);
			}
			
			
			if(isset($post['video_chap1_name'])){
				$tab['video_chap1_name'] = $this->escape_str($post['video_chap1_name']);
			}
			 
			
			if(isset($post['video_chap1_time'])){
				$tab['video_chap1_time'] = $this->escape_str($post['video_chap1_time']);
			}
			if(isset($post['video_chap2_name'])){
				$tab['video_chap2_name'] = $this->escape_str($post['video_chap2_name']);
			}
			
			if(isset($post['video_chap2_time'])){
				$tab['video_chap2_time'] = $this->escape_str($post['video_chap2_time']);
			}
			if(isset($post['video_chap3_name'])){
				$tab['video_chap3_name'] = $this->escape_str($post['video_chap3_name']);
			}
			 
			if(isset($post['video_chap3_time'])){				
				$tab['video_chap3_time'] = $this->escape_str($post['video_chap3_time']);
			}
			
			if(!empty($where)){
				$where = " WHERE".substr($where, 4);
			}
			

			
			//INSERT INTO video
			if($action == 'add'){
				$query = 'INSERT INTO video ('.implode(array_keys($tab), ",").') VALUES ('.implode($tab, ",").')' .$where;
			}else{
			//UPDATE FROM video
			//print_r($tab);
				$values = "";
				foreach($tab as $tab_key => $tab_item){
					$values .= ', '.$tab_key.'='.$tab_item;
				}
				
				$values = substr($values, 2);
				$query = 'UPDATE video SET '.$values.$where;
			}
			
			
			//die($query);
			$this->execute($query); 
			//die;
			header("Location: list_video.php");

		}else{
			return $message;
		}
	}
	
	
	
}

?>
