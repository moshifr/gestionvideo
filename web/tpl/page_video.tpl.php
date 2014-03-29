<!-- start block video -->
<?php 
//include_once "tpl/block_video.tpl.php";
if(empty($video['video_chap1_file_path']))
	include_once "tpl/block_video_chapJS.tpl.php";
else
	include_once "tpl/block_video.tpl.php";
?>
<!-- end block video -->


<?php $video_last = $videoClass->get(array('limit'=> 3, 'offset'=>0, 'private'=>false)); 
//$video_last=  false;
if($video_last) 
{
?>
<div id="bloc_vid">
<div id="tetiere"><h3>Les derni&eacute;res vid&eacute;os</h3></div>
<!-- start block listing video -->			
<?php include_once "tpl/block_listingVideo.tpl.php"; ?>
<!-- end block listing video -->				


<?php }?>
</div>