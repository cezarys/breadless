<?php

global $section;

        $title = $section['title']; //text

                $logos = $section['logos']; //repeater

            foreach($logos as $key=>$single_logos)

    {

            $logo = $single_logos['logo'];//image
            $max_width = $single_logos['max_width'];//image

        }
