<?php
global $section;

$title = $section['title']; //textarea

$text = $section['text']; //wysiwyg

$picture = $section['picture']; //image
?>
<div id="about-hero">
    <div class="container-fluid">
        <div id="about-top-hero">
            <h1>
                <?php echo $title ?>
            </h1>
        </div>
        <div id="about-bottom-section">
            <div class="row row-spaced">
                <div class="col-sm-6">
                    <div id="about-text">
                        <?php echo $text ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="about-bottom-picture">
                        <?php
                        imgOrSvg($picture);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>