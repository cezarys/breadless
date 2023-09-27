<?php

global $section;

        $title = $section['title']; //textarea
                $locations = $section['locations']; //repeater
            foreach($locations as $key=>$single_locations)
    {
            $position_on_the_map = $single_locations['position_on_the_map'];//google_map
                $name = $single_locations['name'];//text
                $address = $single_locations['address'];//text
                $operation_hours = $single_locations['operation_hours'];//textarea
                $phone = $single_locations['phone'];//text
        }
