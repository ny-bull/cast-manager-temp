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
        <div class="cast-photo-wrapper"><img src="<?php echo get_stylesheet_directory_uri();?>/images/noimg.jpeg"
                alt="<?php the_title();?>"></div>
        <?php else: ?>
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
    <div class="cast-profile-main">
        <h4 class="cast-name"><?php echo esc_html($cast_fields['_krc_name'][0]);?></h4>
        <p class="cast-size">
            (<?php echo esc_html($cast_fields['_krc_age'][0]);?>)
            T.<?php echo esc_html($cast_fields['_krc_tall'][0]);?>
            B.<?php echo esc_html($cast_fields['_krc_bust'][0]);?>
            (<?php echo esc_html($cast_fields['_krc_cups'][0]);?>)
        </p>
    </div>
    <p class="cast-cp">
        <?php echo esc_html($cast_fields['krc_pr'][0]);?>
    </p>
    <?php echo '<script>console.log(' . json_encode($cast_fields) . ');</script>';?>
    <ul class="cast-type">
        <?php foreach ($cast_type_terms as $val) : ?>
        <li><?php echo esc_html($val -> name); ?></li>
        <?php endforeach; ?>
    </ul>

    <p>

    </p>
    <div class="cast-profile-meta">
        <h2 class="prof-title">PROFILE
        </h2>
        <span>
            -プロフィール-
        </span>
        <div class="prof-deital">
            <ul>
                <li>

                </li>
            </ul>
        </div>
        <div class="cast-pr">
            <pre><?php echo $cast_fields['krc_pr'][0];?></pre>
        </div>
        <?php if ( !empty($cast_fields['tw_id'][0]) ):?>
        <h2 class="title">Twitter</h2>
        <div class="cast-tw">
            <a class="twitter-timeline" data-width="300" data-height="400" data-chrome="noheader nofooter"
                href="https://twitter.com/<?php echo esc_html($cast_fields['tw_id'][0]);?>?ref_src=twsrc%5Etfw">Tweets
                by <?php echo esc_html($cast_fields['tw_id'][0]);?>
            </a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <?php endif;?>
    </div>
    <div class="cast-schedule">
        <h3 class="sub-section">スケジュール</h3>
        <?php singlecalendar(get_the_ID());?>

        <div class="wp-block-button is-style-fill">
            <a href="/schedule" class="wp-block-button__link has-white-color has-text-color has-background">出勤情報はこちら</a>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(window).load(function() {
    jQuery('.flexslider').flexslider({
        animation: "slide"
    });
});
</script>