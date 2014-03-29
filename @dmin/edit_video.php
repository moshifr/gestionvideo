<?php
session_start(); 
if(!isset($_SESSION['user'])){
	header('Location: index.php');
}

include_once "../class/video.class.php";

$videoClass = new Video();
$data = $videoClass->get(array('video_id'=>$_GET['video']));


//print_r($data);die;

if(($_POST)){
	$message = $videoClass->save($_POST);
}

?>
<html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css"/>
		<link rel="stylesheet" href="../css/jquery-ui.css" type="text/css"/>
		<script type="text/javascript" src='../js/swfobject.js'></script>
		<script type="text/javascript" src='../js/jquery.min.js'></script>
		<script type="text/javascript" src='../js/jquery-ui-1.8.17.min.js'></script>
		<script type="text/javascript" src='../js/jquery-ui-timepicker-addon.js'></script>
	</head>
	<body>
		<div id="main">
			<div id="header"></div>
			
			<div class="fill">
				<div class="container">
					<ul class="nav">
						<li><a href="#">Accueil</a></li>
						<li class=""><a href="add_video.php">Ajouter les videos</a></li>
						<li><a href="list_video.php">Lister une video</a></li>
						<li><a href="index.php?logout">Deconnexion</a></li>
					</ul>
				</div>
			</div>
			
			<div id="content">
			
				<?php
					if(isset($message)){
						echo '<div class="msg-error">';
						foreach($message['txt'] as $item){
							echo '<p>'.$item.'</p>';
						}
						echo '</div>';
					}
				?>
			
				<h2>Modifier une vid&eacute;o</h2>
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="video_id" value="<?php echo $_GET['video'] ?>" />
					<div class="field">
						<label>Date:</label><span<?php if(isset($message['video_date_create']))echo ' class="error"';?>><input id="datepicker" name="video_date_create" type="text" <?php if(isset($data[0]['video_date_create'])) echo 'value="'.$data[0]['video_date_create'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Titre:</label><span<?php if(isset($message['video_title']))echo ' class="error"';?>><input name="video_title" type="text" <?php if(isset($data[0]['video_title'])) echo 'value="'.$data[0]['video_title'].'"'; ?> /></span>
					</div>
					
					<div class="field">
						<label>Description:</label><span<?php if(isset($message['video_description']))echo ' class="error"';?>><textarea name="video_description"><?php if(isset($data[0]['video_description'])) echo $data[0]['video_description']; ?></textarea></span>
					</div>
					
					<div class="field">
						<label>Dur&eacute;e de la vid&eacute;o:</label><span<?php if(isset($message['video_duree']))echo ' class="error"';?>><input name="video_duree" class="time" <?php if(isset($data[0]['video_duree'])) echo 'value="'.$data[0]['video_duree'].'"'; ?> type="text" /></span>
					</div>
					
					<div class="field">
						<label>Vignette de la vid&eacute;o:</label><span<?php if(isset($message['video_image']))echo ' class="error"';?>><input name="video_image" type="file" /></span>
					</div>
					<!--
					<div class="field">
						<label>Vid&eacute;o:</label><span<?php if(isset($message['video_file']))echo ' class="error"';?>><input name="video_file" type="file" /></span>
					</div>
					-->
					<div class="field">
						<label>Chapitre 1:</label><span<?php if(isset($message['video_chap1_name']))echo ' class="error"';?>><input name="video_chap1_name" type="text" <?php if(isset($data[0]['video_chap1_name'])) echo 'value="'.$data[0]['video_chap1_name'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Vignette du chapitre 1:</label><span<?php if(isset($message['video_chap1_image']))echo ' class="error"';?>><input name="video_chap1_image" type="file" /></span>
					</div>
					<div class="field">
						<label>Vid&eacute;o du chapitre 1:</label><span<?php if(isset($message['video_chap1_file']))echo ' class="error"';?>><input name="video_chap1_file" type="file" /></span>
					</div>
					
					<div class="field">
						<label>Temps du chapitre 1:</label><span<?php if(isset($message['video_chap1_time']))echo ' class="error"';?>><input name="video_chap1_time" type="text" class="time" <?php if(isset($data[0]['video_chap1_time'])) echo 'value="'.$data[0]['video_chap1_time'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Chapitre 2:</label><span<?php if(isset($message['video_chap2_name']))echo ' class="error"';?>><input name="video_chap2_name" type="text" <?php if(isset($data[0]['video_chap2_name'])) echo 'value="'.$data[0]['video_chap2_name'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Vignette du chapitre 2:</label><span<?php if(isset($message['video_chap2_image']))echo ' class="error"';?>><input name="video_chap2_image" type="file" /></span>
					</div>
					
					<div class="field">
						<label>Vid&eacute;o du chapitre 2:</label><span<?php if(isset($message['video_chap2_file']))echo ' class="error"';?>><input name="video_chap2_file" type="file" /></span>
					</div>
					
					<div class="field">
						<label>Temps du chapitre 2:</label><span<?php if(isset($message['video_chap2_time']))echo ' class="error"';?>><input name="video_chap2_time" type="text" class="time" <?php if(isset($data[0]['video_chap2_time'])) echo 'value="'.$data[0]['video_chap2_time'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Chapitre 3:</label><span<?php if(isset($message['video_chap3_name']))echo ' class="error"';?>><input name="video_chap3_name" type="text" <?php if(isset($data[0]['video_chap3_name'])) echo 'value="'.$data[0]['video_chap3_name'].'"'; ?>/></span>
					</div>
					
					<div class="field">
						<label>Vignette du chapitre 3:</label><span<?php if(isset($message['video_chap3_image']))echo ' class="error"';?>><input name="video_chap3_image" type="file" /></span>
					</div>
					
					<div class="field">
						<label>Vid&eacute;o du chapitre 3:</label><span<?php if(isset($message['video_chap3_file']))echo ' class="error"';?>><input name="video_chap3_file" type="file" /></span>
					</div>
					
					<div class="field">
						<label>Temps du chapitre 3:</label><span<?php if(isset($message['video_chap3_time']))echo ' class="error"';?>><input name="video_chap3_time" type="text" class="time" <?php if(isset($data[0]['video_chap3_time'])) echo 'value="'.$data[0]['video_chap3_time'].'"'; ?>/></span>
					</div>
					
					<hr />
					<div style="margin-bottom: 15px; padding-top: 5px;">
						<h3>Option page priv&eacute;e :</h3>
						<div id="privateOption1" class="field">
							<label style="float: left;">Ajouter cette vid&eacute;o sur la page priv&eacute;e:</label>
							<span<?php if(isset($message['video_page_private']))echo ' class="error"';?>><input name="video_page_private" type="checkbox" style="width: auto;" <?php if(($data[0]['video_page_private'])) echo 'checked="checked"'; ?>/></span>
						</div>
						
						<div id="privateOption2" <?php if(!isset($data[0]['video_page_private'])) echo 'style="display: none;"'; ?> class="field">
							<label style="float: left;">Uniquement sur la page priv&eacute;e ?</label>
							<span<?php if(isset($message['video_only_page_private']))echo ' class="error"';?>><input name="video_only_page_private" type="checkbox" style="width: auto;" <?php if(($data[0]['video_only_page_private'])) echo 'checked="checked"'; ?>/></span>
						</div>
					</div>
					
					<input type="submit" class="button" value="Modifier" />
				</form>
			
			</div>
			
			<script>
			$(function() {
				$( "#privateOption1 input" ).change(function(){
					var thischeck = $(this);
					
					if (thischeck.is(':checked')) {
						$("#privateOption2").show();
					}else{
						$("#privateOption2").hide();
					}
				});
				
				$( "#datepicker" ).datepicker({
					showButtonPanel: true,
					dateFormat: 'dd-mm-yy',
					appendText: '*Par defaut la date du jour'
				});
			
				$( "#datepicker" ).datepicker({
					showButtonPanel: true,
					dateFormat: 'dd-mm-yy',
					appendText: '*Par defaut la date du jour'
				});
				
				
				$('.time').timepicker({
					showSecond: true,
					timeFormat: 'hh:mm:ss'
				});
			});
			</script>
			
			<div id="footer">
			</div>
		</div>
	</body>
</html>