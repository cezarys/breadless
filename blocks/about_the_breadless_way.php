<?php
global $section;

$title = $section['title']; //repeater
$content = $section['content']; //repeater
?>
<div id="the-breadless-way-text">
    <div>The</div>
    <div>Breadless</div>
    <div>Way</div>
</div>
<div id="the-breadless-way">
    <div class="container-fluid">
        <h2>
            <?php echo $title ?>
        </h2>
        <?php if (!empty($content)): ?>
            <div class="row row-spaced">
                <?php
                foreach ($content as $key => $single_content) {
                    $title = $single_content['title']; //text
                    $text = $single_content['text']; //textarea
                    ?>
                    <div class="col-sm-6">
                        <div class="one-b-content">
                            <h2>
                                <?php echo $title ?>
                            </h2>
                            <p>
                                <?php echo $text ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php endif ?>
    </div>
</div>
