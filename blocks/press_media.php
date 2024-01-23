<?php
global $section;

$title = $section['title']; //text
$text = $section['text']; //text
$slider = $section['slider']; //repeater
?>
<?php if (!empty($slider)): ?>
    <div id="press-media">
        <div class="container-fluid">
            <div id="press-media-top">
                <h1>
                    <?php echo $title ?>
                </h1>
                <p>
                    <?php echo $text ?>
                </p>
            </div>
            <div id="press-media-slider" class="owl-carousel">
                <?php
                foreach ($slider as $key => $single_slider) {
                    $picture = $single_slider['picture']; //image
                    $title = $single_slider['title']; //text
                    $date = $single_slider['date']; //text
                    $text = $single_slider['text']; //textarea
                    $url = $single_slider['url']; //text
                    ?>
                    <div class="one-press-slide">
                        <p class="ops-picture">
                            <?php if ($url): ?>
                                <a href="<?php echo $url ?>" target="_blank">
                                <?php endif ?>
                                <?php
                                imgOrSvg($picture);
                                ?>
                                <?php if ($url): ?>
                                </a>
                            <?php endif ?>
                        </p>
                        <p class="osp-title-date">
                            <span>
                                <?php echo $title ?>
                            </span>
                            <span>
                                <?php echo $date ?>
                            </span>
                        </p>
                        <p class="osp-text">
                            <?php echo $text ?>
                        </p>
                        <?php if ($url): ?>
                            <p class="osp-view-more">
                                <a href="<?php echo $url ?>">
                                    <span>VIEW MORE</span>
                                    <?php
                                    echo loadSvg('pink-arrow.svg');
                                    ?>
                                </a>
                            </p>
                        <?php endif ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php






 endif ?>