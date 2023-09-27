<?php

global $section;

        $tiles = $section['tiles']; //repeater
            foreach($tiles as $key=>$single_tiles)
    {
            $picture = $single_tiles['picture'];//image
                $content = $single_tiles['content'];//wysiwyg
                $button_label = $single_tiles['button_label'];//text
                $button_url = $single_tiles['button_url'];//text
        }
