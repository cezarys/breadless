<?php

global $section;
$columns = $section['columns'];
$html_item_id = $section['html_item_id'];
$html_item_class = $section['html_item_class'];


if(!empty($columns)):
?>
<div class="columns-section <?php echo $html_item_class ?>" <?php if($html_item_id):?>id="<?php echo $html_item_id ?>"<?php endif ?>>
    <div class="container-fluid">
        <div class="row row-spaced">
            <?php foreach($columns as $col):?>
            <div class="<?php echo $col['size'] ?>">
                <?php echo $col['content'] ?>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
<?php endif;