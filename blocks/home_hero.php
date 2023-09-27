<?php
global $section;

$background = $section['background']; //image
$title = $section['title']; //wysiwyg
$button_label = $section['button_label']; //text
$button_url = $section['button_url']; //text
?>
<div id="home-hero">
    <?php if($background):?>
    <style>
        #home-hero
        {
            background: url('<?php echo $background['url'] ?>') center;
            background-size: cover;
        }
    </style>
    <?php endif ?>
    <div class="container-fluid">        
        <?php
        echo $title;
        buttonWithWrapper($button_label, $button_url);
        ?>
    </div>
</div>