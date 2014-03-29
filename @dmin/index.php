<?php
session_start(); 

if(isset($_GET['logout'])){
	session_destroy();
	header('Location: index.php');
}elseif(isset($_SESSION['user'])){
	header('Location: list_video.php');
}

if(($_POST)){
include_once "../class/user.class.php";
	$userClass = new User();
	$message = $userClass->login($_POST);
}
?>
<html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css"/>
		<script type="text/javascript" src='../js/swfobject.js'></script>
	</head>
	<body>
		<div id="main">
			<div id="header"></div>

				<div id="content">	
					<h2>Identification</h2>
				
					
					<?php
						if(isset($message)){
							echo '<div class="msg-error">';
							foreach($message['txt'] as $item){
								echo '<p>'.$item.'</p>';
							}
							echo '</div>';
						}
					?>
					
					<form method="post">
						<div class="field">
							<label>Pseudo:</label><span<?php if(isset($message['user_pseudo']))echo ' class="error"';?>><input name="user_pseudo" type="text" <?php if(isset($_POST['user_pseudo'])) echo 'value="'.$_POST['user_pseudo'].'"'; ?> /></span>
						</div>
						
						<div class="field">
							<label>Mot de passe:</label><span<?php if(isset($message['user_password']))echo ' class="error"';?>><input name="user_password" type="password" <?php if(isset($_POST['user_password'])) echo 'value="'.$_POST['user_password'].'"'; ?> /></span>
						</div>
						
						<div>
							<input class="button" type="submit" value="Se connecter" />
						</div>
					</form>
				
				</div>
				<div class="clear"></div>
			
			
			<div id="footer">
			</div>
		</div>
	</body>
</html>