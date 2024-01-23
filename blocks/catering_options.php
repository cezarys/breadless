<?php
global $section;

$content = $section['content']; //repeater


if (!empty($content)) {
    ?>
    <div id="catering-option">
        <div class="container-fluid">
            <div class="catering-slider owl-carousel">
                <?php
                foreach ($content as $key => $single_content) {

                    $title = $single_content['title']; //text

                    $content = $single_content['content']; //wysiwyg
                    ?>
                    <div class="one-catering-slide">
                        <div class="co-content">
                            <h2 data-delay="100" class="oc-con-title">
                                <?php echo $title ?>
                            </h2>
                            <div data-delay="200" class="oc-con-content">
                                <?php echo $content ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}