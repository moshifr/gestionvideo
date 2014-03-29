<?php
session_start(); 
if(!isset($_SESSION['user'])){
	header('Location: index.php');
}

include_once "../class/video.class.php";
$videoClass = new Video();
$data = $videoClass->get(array('private'=>false));
$data2 = $videoClass->get(array('private'=>true, 'video_private_display'=>'asc'));
$data3 = $videoClass->get(array('private'=>true, 'video_private_archive'=>'asc'));

//print_r($data);die;
if(isset($_GET['pos']) && $_POST ){
	//print_r($_POST);die;
	$videoClass->savePosPrivate($_POST);
	header("Location: list_video.php");
}


if(isset($_GET['del']) && is_numeric($_GET['del'])){
	$message = $videoClass->del($_GET['del']);
	
	if(!$message){
		header('Location: list_video.php');
	}
}
?>
<html>
	<head>
		<title>MSD</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css"/>
		<script type="text/javascript" src='../js/swfobject.js'></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="header"></div>
				
				<div class="fill">
					<div class="container">
						<ul class="nav">
							<li><a href="#">Accueil</a></li>
							<li><a href="add_video.php">Ajouter une video</a></li>
							<li class="active"><a href="list_video.php">Lister les videos</a></li>
							<li><a href="index.php?logout">Deconnexion</a></li>
						</ul>
					</div>
				</div>
				
				<div id="content">	
					<h2>Liste des vid&eacute;os</h2>
				
					<?php
						if(isset($message)){
							echo '<div class="msg-error">';
							foreach($message['txt'] as $item){
								echo '<p>'.$item.'</p>';
							}
							echo '</div>';
						}
					?>
				
					<table class="table-style">
						<thead>
							<tr>
								<th>ID</th>
								<th>Titre</th>
								<th>Date</th>
								<th>Image</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($data):
									foreach($data as $data_item):
										if(!$data_item['video_only_page_private']):
							?>
							<tr>
								<td><?php echo $data_item['video_id'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td><?php echo $data_item['video_date_create'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td class="action">
									<a class="del<?php if($data_item['video_page_private']) echo ' duplicate' ?>" href="?del=<?php echo $data_item['video_id'];?>">Supprimer</a>
									<a href="edit_video.php?video=<?php echo $data_item['video_id'];?>">Editer</a>
								</td>
							</tr>
							<?php 
									endif;
									endforeach;
								endif;
							?>
						</tbody>
					<table>
					
					<h2>Liste des vid&eacute;os priv&eacute;e</h2>
					<form action="?pos" method="post">
					<table class="table-style">
						<thead>
							<tr>
								<th>pos</th>
								<th>ID</th>
								<th>Titre</th>
								<th>Date</th>
								<th>Image</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($data2):
									foreach($data2 as $data_item):
										if($data_item['video_page_private']):
							?>
							<tr>
								<td><input name="pos[<?php echo $data_item['video_id'];?>]" style="width: 25px;" type="text" value="<?php echo $data_item['video_private_position'];?>" /></td>
								<td><?php echo $data_item['video_id'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td><?php echo $data_item['video_date_create'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td class="action">
									<a class="del <?php if(!$data_item['video_only_page_private']) echo ' duplicatePrivate' ?>" href="?del=<?php echo $data_item['video_id'];?>">Supprimer</a>
									<a href="edit_video.php?video=<?php echo $data_item['video_id'];?>">Editer</a>
								</td>
							</tr>
							<?php 
									endif;
									endforeach;
								endif;
							?>
							<?php 
								if($data3):
									foreach($data3 as $data_item):
										if($data_item['video_page_private']):
							?>
							<tr>
								<td><input name="pos[<?php echo $data_item['video_id'];?>]" style="width: 25px;" type="text" value="<?php echo $data_item['video_private_position'];?>" /></td>
								<td><?php echo $data_item['video_id'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td><?php echo $data_item['video_date_create'];?></td>
								<td><?php echo $data_item['video_title'];?></td>
								<td class="action">
									<a class="del <?php if(!$data_item['video_only_page_private']) echo ' duplicatePrivate' ?>" href="?del=<?php echo $data_item['video_id'];?>">Supprimer</a>
									<a href="edit_video.php?video=<?php echo $data_item['video_id'];?>">Editer</a>
								</td>
							</tr>
							<?php 
									endif;
									endforeach;
								endif;
							?>
						</tbody>
					<table>
					
					<div style="text-align: right; margin-top:10px;"><input class="button" type="submit" value="sauvegarder les positions" /></div>
					</form>
					<div style="margin-top: 15px;">
						Acc&egrave;s page priv&eacute;e : <a target="_blank" href="http://msd.preprod.media365.fr/private.php">http://msd.preprod.media365.fr/private.php</a>						
					</div>
				</div>
				<div class="clear"></div>
			
			
			<div id="footer">
			</div>
		</div>
		
		<script type="text/javascript">
			$('a.del').click(function(event){
				var element = $(this);
				event.preventDefault();
				var href = element.attr('href');
				
				if (confirm("Voulez-vous supprimer cette vid\351o?")) {
				   
				   if(element.hasClass('duplicate')){
						if (confirm("Si vous supprimez cette vid\351o, elle sera \351galement supprim\351e de la page priv\351e. si vous ne voulez pas supprimer la vid\351o de la page priv\351e veuillez \351diter cette vid\351o et d\351cocher l\'option Ajouter cette vid\351o sur la page priv\351e.")) {
							document.location = href;
					   }
				   }else if(element.hasClass('duplicatePrivate')){
						if (confirm("Si vous supprimez cette vid\351o, elle sera \351galement supprim\351e de la page classique. si vous ne voulez pas supprimer la vid\351o de la page classque veuillez \351diter cette vid\351o et d\351cocher l\'option Ajouter cette vid\351o sur la page priv\351e.")) {
							document.location = href;
					   }
				   }else{
						document.location = href;
				   }
				   
			   }
			});
		</script>
	</body>
</html>