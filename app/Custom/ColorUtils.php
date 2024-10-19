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
            array(205, 220, 57),    //'lime'
            array(121, 85, 72),     //'brown'
            array(158, 158, 158),   //'grey'
            array(96, 125, 139),    //'blue-grey'
            array(156, 39, 176),    //'deep purple'
            array(255, 87, 34),     //'deep orange'
            array(139, 195, 74),    //'light green'
            array(3, 169, 244),     //'light blue'
            array(0, 121, 107),     //'dark teal'
            array(255, 235, 59),    //'amber'
            array(224, 64, 251),    //'violet'
            array(255, 111, 97),    //'salmon'
            array(192, 202, 51),    //'olive'
            array(255, 160, 122),   //'coral'
            array(123, 31, 162),    //'dark purple'
            array(56, 142, 60),     //'forest green'
            array(179, 157, 219),   //'lavender'
            array(255, 23, 68),     //'crimson'
            array(48, 63, 159),     //'royal blue'
            array(77, 208, 225),    //'sky blue'
            array(239, 108, 0),     //'carrot'
            array(46, 125, 50),     //'pine green'
            array(206, 147, 216),   //'mauve'
            array(41, 182, 246),    //'bright blue'
            array(255, 64, 129),    //'hot pink'
            array(245, 127, 23),    //'pumpkin'
            array(255, 82, 82),     //'tomato'
            array(0, 77, 64),       //'dark forest'
            array(130, 177, 255),   //'light steel blue'
            array(255, 214, 0)      //'gold'

        ];

        $color = $palette[$index%count($palette)];
        return "rgba($color[0], $color[1], $color[2], $alpha)";
    }
}
