<?php

global $section;

        $left_content = $section['left_content']; //wysiwyg
                $right_content = $section['right_content']; //wysiwyg
                $title = $section['title']; //text
                $faq = $section['faq']; //repeater
            foreach($faq as $key=>$single_faq)
    {
            $question = $single_faq['question'];//text
                $answer = $single_faq['answer'];//textarea
        }
