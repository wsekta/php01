<?php

function resetTab($SX,$SY)
{
    unset($_GET['x']);
    unset($_GET['y']);
    for ($i = 0; $i < $SY; $i++)
        for ($j = 0; $j < $SX; $j++)
            $_SESSION[$j . "," . $i] = 0;
}

function plotLineLow($x0, $y0, $x1, $y1)
{
    $dx = $x1 - $x0;
    $dy = $y1 - $y0;
    $yi = 1;
    if ($dy < 0) {
        $yi = -1;
        $dy = -$dy;
    }
    $D = 2 * $dy - $dx;
    $y = $y0;

    for ($x = $x0; $x <= $x1; $x+=1) {
        $_SESSION[$x . "," . $y] = 1;
        if ($D > 0) {
            $y = $y + $yi;
            $D = $D - 2 * $dx;
        }
        $D = $D + 2 * $dy;
    }

}

function plotLineHigh($x0, $y0, $x1, $y1)
{
    $dx = $x1 - $x0;
    $dy = $y1 - $y0;
    $xi = 1;
    if ($dx < 0) {
        $xi = -1;
        $dx = -$dx;
    }
    $D = 2 * $dx - $dy;
    $x = $x0;

    for ($y = $y0; $y <= $y1; $y+=1) {
        $_SESSION[$x . "," . $y] = 1;
        if ($D > 0) {
            $x = $x + $xi;
            $D = $D - 2 * $dy;
        }
        $D = $D + 2 * $dx;
    }
}

function plotLine($x0, $y0, $x1, $y1)
{
    if (abs($y1 - $y0) < abs($x1 - $x0)) {
        if ($x0 > $x1)
            plotLineLow($x1, $y1, $x0, $y0);
        else
            plotLineLow($x0, $y0, $x1, $y1);
    } else {
        if ($y0 > $y1)
            plotLineHigh($x1, $y1, $x0, $y0);
        else
            plotLineHigh($x0, $y0, $x1, $y1);
    }
}

?>