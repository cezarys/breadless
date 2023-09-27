</div>

    <script>
        var google_maps_key = '<?php echo get_field('google_maps_key', 'option') ?>';
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
<script type="text/javascript" defer src="<?php echo get_url() ?>/dist/all.js.min.js?rand=<?php echo rand(1,1000); ?>"></script>
</body>
</html>