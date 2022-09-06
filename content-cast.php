<?php
 $cast_fields = get_post_custom(); //カスタムフィールドを全部取得
 $cast_screens = json_decode($cast_fields['_krc_cast_screens'][0]); //画像配列を用意
 $cast_type_terms = get_the_terms($post->ID, 'krc_type'); //タイプタクソノミーを取得
 $cast_grade_terms = get_the_terms($post->ID, 'krc_grade'); //グレードタクソノミーを取得
 $cast_new_terms = get_the_terms($post->ID, 'krc_new'); //新人区分タクソノミーを取得
?>

<div class="cast">
	<div class="cast-photo">
		<?php if( empty($cast_screens) ): ?>
			<div class="cast-photo-wrapper"><img src="<?php echo get_stylesheet_directory_uri();?>/images/noimg.jpg" alt="<?php the_title();?>"></div>
		<?php else: ?>
			<div id="slider" class="flexslider">
				<ul class="slides blocks-gallery-grid">
					<?php foreach ($cast_screens as $index => $value):?>
						<li class="blocks-gallery-item">
							<a href="<?php echo $value;?>" rel="gallery"> 
							<img src="<?php echo $value;?>" alt="<?php the_title();?> 写真 <?php echo ($index+1);?>">
							</a>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div id="thumbnail" class="flexslider">
				<ul class="slides">
					<?php foreach ($cast_screens as $value):?>
						<li alt="<?php the_title();?>">
							<img src="<?php echo $value;?>" alt="<?php the_title();?>">
						</li>
					<?php endforeach;?>
				</ul>
			</div>
		<?php endif;?>
	</div>
	<div class="cast-profile">
		<h2 class="sub-section"><?php echo esc_html($cast_fields['_krc_name'][0]);?></h2>
		<div class="cast-meta">
			<div class="cast-meta-left">
				年齢
			</div>
			<div class="cast-meta-right">
				<?php echo esc_html($cast_fields['_krc_age'][0]);?>歳 
			</div>
			<div class="cast-meta-left">
				身長
			</div>
			<div class="cast-meta-right">
				T:<?php echo esc_html($cast_fields['_krc_tall'][0]);?>
			</div>
			<div class="cast-meta-left">
				スリーサイズ
			</div>
			<div class="cast-meta-right">
				B:<?php echo esc_html($cast_fields['_krc_bust'][0]);?>(<?php echo esc_html($cast_fields['_krc_cups'][0]);?>) 
				W:<?php echo esc_html($cast_fields['_krc_waist'][0]);?> 
				H:<?php echo esc_html($cast_fields['_krc_hips'][0]);?>
			</div>
			<div class="cast-meta-left">
				新人区分
			</div>
			<div class="cast-meta-right">
				<div class="cast-new">
					<?php echo esc_html($cast_new_terms[0]->name);?>
				</div>
			</div>
		</div>
		<h2 class="sub-section">店長コメント</h2>
		<div class="cast-pr"><pre><?php echo $cast_fields['krc_pr'][0];?></pre></div>
		<?php if ( !empty($cast_fields['tw_id'][0]) ):?>
			<h2 class="sub-section">Twitter</h2>
			<div class="cast-tw">
				<a class="twitter-timeline" data-width="300" data-height="400" data-chrome="noheader nofooter"
					href="https://twitter.com/<?php echo esc_html($cast_fields['tw_id'][0]);?>?ref_src=twsrc%5Etfw">Tweets by <?php echo esc_html($cast_fields['tw_id'][0]);?>
				</a> 
				<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
			</div>
		<?php endif;?>
	</div>
	<div class="cast-schedule">
		<h2 class="sub-section">スケジュール</h2>
		<?php singlecalendar(get_the_ID());?>
		
		<div class="wp-block-button is-style-fill">
			<a href="/schedule" class="wp-block-button__link has-white-color has-text-color has-background">出勤情報はこちら</a>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(function ($) {
	$('#thumbnail').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 200,
		itemMargin: 5,
		asNavFor: '#slider'
	});
	
	$('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#thumbnail"
	});
});
</script>