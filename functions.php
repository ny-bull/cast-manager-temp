<?php

/*-------------------------------------------*/
/*  カスタム投稿タイプ「イベント情報」を追加
/*-------------------------------------------*/
// add_action( 'init', 'add_post_type_event', 0 );
// function add_post_type_event() {
//     register_post_type( 'event', /* カスタム投稿タイプのスラッグ */
//         array(
//             'labels' => array(
//                 'name' => 'イベント情報',
//                 'singular_name' => 'イベント情報'
//             ),
//         'public' => true,
//         'menu_position' =>5,
//         'has_archive' => true,
//         'supports' => array('title','editor','excerpt','thumbnail','author')
//         )
//     );
// }

/*-------------------------------------------*/
/*  カスタム分類「イベント情報カテゴリー」を追加
/*-------------------------------------------*/
// add_action( 'init', 'add_custom_taxonomy_event', 0 );
// function add_custom_taxonomy_event() {
//     register_taxonomy(
//         'event-cat', /* カテゴリーの識別子 */
//         'event', /* 対象の投稿タイプ */
//         array(
//             'hierarchical' => true,
//             'update_count_callback' => '_update_post_term_count',
//             'label' => 'イベントカテゴリー',
//             'singular_label' => 'イベント情報カテゴリー',
//             'public' => true,
//             'show_ui' => true,
//         )
//     );
// }

/********* 備考1 **********
Lightningはカスタム投稿タイプを追加すると、
作成したカスタム投稿タイプのサイドバー用のウィジェットエリアが自動的に追加されます。
プラグイン VK All in One Expansion Unit のウィジェット機能が有効化してあると、
VK_カテゴリー/カスタム分類ウィジェット が使えるので、このウィジェットで、
今回作成した投稿タイプ用のカスタム分類を設定したり、
VK_アーカイブウィジェット で、今回作成したカスタム投稿タイプを指定する事もできます。

/********* 備考2 **********
カスタム投稿タイプのループ部分やサイドバーをカスタマイズしたい場合は、
下記の命名ルールでファイルを作成してアップしてください。
module_loop_★ポストタイプ名★.php
*/

/*-------------------------------------------*/
/*  フッターのウィジェットエリアの数を増やす
/*-------------------------------------------*/
// add_filter('lightning_footer_widget_area_count','lightning_footer_widget_area_count_custom');
// function lightning_footer_widget_area_count_custom($footer_widget_area_count){
//     $footer_widget_area_count = 4; // ← 1~4の半角数字で設定してください。
//     return $footer_widget_area_count;
// }

/*-------------------------------------------*/
/*  <head>タグ内に自分の追加したいタグを追加する
/*-------------------------------------------*/
function add_wp_head_custom(){ ?>
<!-- head内に書きたいコード -->
<?php }
// add_action( 'wp_head', 'add_wp_head_custom',1);

function add_wp_footer_custom(){ ?>
<!-- footerに書きたいコード -->
<?php }
// add_action( 'wp_footer', 'add_wp_footer_custom', 1 );

/* --------------------------------------------------------------------------------- *
 * 追加処理
 *
 * --------------------------------------------------------------------------------- */
//wp_enqueue_style( 'animations', get_template_directory_uri() . '/css/flexslider.css' );        
//wp_enqueue_script( 'flexslider', get_template_directory_uri() .  '/js/jquery.flexslider-min.js', array( 'jquery' ), null,true );

wp_enqueue_style( 'animations', get_bloginfo( 'stylesheet_directory').'/css/flexslider.css');
wp_enqueue_script( 'flexslider', get_bloginfo( 'stylesheet_directory').'/js/jquery.flexslider-min.js', array('jquery'), null, true );

/**
 * 個人ページに表示するスケジュール
 *
 */
function singlecalendar($id)
{
	$week = array(
		"日",
		"月",
		"火",
		"水",
		"木",
		"金",
		"土"
	);
	$today = strtotime(date("Y-m-d", strtotime("+3 hour")));
	echo '<div class="krc_calendar clearfix">';
	for ($i = 0;$i <= 4;$i++)
	{
		$yy = date('w', strtotime('+' . $i . ' day'));
		$y = date('D', strtotime('+' . $i . ' day', $today));
		if (date('Y-m-d', strtotime('+' . $i . ' day', $today)) == $day) $y = 'target';
		echo '<dl><dt class="' . mb_strtolower($y) . '">' . strtoupper(date('n/j(' . $week[$yy] . ')', strtotime('+' . $i . ' day', $today))) . '</dt>';
		if ($casttime = today_schedule($id, date('Y-m-d', strtotime('+' . $i . ' day', $today))))
		{
			echo '<dd>';
			if ($casttime['starttime'] !== '0') echo esc_html($casttime['starttime']);
			echo ' ～ ';
			if ($casttime['endtime'] !== '0') echo esc_html($casttime['endtime']);
			echo '</dd></dl>';
		}
		else
		{
			echo '<dd>-</dd></dl>';
		}
	}
	echo '</div>';
}
function today_schedule($id, $day = '')
{ //本日の出勤確認
	$day = $day != '' ? $day : date("Y-m-d", strtotime("+3 hour"));
	$day = htmlentities($day, ENT_QUOTES, 'utf-8');
	$works = outschedule($day);
	if ($works && $works != 'rest' && array_key_exists($id, $works))
	{
		return $works[$id];
	}
	else
	{
		return false;
	}
}

/**
 * スケジュール取得
 *
 */
function outschedule($day)
{ //DBから該当の日付のデータを取得
	global $wpdb;
	$table_name = $wpdb->prefix . 'krc_schedules';
	$schedules = $wpdb->get_var($wpdb->prepare("SELECT work FROM $table_name WHERE day = %s AND status = %d", $day, 0));
	$works = unserialize($schedules);
	return $works; //配列にして返す

}
/**
 * スケジュールページショートコード
 */
function schedulesHtml()
{
	ob_start();
	$day = isset($_GET["works"]) ? $_GET['works'] : date("Y-m-d");
	$works = outschedule($day);
	$len = 6; //+1
	$week = array(
		"日",
		"月",
		"火",
		"水",
		"木",
		"金",
		"土"
	);

	echo '<div class="">週間のスケジュール </div>';

	echo '<nav class="week_calendar"><ul>';
	for ($i = 0;$i <= $len;$i++)
	{
		$yy = date('w', strtotime('+' . $i . ' day'));
		$y = date('D', strtotime('+' . $i . ' day'));
		if (date('Y-m-d', strtotime('+' . $i . ' day')) == $day) $y = 'target';
		echo '<li class="' . mb_strtolower($y) . '"><a href="' . home_url('/') . '/schedule/?works=' . date('Y-m-d', strtotime('+' . $i . ' day')) . '">' . strtoupper(date('n/j (' . $week[$yy] . ')', strtotime('+' . $i . ' day'))) . '</a></li>';
	}
	echo '</ul></nav>';
	$w = date('w', strtotime($day));
	echo '<div class="wp-block-group__inner-container home-block">';
	echo '<h2 class="sub-section">' . date('n/j', strtotime($day));
	echo '(' . $week[$w] . ')';
	echo 'の出勤スケジュール</h2>';

	if (!$works)
	{
		//予定がない場合
		echo '<br>';
	}
	else if ($works != 'rest')
	{
		//postid順に配列に入っているのでs_order順にした配列を作る
		$works_array = array();
		foreach ($works as $id => $val)
		{
			$works_array[$val["s_order"]] = $id;
		}
		ksort($works_array);
		foreach ($works_array as $rder => $id)
		{
			$args = array(
				'post_type' => 'cast',
				'post__in' => array(
					$id
				) ,
			);
			query_posts($args);
			while (have_posts()):
				the_post();
				set_query_var('work', $works[$id]);
				set_query_var('fncName', 'schedulehtml');
				get_template_part('content', ('castschedule'));
			endwhile;
			wp_reset_query();

		}
		echo '</div>';
	}
	else
	{
		//休み
		echo '定休日';
	}
	return ob_get_clean();
}
add_shortcode('scheduleshtml', 'schedulesHtml');

/**
 * 本日出勤ショートコード
 * TOPページ等に本日の出勤キャストを表示
 *
 */
function todaysCastHtml($day = '')
{

	ob_start();
	$time9 = 9 - 6; //6時に次の日のスケジュールに切り替わる仕様
	$day = $day != '' ? $day : date("Y-m-d", strtotime("+" . $time9 . " hour"));
	$works = outschedule($day);
	addSchedules($works);
	return ob_get_clean();
}
function addSchedules($works)
{
	$schedule = 'schedule';

	if (!$works)
	{
		//予定がない場合
		echo '<br>';
	}
	else if ($works != 'rest')
	{
		$works_array = array();
		foreach ($works as $id => $val)
		{
			$works_array[$val["s_order"]] = array(
				'id' => $id,
				'time' => $val
			);
		}
		ksort($works_array);
		foreach ($works_array as $id => $work)
		{
			$args = array(
				'post_type' => 'cast',
				'post__in' => array(
					$work['id']
				) ,
				'orderby' => 'post__in'
			);
			query_posts($args);
			while (have_posts()):
				the_post();
				set_query_var('schedule', $work['time']);
				set_query_var('fncName', 'todaysCastHtml');
				//content-castlist.phpは用意しておいて下さい。
				get_template_part('content', 'castlist');

			endwhile;
			wp_reset_query();
		}
	}
	else
	{
		//休み
		echo '定休日';
	}
}
add_shortcode('todayscasthtml', 'todaysCastHtml', 0);

/**
 * 新人キャストショートコード
 *
 */
function outNewType () {
	ob_start();

	$args = array(
	'post_type' => 'cast',
	'posts_per_page' => -1,
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'krc_new',
			'field' => 'slug',
			'terms' => "新人",
		)
	));

	query_posts($args);
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			set_query_var('fncName', 'outNewType');
			get_template_part( 'content', 'castlist' ); //content-castlist.phpは用意しておいて下さい。
		endwhile;
	endif;

	wp_reset_query();
	return ob_get_clean();

}
add_shortcode('newcasthtml', 'outNewType');


/**
 * 全女性を取得用のショートコード
 */
function outAllGirls () {
	ob_start();

	$args = array(
	'post_type' => 'cast',
	'posts_per_page' => -1
	);

	query_posts($args);
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			set_query_var('fncName', 'outAllGirls');
			get_template_part( 'content', 'castlist' ); //content-castlist.phpは用意しておいて下さい。
		endwhile;
	endif;

	wp_reset_query();
	return ob_get_clean();

}
add_shortcode('casthtml', 'outAllGirls');

/**
 * FTPアップしたイメージにアクセスしやすくする
 */
function imagepassshort($arg) {
	$content = str_replace('"images/', '"' . get_bloginfo('stylesheet_directory') . '/images/', $arg);
	return $content;
}
add_action('the_content', 'imagepassshort');

/* 子テーマのstyle.cssを読み込む */
add_action( 'wp_enqueue_scripts', 'my_enqueue_style_child' ); 
function my_enqueue_style_child() { 
    wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}


//囲み型ショートコードで出力(ボックスを装飾)
function box_func( $atts, $content = null ) {
    return '<div class="box">' . $content . '</div>';
}
add_shortcode('box', 'box_func');

// キャスト一覧用nestクラス
function nest_func( $atts, $content = null ) {
    return '<div class="cast-nest">'.do_shortcode($content).'</div>';
}
add_shortcode('nest', 'nest_func');

// 通常コンテンツ用のネストクラス
function nest_normal_func( $atts, $content = null ) {
    return '<div class="normal-nest">'.do_shortcode($content).'</div>';
}
add_shortcode('normal-nest', 'nest_normal_func');

// header用ネストクラス
function header_nest_func( $atts, $content = null ) {
    return '<div class="header-nest">'.do_shortcode($content).'</div>';
}
add_shortcode('header-nest', 'header_nest_func');