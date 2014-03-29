<?php 

	//log consulation video
	$myVideo = $video['video_id'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip = $_SERVER['REMOTE_ADDR'];
	if($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$db_consult_query = 'INSERT INTO log_consultation (log_consultation_ip,log_consultation_video,log_consultation_user_agent,log_consultation_date) VALUES ("'. $ip .'", "'. $myVideo .'", "'.$user_agent.'", NOW())';
	mysql_query($db_consult_query);
	//fin log consultation


	if(!isset($videoListKey)){
		$videoListKey = 1;
	}
	if(!isset($stopAutoStart)){
		$stopAutoStart = "true";
	}else{
		$stopAutoStart = "false";
	}
	
	$duree_chap3 = strtotime($video['video_duree'])-strtotime($video['video_chap3_time']);
	$duree_chap2 = strtotime($video['video_chap3_time'])-strtotime($video['video_chap2_time']);
	$duree_chap1 = strtotime($video['video_chap2_time'])-strtotime($video['video_chap1_time']);
	
	$myDate = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		
	$begin_chap1 = strtotime($video['video_chap1_time'])-$myDate;
	$begin_chap2 = strtotime($video['video_chap2_time'])-$myDate;
	$begin_chap3 = strtotime($video['video_chap3_time'])-$myDate;
	
?>

<div id="content" class="asupp">
					<div id="content_header" class="asupp"></div>
<div id="player">
	<div id="barre"><h2  id="titre" class="green" style="text-transform: none;"><?php echo $video['video_title']?><br />
	<div id="subtitle"><?php echo $video['video_date'].' - Duree : '. substr($video['video_duree'],3,5).' min'?></div></h2></div>
	<p id="placeholder" style="height:0px;">&nbsp;</p>
	<div id="mediaplayer-<?php echo $videoListKey; ?>">
	
	
	</div>
	<script type="text/javascript" src="jwplayer/JWPlayer-5.3-RC1/jwplayer.js?v1"></script>
	
	<script>
	 jwplayer("mediaplayer-<?php echo $videoListKey; ?>").setup({
		flashplayer: "/jwplayer/JWPlayer-5.3-RC1/player.swf",
		file: "/upload/videos/<?php echo $video['video_file_path'];?>",
		image: "/upload/img/<?php echo $video['video_img_path'];?>",
		height: 350,
		width: 570,
		//provider: 'http',
		//streamer: 'http://msd.preprod.media365.fr/flvprovider.php',
		autostart: true
	});
	 </script>
	
	<script type="text/javascript">

		var debutChap1 = <?php echo $begin_chap1; ?>;
		var debutChap2 = <?php echo $begin_chap2; ?>;
		var debutChap3 = <?php echo $begin_chap3; ?>;

		/*
		if (jQuery.browser.msie == true) { 
			if(jQuery.browser.version < 9)
			{
				//alert(debutChap2);
				//debutChap1 = debutChap1 + 3;
				debutChap2 = debutChap2 + 5;
				//debutChap3 = debutChap3 + 3;
				//alert(debutChap2);
			}
		}*/
		

		
		
		/*
		jwplayer("mediaplayer-<?php echo $videoListKey; ?>").setup({
			//'flashplayer': "/swf/player.swf?fefef",
			'file': "/upload/videos/<?php echo $video['video_file_path']?>?v2",
			//'streamer':'http://msd.preprod.media365.fr/flvprovider.php',
			//'type':'flv',
			//'provider':'http',
			'image': "/upload/img/<?php echo $video['video_img_path']?>",
			'controlbar': 'bottom',
			'width': '570',
			'height': '350',
			'displayheight': '350',
			'autostart': '<?php echo $stopAutoStart; ?>'
			<? //if($is_homepage) echo ",Autostart: 'true'"; ?>
		});
		*/
	</script>
	</div>
	<div id="sep"></div>
	<div id="decoupage">
		<div id="integral_video">  <div class="barre"> &nbsp; L'int&eacute;gral</div>
			<a href="javascript://" onclick="jwplayer('mediaplayer-<?php echo $videoListKey; ?>').seek(0); encours();"> 
				<img src="upload/img/<?php echo $video['video_img_path']; ?>" width="115" height="65" />
			</a>
			<div class="separ dashed" style="width: 115px;"></div>
			<div id="en_cours"></div>
			<div class="init blue">
				<span class="bold"><?php echo 'L\'int&eacute;gral' . '<br />' ?></span>
				<span class="nobold"><?php echo 'Dur&eacute;e : '. str_replace('-', ':', substr ( $video['video_duree'] ,3, 5 )).' min'?></span>
			</div>
		</div>
		<?php if($video['video_chap1_time'] != '00:00:00' && $video['video_chap2_time'] != '00:00:00' && $video['video_chap3_time'] != '00:00:00'): ?>
		<div id="chap1"> <div class="barre"> &nbsp; Votre journal en s&eacute;quences</div>
			<a href="javascript://" onclick="jwplayer('mediaplayer-<?php echo $videoListKey; ?>').seek(debutChap1); encours2();"> 
				<img src="upload/img/<?php if($video['video_chap1_image']){echo $video['video_chap1_image'];} else{echo $video['video_img_path'];} ?>" width="115" height="65" />
			</a>
			<div class="separ dashed"></div>
			<div class="1 grey">
				<span class="bold"><?php echo $video['video_chap1_name'] . '<br />' ?></span>
				<span class="nobold">Dur&eacute;e : <?php echo date('i:s', $duree_chap1); ?></span>
			</div>
		</div>
		<div id="chap2">
			<a href="javascript://" onclick="jwplayer('mediaplayer-<?php echo $videoListKey; ?>').seek(debutChap2); encours3();"> 
				<img src="upload/img/<?php if($video['video_chap2_image']){echo $video['video_chap2_image'];} else{echo $video['video_img_path'];} ?>" width="115" height="65" />
			</a>
			<div class="separ dashed"></div>
			<div class="2 grey">
				<span class="bold"><?php echo $video['video_chap2_name'] . '<br />' ?></span>
				<span class="nobold">Dur&eacute;e : <?php echo date('i:s', $duree_chap2); ?></span>
			</div>
		</div>
		<div id="chap3"> 
			<a href="javascript://" onclick="jwplayer('mediaplayer-<?php echo $videoListKey; ?>').seek(debutChap3); encours4();"> 
				<img src="upload/img/<?php if($video['video_chap3_image']){echo $video['video_chap3_image'];} else{echo $video['video_img_path'];} ?>" width="115" height="65" />
			</a>
			<div class="separ dashed"></div>
			<div class="3 grey">
				<span class="bold"><?php echo $video['video_chap3_name'] . '<br />' ?></span>
				<span class="nobold">Dur&eacute;e : <?php echo date('i:s', $duree_chap3); ?></span>
			</div>
		</div>
		<?php endif; ?>
</div>

<div class="clear"></div>
<script type="text/javascript">
				  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33037374-2']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		  		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#en_cours").css
				({ 
					display : "block", 
					left: "20px"
				}) 
				
				$(".init").addClass('blue');
			});
			
			function encours()
			{
				$("#en_cours").css
				({ 
					display : "block",
					left: "20px"
				});
				
				$(".init").removeClass('grey').addClass('blue');
				$(".1, .2, .3").removeClass('blue').addClass('grey');
			}
			
			function encours2()
			{
				$("#en_cours").css
				({ 
					display : "block",
					left: "170px"
				});
				
				$(".init").removeClass('blue').addClass('grey');
				$(".2, .3").removeClass('blue').addClass('grey');
				$(".1").removeClass('grey').addClass('blue');
			}
			function encours3()
			{
				$("#en_cours").css
				({ 
					display : "block",
					left: "310px"
				});
				
				$(".init").removeClass('blue').addClass('grey');
				$(".1, .3").removeClass('blue').addClass('grey');
				$(".2").removeClass('grey').addClass('blue');
			}
			function encours4()
			{
				$("#en_cours").css
				({ 
					display : "block",
					left: "450px"
				});
				console.log('test');
				$(".init").removeClass('blue').addClass('grey');
				$(".1, .2").removeClass('blue').addClass('grey');
				$(".3").removeClass('grey').addClass('blue');
			}

			$(document).ready(function(){
			<?php
			if(isset($_GET['chapitre']) && !empty($_GET['chapitre']))
			{
				if($_GET['chapitre'] == 1)
				{
					echo 'jwplayer().seek(debutChap1); encours3();';
				}
				elseif($_GET['chapitre'] == 2)
				{
					echo 'jwplayer().seek(debutChap2); encours3();';
				}	
				elseif($_GET['chapitre'] == 3)
				{
					echo 'jwplayer().seek(debutChap3); encours4();';
				}	
			}
			?>
			});
			
		</script>
</div>

<?php //endif; ?>
