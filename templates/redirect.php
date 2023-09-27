<?php

/* 
 * Template Name: Redirect To Child
 */

$page_id = get_the_ID();
$children = get_posts([
    'post_type'=>'page',
    'post_parent'=>$page_id
]);

if(!empty($children))
{
    header('Location: '.get_permalink($children[0]->ID));
    die();
}
header('Location: '.get_home_url());
die();