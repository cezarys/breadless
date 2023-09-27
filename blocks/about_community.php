<?php
global $section;

$title = $section['title']; //text

$slider = $section['slider']; //repeater
?>
<div id="about-community">
    <div class="container-fluid">
        <h2 data-delay="100">
            <?php echo $title ?>
        </h2>
        <div id="about-community-slider" class="owl-carousel">
            <?php
            foreach ($slider as $key => $single_slider) {

                $picture = $single_slider['picture']; //image
                $title = $single_slider['title']; //text
                $date = $single_slider['date']; //text
                $text = $single_slider['text']; //text
                $url = $single_slider['url']; //text
                
                ?>
                <div data-delay="100|100|8" class="one-about-carousel">
                    <p class="oac-picture">
                        <a href="<?php echo $url ?>">
                            <?php
                            imgOrSvg($picture);
                            ?>
                        </a>
                    </p>
                    <p class="oac-title">
                        <span>
                            <?php echo $title ?>
                        </span>
                        <span>
                            <?php echo $date ?>
                        </span>
                    </p>
                    <p class="oac-text"><?php echo $text ?></p>
                    <?php if ($url): ?>
                        <p class="oac-see-more">
                            <a href="<?php echo $url ?>">
                                See More
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