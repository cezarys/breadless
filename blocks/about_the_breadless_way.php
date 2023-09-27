<?php

global $section;

        $content = $section['content']; //repeater
            foreach($content as $key=>$single_content)
    {
            $title = $single_content['title'];//text
                $text = $single_content['text'];//textarea
        }
