<?php

global $section;

$menu = $section['menu']; //relationship

$button_label = $section['button_label']; //text

$button_url = $section['button_url']; //text

 if(!empty($menu))       
 {
     ?>
<div id="home-menu">
    <div class="container-fluid">
        <div id="home-menu-slider">
            <?php
            foreach($menu as $one_item)
            {
               oneMenu($one_item);
            }?>
         
        </div>
    </div>
</div>
     <?php
 }