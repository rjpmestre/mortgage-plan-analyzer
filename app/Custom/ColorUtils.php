<?php

namespace App\Custom;

class ColorUtils
{
    public static function getColor($index, $alpha = 0.2) {
        $palette = [
            array(33, 150, 243),    //'blue'
            array(244, 67, 54),     //'red'
            array(255, 193, 7),     //'yellow'
            array(76, 175, 80),     //'green'
            array(63, 81, 181),     //'indigo'
            array(103, 58, 183),    //'purple'
            array(233, 30, 99),     //'pink'
            array(255, 152, 0),     //'orange'
            array(0, 150, 136),     //'teal'
            array(0, 188, 212),     //'cyan'
        ];

        $color = $palette[$index];
        return "rgba($color[0], $color[1], $color[2], $alpha)";
    }
}
