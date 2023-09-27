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
                        <h2 class="oc-con-title">
                            <?php echo $title ?>
                        </h2>
                        <?php echo $content ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}