<?php
	$limit_page = 20;
	
	$result_nb = count($videoClass->get());
	$page_total = ceil($result_nb/$limit_page);
	
	
	//page courante
	if(isset($_GET['page']) && is_numeric($_GET['page']) && $page_total>=$_GET['page']){
		$page_current = $_GET['page'];
		$offset = $page_current;
	}else{
		$page_current = 1;
		$offset = 0;
	}
	
	//page precedent
	if( ($page_current-1)<= $page_total && ($page_current-1)> 0 ){
		$page_prev = $page_current-1;
	}else{
		$page_prev = 1;
	}
	
	//page suivante
	if( ($page_current+1)<= $page_total){
		$page_next = $page_current+1;
	}else{
		$page_next = 1;
	}
	
	$video_last = $videoClass->get(array('limit'=> $limit_page, 'offset'=>$offset, 'private'=>false));
	
	//die($page_total);
?>
<div id="bloc_vid">
<div id="tetiere"><h3>Les dernières vidéos</h3></div>
<!-- start block listing video -->			
<?php include_once "tpl/block_listingVideo.tpl.php"; ?>
<!-- end block listing video -->

<!--

<ul id="pagination">
	<li class="prev"><a href="?type=listing&page=<?php echo $page_prev;?>">Precedent</a></li>
	<?php for($i = 0; $i<$page_total; $i++):?>
		<li <?php if($page_current == ($i+1) ) echo 'class="current"'; ?> ><a href="?type=listing&page=<?php echo ($i+1);?>"><?php echo ($i+1);?></a></li>
	<?php endfor; ?>	
	<li class="next"><a href="?type=listing&page=<?php echo $page_next;?>">Suivant</a></li>
</ul>
-->
</div>