<?php
global $section;

$title = $section['title']; //textarea
$text = $section['text']; //textarea
$locations = $section['locations']; //repeater



if (!empty($locations)) {
    ?>
    <div id="locations">
        <div class="container-fluid">
            <div id="locations-top">
                <div class="row row-spaced">
                    <div class="col-sm-5">
                        <h1 data-delay="100">
                            <?php echo nl2br($title); ?>
                        </h1>
                    </div>
                    <div class="col-sm-7">
                        <p><?php echo nl2br($text); ?></p>
                    </div>
                </div>
            </div>
            <div class="row row-spaced">
                <?php
                foreach ($locations as $key => $single_locations) {
                    $position_on_the_map = $single_locations['position_on_the_map']; //google_map
                    $or_picture = $single_locations['or_picture']; //google_map
                    $name = $single_locations['name']; //text
                    $address = $single_locations['address']; //text
                    $operation_hours = $single_locations['operation_hours']; //textarea
                    $phone = $single_locations['phone']; //text
                    ?>
                    <div class="col-sm-6">
                        <div class="one-location">
                            <?php if ($or_picture): ?>
                                <p class="ol-picture">
                                    <?php
                                    imgOrSvg($or_picture);
                                    ?>
                                </p>
                            <?php else: ?>
                                <div data-delay="100" class="the-map" data-lat="<?php echo $position_on_the_map['lat'] ?>" data-lng="<?php echo $position_on_the_map['lng'] ?>"></div>
                            <?php endif ?>
                            <div>
                                <h3 data-delay="200">
                                    <?php echo $name ?>
                                </h3>
                                <p class="address" data-delay="300">
                                    <?php echo $address ?>
                                </p>
                                <div class="row row-spaced">
                                    <?php if ($address): ?>
                                        <div data-delay="350" class="col-4 one-loc-bottom">
                                            <p class="ol-stat-header">
                                                <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($address) ?>&hl=pl">Get Directions</a>
                                            </p>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($operation_hours): ?>
                                        <div data-delay="400" class="col-4 one-loc-bottom">
                                            <p class="ol-stat-header">
                                                OPERATION HOURS 
                                            </p>
                                            <p>
                                                <?php echo nl2br($operation_hours); ?>
                                            </p>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($phone): ?>
                                        <div data-delay="450" class="col-4 one-loc-bottom">
                                            <p class="ol-stat-header">
                                                PHONE
                                            </p>
                                            <a href="tel:<?php echo $phone ?>">
                                                <?php echo $phone ?>
                                            </a>
                                        </div>
                                    <?php endif ?>
                                </div>
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