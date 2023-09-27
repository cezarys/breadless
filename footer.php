<?php
$footer_logo = get_field('footer_logo', 'option'); //image
$footer_newsletter_text_1 = get_field('footer_newsletter_text_1', 'option'); //text
$footer_newsletter_text_2 = get_field('footer_newsletter_text_2', 'option'); //textarea
$footer_form_shortcode = get_field('footer_form_shortcode', 'option'); //text
$footer_copyright = get_field('footer_copyright', 'option'); //text
?>
<footer>
    <div class="row row-0">
        <div class="col-sm-6">
            <div class="footer-left-row">
                <div class="footer-menus">
                    <div class="column-1">
                        <?php
                        imgOrSvg($footer_logo);
                        ?>
                    </div>
                    <div class="column-2">
                        <?php
                        wp_nav_menu(['theme_location' => 'footer-menu']);
                        ?>
                    </div>
                    <div class="column-3">
                        <?php
                        wp_nav_menu(['theme_location' => 'footer-menu-2']);
                        ?>
                    </div>
                </div>
                <div class="footer-copyright">
                    <?php echo $footer_copyright ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="footer-right-row">
                <div>
                    <p class="footer-sub-text-1">
                        <?php echo $footer_newsletter_text_1 ?>
                    </p>
                    <p class="footer-sub-text-1">
                        <?php echo $footer_newsletter_text_2 ?>
                    </p>
                    <?php echo do_shortcode($footer_form_shortcode) ?>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

<script>
    var google_maps_key = '<?php echo get_field('google_maps_key', 'option') ?>';
    var leftArrow = '<?php echo loadSvg('arrow-left.svg') ?>';
    var rightArrow = '<?php echo loadSvg('arrow-right.svg') ?>';
</script>

<?php wp_footer() ?>
<div class="the-modal" id="">
    <div>
        <div class="the-modal-content">
            <a href="#" class="close-the-modal"></a>
            <?php /* content */ ?>
        </div>
    </div>
</div>
<script type="text/javascript" defer src="<?php echo get_url() ?>/dist/all.js.min.js?rand=<?php echo rand(1, 1000); ?>"></script>
</body>
</html>