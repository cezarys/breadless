<?php
global $section;

$title = $section['title']; //textarea

$text = $section['text']; //textarea

$button_label = $section['button_label']; //text

$button_url = $section['button_url']; //text

$picture = $section['picture']; //image
?>
<div id="catering-hero">
    <div class="row row-0">
        <div class="col-sm-6">
            <?php
            imgOrSvg($picture);
            ?>
        </div>
        <div class="col-sm-6">
            <div id="catering-hero-content">
                <h1>
                    <?php echo $title ?>
                </h1>
                <p>
                    <?php echo $text ?>
                </p>
                <?php
                buttonWithWrapper($button_label, $button_url);
                ?>
            </div>
        </div>
    </div>
</div>
