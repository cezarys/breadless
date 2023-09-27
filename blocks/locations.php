<?php
global $section;

$title = $section['title']; //textarea
$locations = $section['locations']; //repeater



if (!empty($locations)) {
    ?>
    <div id="locations">
        <div class="container-fluid">
            <div id="locations-top">
                <h1>
                    <?php echo nl2br($title); ?>
                </h1>

            </div>
            <div class="row row-spaced">
                <?php
                foreach ($locations as $key => $single_locations) {
                    $position_on_the_map = $single_locations['position_on_the_map']; //google_map
                    $name = $single_locations['name']; //text
                    $address = $single_locations['address']; //text
                    $operation_hours = $single_locations['operation_hours']; //textarea
                    $phone = $single_locations['phone']; //text
                    ?>
                    <div class="col-sm-6">
                        <div class="one-location">
                            <div class="the-map" data-lat="<?php echo $position_on_the_map['lat'] ?>" darta-lng="<?php echo $position_on_the_map['lng'] ?>"></div>
                            <h3>
                                <?php echo $name ?>
                            </h3>
                            <p>
                                <?php echo $address ?>
                            </p>
                            <div class="row row-spaced">
                                <?php if ($address): ?>
                                    <div class="col-4">
                                        <p class="ol-stat-header">
                                            <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($address) ?>&hl=pl">Get Directions</a>
                                        </p>
                                    </div>
                                <?php endif ?>
                                <?php if ($operation_hours): ?>
                                    <div class="col-4">
                                        <p class="ol-stat-header">
                                            OPERATION HOURS 
                                        </p>
                                        <p>
                                            <?php echo nl2br($operation_hours); ?>
                                        </p>
                                    </div>
                                <?php endif ?>
                                <?php if ($phone): ?>
                                    <div class="col-4">
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
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}