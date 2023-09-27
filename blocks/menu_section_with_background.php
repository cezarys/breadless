<?php
global $section;

$title = $section['title']; //textarea

$button_label = $section['button_label']; //text

$button_url = $section['button_url']; //text

$background = $section['background']; //image
?>
<div id="menu-section-with-background">
    <?php if($background):?>
    <style>
        #menu-section-with-background
        {
            background: url('<?php echo $background['url'] ?>');
            background-size: cover;
        }        
    </style>
    <?php endif ?>
    <div class="container-fluid">
        <h2 data-delay="100"><?php echo $title ?></h2>
        <div data-delay="200">
            <?php
            buttonWithWrapper($button_label, $button_url);
            ?>
        </div>
    </div>
</div>