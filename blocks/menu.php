<?php

global $section;

        $menu = $section['menu']; //repeater
            foreach($menu as $key=>$single_menu)
    {
            $category_name = $single_menu['category_name'];//text
                $description = $single_menu['description'];//textarea
                $products = $single_menu['products'];//relationship
        }
