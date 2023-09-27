<?php
global $section;
$html_item_id = $section['html_item_id'];
$html_item_class = $section['html_item_class'];
?>
<div class="wysiwyg-section <?php echo $html_item_class ?>" <?php if(trim($html_item_id)):?>id="<?php echo $html_item_id ?>"<?php endif ?>>
    <div class="container-fluid">
       <?php echo $section['content']; ?>
    </div>
</div>

