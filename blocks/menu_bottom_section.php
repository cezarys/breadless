<?php
global $section;

$background = $section['background']; //image

$content = $section['content']; //wysiwyg

$title_below = $section['title_below']; //text

$button_label = $section['button_label']; //text

$button_url = $section['button_url']; //text
?>
<div id="menu-bottom-section">
    <div class="container-fluid">
        <div id="mb-with-bg">
            <?php echo $content ?>
        </div>
        <?php if ($background): ?>
            <style>
                #mb-with-bg
                {
                    background: url('<?php echo $background['url'] ?>') center;
                    background-size: cover;
                }
            </style>
        <?php endif ?>
        <div id="mb-bottom">
            <?php if ($title_below): ?>
                <h2>
                    <?php echo $title_below ?>
                </h2>
            <?php endif ?>
            <?php
            buttonWithWrapper($button_label, $button_url);
            ?>
        </div>
    </div>
</div>