<?php

global $section;

        $title = $section['title']; //text
                $slider = $section['slider']; //repeater
            foreach($slider as $key=>$single_slider)
    {
            $picture = $single_slider['picture'];//image
                $title = $single_slider['title'];//text
                $date = $single_slider['date'];//text
                $text = $single_slider['text'];//text
                $url = $single_slider['url'];//text
        }
