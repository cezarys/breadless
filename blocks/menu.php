<?php
global $section;
$menu = $section['menu']; //repeater
?>
<div id="menu-main-feed-section">
    <div class="container-fluid">
        <?php
        foreach ($menu as $key => $single_menu) {
            $category_name = $single_menu['category_name']; //text
            $description = $single_menu['description']; //textarea
            $products = $single_menu['products']; //relationship
            ?>
            <div class="one-menu-section">
                <div class="one-menu-top">
                    <h2 data-delay="100">
                        <?php echo $category_name ?>
                    </h2>
                    <p data-delay="200">
                        <?php echo $description ?>
                    </p>
                </div>
                <?php if (!empty($products)): ?>
                    <div class="row row-spaced">
                        <?php
                        foreach ($products as $product) {
                            ?>
                            <div class="col-sm-4" data-delay="100|100|6">
                                <?php
                                oneMenu($product, true);
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php endif ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>