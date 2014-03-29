<div id="videos">
	<?php if($video_last):?>
		<?php foreach($video_last as $video_last_key => $video_last_item):?>
		<div class="video" <?php if($video_last_key%3==0) /*echo 'style="margin-left: 0;"';*/?>>
			<a class="video_link" href="?video=<?php echo $video_last_item['video_id']; ?>">
				<div class="cropImage">
					<img src="upload/img/<?php echo $video_last_item['video_img_path']; ?>" width="165" />
				</div>
				<div class="dashed" style="margin-top:5px;"></div>
				<div id="infos"><p class="titre"><?php echo $video_last_item['video_title']; ?></p>
				<p class="date"><?php echo $video_last_item['video_date']; ?></p>
				<?php if($video_last_item['video_duree']): ?>
				<p class="duree"><?php echo "Duree : " .substr($video_last_item['video_duree'], 3 , 5 )." min"?></p>
				<?php endif; ?>
				</div>
				<div id="view_button"></div>
			</a>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<div class="clear" style="overflow: auto;">
	<a id="btn-allvideo" href="?type=listing">voir toutes les vid&eacute;os</a>
</div>
<div class="clearfix"></div>
