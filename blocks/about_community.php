<?php
global $section;

$title = $section['title']; //text

$slider = $section['slider']; //repeater


$slider = get_posts([
    'posts_per_page'=>-1,
    'post_type'=>'tribe_events'
]);
//var_dump($slider);

?>
<div id="about-community">
    <div class="container-fluid">
        <h2 data-delay="100">
            <?php echo $title ?>
        </h2>
        <div id="about-community-slider" class="owl-carousel">
            <?php
            foreach ($slider as $key => $single_slider) {

                //$picture = $single_slider['picture']; //image
                $title = $single_slider->post_title; //text
                $date = ''; //text
                $text = get_the_excerpt($single_slider->ID);
                $url = get_permalink($single_slider->ID);//$single_slider['url']; //text
                $date = get_post_meta($single_slider->ID,'_EventStartDate',true);
                $date = strtotime($date);
                $date = date('m.d.Y',$date);
                ?>
                <div data-delay="100|100|8" class="one-about-carousel">
                    <p class="oac-picture">
                        <a href="<?php echo $url ?>">
                            <?php
                            echo get_the_post_thumbnail($single_slider->ID,'full');
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