<?php
global $section;

$title = $section['title']; //textarea

$text = $section['text']; //wysiwyg

$picture = $section['picture']; //image
$picture_mobile = $section['picture_mobile']; //image
if (!$picture_mobile) {
    $picture_mobile = $picture;
}
?>
<div id="about-hero">
    <div class="container-fluid">
        <div id="about-top-hero">
            <h1 data-delay="100">
                <?php echo $title ?>
            </h1>
        </div>
        <div id="about-bottom-section">
            <div class="row row-spaced">
                <div class="col-sm-6">
                    <div id="about-text" data-delay="200">
                        <?php echo $text ?>
                    </div>
                </div>
                <div class="col-sm-6" data-delay="300">
                    <div id="about-bottom-picture">
                        <div class="desktop">
                            <?php
                            imgOrSvg($picture);
                            ?>
                        </div>
                        <div class="mobile">
                            <?php
                            imgOrSvg($picture_mobile);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>