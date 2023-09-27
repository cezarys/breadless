<?php

global $section;

        $title = $section['title']; //text
                $press = $section['press']; //repeater
            foreach($press as $key=>$single_press)
    {
            $magazine_name = $single_press['magazine_name'];//text
                $article_title = $single_press['article_title'];//text
                $url = $single_press['url'];//text
        }
