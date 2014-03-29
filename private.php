<?php


include 'restrict.php';


session_start(); 
if(!isset($_SESSION['client'])){
	if(($_POST)){
	include_once "class/user.class.php";
		$userClass = new User();
		$message = $userClass->loginClient($_POST);
	}
}
include_once "class/video.class.php";
$videoClass = new Video();
?>
<html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<script type="text/javascript" src='js/swfobject.js'></script>
		<?php if(0):?>
		<style>
		#header h1 {
			height: 152px;
			background: url(/css/images/bandoMSD.jpg) center top no-repeat;
		}
		</style>
		<?php endif;?>
	</head>
	<body>
		<div id="main">
			<div id="header"><a href="/private.php"><h1>MSD TV</h1></a></div>
			
			<div id="content">
			<?php
				if(isset($_SESSION['client']) || isset($_COOKIE['remember'])){
					$is_homepage = true;			
					$videoList = $videoClass->get(array('limit'=> 2, 'private'=>true, 'video_private_display'=>'asc'));
					$stopAutoStart = true;
					
					if($videoList):
					foreach($videoList as $videoListKey => $video){
						include "tpl/block_video.tpl.php";
					}
					endif;
				}else{
					?>
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
							
							<div class="field" style="margin-bottom: 10px; font-size: 12px;">
								<p>Se Souvenir de moi <input name="remember" type="checkbox" value="1" /> </p>
							</div>
							
							<div>
								<input class="button" type="submit" value="Se connecter" />
							</div>
						</form>
					<?php
				}
			?>
			</div>
			
			<div id="footer">
			<p>
				<?php if(!$is_homepage): ?><span class="col-lelt"><a href="index.php">Retour &agrave; l'accueil</a></span><?php endif; ?>
				<span class="col-right"><a href="http://media365.fr" target="_blank">Powered by Media365</a></span>
			</p>
			</div>
		</div>
		<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-33037374-1']);
		_gaq.push(['_setDomainName', 'prod.media365.fr']);
		_gaq.push(['_trackPageview']);
		
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl : 'http://www ) + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		
		</script>
		
	</body>
</html>