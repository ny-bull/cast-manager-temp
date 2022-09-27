<div class="floating-banner">
    <a class="leftbox" href="/schedule/"><i class="far fa-calendar-alt"></i>
        <p>出勤表</p>
    </a>
    <a class="mainbox" href="tel:09060667925"><i class="fas fa-mobile-alt"></i>
        <p>ご予約</p>
    </a>
    <a class="rightbox" href="/therapist/"><i class="fa fa-female" aria-hidden="true"></i>
        <p>女性一覧</p>
    </a>
</div>
<?php if ( is_active_sidebar( 'footer-upper-widget-1' ) ) : ?>
<div class="section sectionBox siteContent_after">
    <div class="container ">
        <div class="row ">
            <div class="col-md-12 ">
                <?php dynamic_sidebar( 'footer-upper-widget-1' ); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php do_action( 'lightning_footer_before' ); ?>

<footer class="<?php lightning_the_class_name( 'siteFooter' ); ?>">
    <?php if ( has_nav_menu( 'Footer' ) ) : ?>
    <div class="footerMenu">
        <div class="container">
            <?php
				wp_nav_menu(
					array(
						'theme_location' => 'Footer',
						'container'      => 'nav',
						'items_wrap'     => '<ul id="%1$s" class="%2$s nav">%3$s</ul>',
						'fallback_cb'    => '',
						'depth'          => 1,
					)
				);
				?>
        </div>
    </div>
    <?php endif; ?>
    <?php
	$footer_widget_area_count = 3;
	$footer_widget_area_count = apply_filters( 'lightning_footer_widget_area_count', $footer_widget_area_count );
	$footer_widget_exists = false;
	for ( $i = 1; $i <= $footer_widget_area_count; $i++ ) {
		if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
			$footer_widget_exists = true;
		}
	}
	?>
    <?php if ( true === $footer_widget_exists ) : ?>
    <div class="container sectionBox footerWidget">
        <div class="row">
            <?php
				// Area setting
				$footer_widget_area = array(
					// Use 1 widget area
					1 => array( 'class' => 'col-md-12' ),
					// Use 2 widget area
					2 => array( 'class' => 'col-md-6' ),
					// Use 3 widget area
					3 => array( 'class' => 'col-md-4' ),
					// Use 4 widget area
					4 => array( 'class' => 'col-md-3' ),
					// Use 6 widget area
					6 => array( 'class' => 'col-md-2' ),
				);

				// Print widget area
				for ( $i = 1; $i <= $footer_widget_area_count; ) {
					echo '<div class="' . $footer_widget_area[ $footer_widget_area_count ]['class'] . '">';
					if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
						dynamic_sidebar( 'footer-widget-' . $i );
					}
					echo '</div>';
					$i++;
				}
				?>
        </div>
    </div>
    <?php endif; ?>

    <?php do_action( 'lightning_copySection_before' ); ?>

    <div class="box-follow">
        <p class="title-sns">FOLLOW US</p>
        <ul>
            <li><a href="https://twitter.com/shiga_rose" target="_blank" class="fab fa-twitter fa-1x"></a></li>
            <li><a href="https://www.instagram.com/shiga_rose/" target="_blank" class="fab fa-instagram fa-1x"></a></li>
            <li><a href="http://line.me/R/ti/p/%40096hzoga" target="_blank" class="fab fa-line fa-1x"></a></li>
        </ul>
    </div>
    <div class="footer_bottom">
        <div class="inner">
            <figure><img src="https://cast-manager-test.com/wp-content/uploads/2022/09/lose_log.png" alt="SWEET ROSE">
            </figure>
            <ul>
                <li><a href="/privacy.html">プライバシーポリシー</a></li>
                <li><a href="/sitemap.html">サイトマップ</a></li>
            </ul>
            <p>滋賀・草津メンズエステ【スイートロゼ】オフィシャルWEBサイトへようこそ！<br>
                日本人女性のセラピストによる本格メンズエステ＆リラクゼーションサロンです。<br>
                心安らぐ厳選されたセラピストと楽しい会話、お好きなアロマ・オイルのトリートメントで、極上の癒しをお楽しみください。</p>
        </div>
    </div>

    <div class="copyright">
        <div class="inner">
            <p><small>滋賀・草津メンズエステ【スイートロゼ】<br class="pcnone">copyright © 2022 SWEET ROSE All Rights Reserved.</small></p>
        </div>
    </div>
</footer>
<?php do_action( 'lightning_footer_after' ); ?>
<?php wp_footer(); ?>
</body>

</html>