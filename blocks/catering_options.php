<?php

global $section;

        $content = $section['content']; //repeater
            foreach($content as $key=>$single_content)
    {
            $title = $single_content['title'];//text
                $content = $single_content['content'];//wysiwyg
        }
