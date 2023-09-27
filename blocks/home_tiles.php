<?php
global $section;

$tiles = $section['tiles']; //repeater



if (!empty($tiles)) {
    ?>
    <div id="home-tiles">
        <?php
        foreach ($tiles as $key => $single_tiles) {
            $picture = $single_tiles['picture']; //image
            $content = $single_tiles['content']; //wysiwyg
            $button_label = $single_tiles['button_label']; //text
            $button_url = $single_tiles['button_url']; //text
            ?>
            <div class="one-home-tile">
                <div class="row row-0">
                    <div class="col-sm-6">
                        <?php
                        imgOrSvg($picture);
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="one-home-content">
                            <?php
                            echo $content;
                            buttonWithWrapper($button_label, $button_url);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
