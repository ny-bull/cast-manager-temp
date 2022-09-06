<?php
	$ranking_fields = get_post_custom();  //カスタムフィールドを取得
	$ranking_cast_ids = json_decode($ranking_fields['_cast_rankings'][0]);  
	$cast_type_terms = get_the_terms($post->ID, 'krc_type'); //タイプタクソノミーを取得
	$cast_grade_terms = get_the_terms($post->ID, 'krc_grade'); //グレードタクソノミーを取得
	
?>


<h2 class="sub-section"><?php the_title(); ?></h2>

<?php   
$rank = 1;
foreach ($ranking_cast_ids as $cast_id) {
	$cast = get_post_custom($cast_id, '_krc_age', '_krc_tall' , '_krc_bust' , '_krc_cups', '_krc_waist', '_krc_hips', true );  
	$cast_new_terms = get_the_terms($cast_id, 'krc_new');
?>
<div class="one-cast">
	<a href="/cast/<?php echo esc_html($cast['_krc_name'][0]);?>">
		<figure>
			<img src="<?php  $img_url = json_decode(get_post_meta($cast_id , '_cast_screens' ,true)); echo esc_url($img_url[0]); ?>" class="trimming"  alt="<?php    echo $cast ['_krc_name'][0];?> loading="lazy" " /></a>
		</figure>
		<figcaption>
			<span class="cast-name"><?php echo esc_html($cast['_krc_name'][0]);?>(<?php echo esc_html($cast['_krc_age'][0]);?>歳)</span>
			<span class="cast-size">T:<?php echo esc_html($cast['_krc_tall'][0]);?> B:<?php echo esc_html($cast['_krc_bust'][0]);?>(<?php echo esc_html($cast['_krc_cups'][0]);?>) W:<?php echo esc_html($cast['_krc_waist'][0]);?> H:<?php echo esc_html($cast['_krc_hips'][0]);?></span>
		</figcaption>
	</a>
	<?php if ( $rank < 10): ?>
		<span class="rank">
			<img src="<?php echo get_stylesheet_directory_uri();?>/images/rank<?php echo $rank; ?>.png" alt="No.<?php echo $rank; ?>"/>
		</span>
	<?php endif;?>
	<?php if ( $fncName != 'todaysCastHtml'): ?>
		<?php if (today_schedule($cast_id)):?>
			<span class="todays_cast badge">本日出勤</span>
		<?php endif;?>
	<?php endif;?>
	<?php if ( $fncName != 'outNewType'): ?>
		<?php if ( !empty($cast_new_terms[0]->name) ):?>
			<span class="new_cast badge"></span>
		<?php endif;?>
	<?php endif;?>
	<?php if ( !empty($cast['tw_id'][0]) ):?>
		<a class="tw" href="https://twitter.com/<?php echo esc_html($cast['tw_id'][0]);?>" target="_blank"></a>
	<?php endif;?>
</div>


<?php
$rank++;
} 
?>
</div>