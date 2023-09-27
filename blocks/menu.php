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
                <h2>
                    <?php echo $category_name ?>
                </h2>
                <p>
                    <?php echo $description ?>
                </p>
                <?php if (!empty($products)): ?>
                    <div class="row row-spaced">
                        <?php
                        foreach ($products as $product) {
                            ?>
                            <div class="col-sm-4">
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