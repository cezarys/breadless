<?php
global $section;

$menu = $section['menu']; //relationship

$button_label = $section['button_label']; //text

$button_url = $section['button_url']; //text

if (!empty($menu)) {
    ?>
    <div id="home-menu">
        <div class="container-fluid">
            <div id="home-menu-slider" class="owl-carousel">
                <?php
                foreach ($menu as $one_item) {
                    ?>
                    <div data-delay="100|100|5">
                        <?php
                        oneMenu($one_item);
                        ?>
                    </div>
                    <?php
                }
                ?>         
            </div>
            <div data-delay="300">
                <?php
                buttonWithWrapper($button_label, $button_url);
                ?>
            </div>
        </div>
    </div>
    <?php
}