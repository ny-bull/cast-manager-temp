<?php
?>

<?php
	$cast_fields = get_post_custom(); //カスタムフィールドを全部取得
	$cast_screens = json_decode($cast_fields['_krc_cast_screens'][0]); //画像配列を用意
	$cast_type_terms = get_the_terms($post->ID, 'krc_type'); //タイプタクソノミーを取得
	$cast_grade_terms = get_the_terms($post->ID, 'krc_grade'); //グレードタクソノミーを取得
	$cast_new_terms = get_the_terms($post->ID, 'krc_new'); //新人区分タクソノミーを取得
?>

<div class="one-cast">
	<?php if( empty($cast_screens) ): ?>
		<a href="<?php echo get_template_directory_uri();?>/img/noimg.jpg" alt="<?php the_title();?>" class="iframe">
	<?php else: ?>
		<a href="/cast/<?php echo esc_html($cast_fields['_krc_name'][0]);?>">
			<figure>
				<img src="<?php echo $cast_screens[0];?>" alt="<?php the_title();?>">
			</figure>
			<figcaption>
				<span class="cast-name"><?php echo esc_html($cast_fields['_krc_name'][0]);?>(<?php echo esc_html($cast_fields['_krc_age'][0]);?>歳)</span>
				<span class="cast-size">T:<?php echo esc_html($cast_fields['_krc_tall'][0]);?> B:<?php echo esc_html($cast_fields['_krc_bust'][0]);?>(<?php echo esc_html($cast_fields['_krc_cups'][0]);?>) W:<?php echo esc_html($cast_fields['_krc_waist'][0]);?> H:<?php echo esc_html($cast_fields['_krc_hips'][0]);?></span>
			</figcaption>
		</a>
		<?php if ( $fncName != 'outNewType'): ?>
			<?php if ( !empty($cast_new_terms[0]->name) ):?>
				<span class="new_cast badge"></span>
			<?php endif;?>
		<?php endif;?>
		<span class="worktime badge"><?php echo $work['starttime']; ?> ～ <?php echo $work['endtime']; ?></span>
		<?php if ( !empty($cast_fields['tw_id'][0]) ):?>
			<a class="tw" href="https://twitter.com/<?php echo esc_html($cast_fields['tw_id'][0]);?>" target="_blank"></a>
		<?php endif;?>
	<?php endif;?>
</div>