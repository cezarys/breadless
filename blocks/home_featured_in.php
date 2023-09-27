<?php
global $section;

$title = $section['title']; //text

$logos = $section['logos']; //repeater
?>
<div id="home-featured-in">
    <div class="container-fluid">
        <div class="row row-0">
            <div class="col-sm-3">
                <h2>
                    <?php echo $title ?>
                </h2>
            </div>
            <div class="col-sm-9">
                <div class="row row-spaced">
                    <?php
                    foreach ($logos as $key => $single_logos) {
                        $logo = $single_logos['logo']; //image
                        $max_width = $single_logos['max_width']; //image
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-4" id="featured-logo-<?php echo $key ?> ">
                            <?php
                            if($max_width)
                            {
                                ?>
                            <style>
                                #featured-logo-<?php echo $key ?> img,
                                #featured-logo-<?php echo $key ?> svg
                                {
                                    max-width: <?php echo $max_width ?>rem;
                                    width:100%;
                                    height: auto;
                                }                                
                            </style>
                                <?php
                            }
                            imgOrSvg($logo);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
