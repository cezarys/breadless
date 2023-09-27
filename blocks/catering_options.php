<?php
global $section;

$content = $section['content']; //repeater


if (!empty($content)) {
    ?>
    <div id="catering-option">
        <div class="row row-0">
            <?php
            foreach ($content as $key => $single_content) {

                $title = $single_content['title']; //text

                $content = $single_content['content']; //wysiwyg
                ?>
                <div class="col-sm-6">
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
    <?php
}