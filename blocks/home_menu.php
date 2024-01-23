<?php
global $section;

$menu = $section['menu']; //relationship
$new_menu = $section['new_menu']; //relationship

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

if (!empty($new_menu)) {
    ?>
    <div id="home-menu">
        <div class="container-fluid">
            <div id="new-menu-nav">
                <?php foreach ($new_menu as $key => $nm): ?>
                    <a href="#" <?php if($key==0):?>class="active"<?php endif ?> data-key="<?php echo $key ?>">
                        <?php echo $nm['tab_name'] ?>
                    </a>
                <?php endforeach ?>
            </div>
            
            <div id="home-menu-tabs" >
                <?php
                foreach ($new_menu as $key => $nm) {
                    ?>
                    <div data-key="<?php echo $key ?>" class="new-menu-tab <?php if($key==0):?>active<?php endif ?>">
                        <div class="new-menu-slider owl-carousel">
                            <?php
                            foreach ($nm['menu'] as $m) {
                                ?>
                                <div class="one-menu-slide">
                                    <?php
                                    oneMenu($m);
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
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