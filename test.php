<?php

?><html>
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
			'file': "/testvideos/<?php echo $_GET['vid']?>",
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



	</body>
</html>
