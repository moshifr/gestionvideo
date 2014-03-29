<!-- start block video -->
<?php

if($video)
{
	if(empty($video['video_chap1_file_path']))
		include_once "tpl/block_video_chapJS.tpl.php";
	else
		include_once "tpl/block_video.tpl.php";
}
?>
<!-- end block video -->

<?php $video_last = $videoClass->get(array('limit'=> 6, 'offset'=>1, 'private'=>false, 'order' => 'video_id desc'));
//$video_last = false;
?>

<?php if($video_last && $_GET['test']==''):?>
	<div id="bloc_vid">
		<div id="tetiere"><h3>Les derni&egrave;res vid&eacute;os</h3></div>
		<!-- start block listing video -->			
		<?php include_once "tpl/block_listingVideo.tpl.php"; ?>
		<!-- end block listing video -->				
	</div>
<?php endif; ?>
