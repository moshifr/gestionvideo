<?php

include 'restrict.php';

include_once "class/video.class.php";

$videoClass = new Video();
?>
<!DOCTYPE html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="css/style.css?v1" type="text/css"/>
		<!-- <script type="text/javascript" src='js/swfobject.js'></script> -->
		<script type="text/javascript" src="./jwplayer/jwplayer.js?v1"></script>
		<script type="text/javascript" src='js/jquery.min.js'></script>
	</head>
	<body class="<?php if ($_GET['type']) {echo 'listing';} ?>">
		<div id="main">
			<div id="header"><a href="/"><h1>MSD TV</h1></a></div>
			<div id="c">					
					<?php 
						$is_homepage = false;
						if(isset($_GET['video']) && is_numeric($_GET['video'])){
							$video = $videoClass->get(array('limit'=> 1, 'video_id'=>$_GET['video'], 'order' => 'video_id desc'));
							$video = $video[0];
							include_once "tpl/page_video.tpl.php";
						}elseif(isset($_GET['type'])){
							include_once "tpl/page_listing.tpl.php";
						}else{
							$is_homepage = true;			
							$video = $videoClass->get(array('limit'=> 10, 'private' => false, 'order' => 'video_id desc'));
							//print_r($video);die();
							$video = $video[0];
							include_once "tpl/page_homepage.tpl.php";
						}
					?>
						
				</div>
				
				<div id="footer">
					<p>
						<?php if(!$is_homepage): ?><span class="col-lelt"><a href="index.php">Retour &agrave; l'accueil</a></span><?php endif; ?>
						<span class="col-right"><a href="http://www.media365.fr" target="_blank">Powered by Media365</a></span>
					</p>
				</div>
		</div>
		<script type="text/javascript">
		<?php if(getenv('ENV') == 'prod'): ?>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33037374-1']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		  <?php else: ?>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33037374-2']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		  <?php endif; ?>
		</script>
		
		
	</body>
</html>
