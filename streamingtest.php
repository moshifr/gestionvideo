
 <html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<script type="text/javascript" src='js/swfobject.js'></script>
			</head>
	<body>

		<div id="main">
			<div id="header"><a href="/"><h1>MSD TV</h1></a></div>
			
			<div id="content">
			<!-- start block video -->
<div id="player">
	<h2 id="titre" class="green" style="text-transform: none;">JT du 25 avril 2013</h2>
	<div id="mediaplayer-1"></div>
	<script type="text/javascript" src="js/jwplayer.js"></script>
	<script type="text/javascript">
		jwplayer("mediaplayer-1").setup({
			'flashplayer': "swf/player.swf",
			'file': "ITV GUY FINAL-MP4.mp4.flv",
			'streamer':'/flvprovider.php',
			'type':'flv',
			'provider':'http',
			'image': "upload/img/MSDHD.jpg",
			'controlbar': 'bottom',
			'width': '621',
			'height': '350',
			'displayheight': '350', 
			'Autostart': 'true'
					});
	</script>
</div>

<div class="clear"></div>
<!-- end block video -->


<div id="tetiere"><h3>Les derni&eacute;res vid&eacute;os</h3></div>
<!-- start block listing video -->			
<div id="videos">
					<div class="video" style="margin-left: 0;">
			<a class="video_link" href="?video=84">
				<img src="upload/img/MSDHD.jpg" width="198" height="110" />
				<p class="titre">Test JT du 26 Mai 2013</p>
				<p>04/06/2013</p>
			</a>
		</div>
				<div class="video" >
			<a class="video_link" href="?video=83">
				<img src="upload/img/MSDHD.jpg" width="198" height="110" />
				<p class="titre">JT du 26 mai 2013</p>
				<p>26/05/2013</p>
			</a>
		</div>
				<div class="video" >
			<a class="video_link" href="?video=82">
				<img src="upload/img/MSDHD.jpg" width="198" height="110" />
				<p class="titre">JT du 25 avril 2013</p>
				<p>00/00/0000</p>
			</a>
		</div>
			</div><!-- end block listing video -->				

<div class="clearfix" style="overflow: auto;">
	<a id="btn-allvideo" href="?type=listing">voir toutes les vid&eacute;os</a>
</div>
			</div>
			
			<div id="footer">
			<p>
				<span class="col-lelt"><a href="index.php">Retour &agrave; l'accueil</a></span>				<span class="col-right"><a href="http://media365.fr" target="_blank">Powered by Media365</a></span>
			</p>
			</div>
		</div>
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
	</body>
</html>
