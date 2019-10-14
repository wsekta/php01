<?php
error_reporting(-1);
ini_set("display_errors", "On");
session_start();
include_once("funkcje.php");

$color = !empty($_COOKIE["color"]) ? $_COOKIE["color"] : "gray";
$flaga = $_SESSION["f"] ?? 0;
$SX = !empty($_POST["X"]) ? $_POST["X"] : $_SESSION["SX"] ?? 10;
$SY = !empty($_POST["Y"]) ? $_POST["Y"] : $_SESSION["SY"] ?? 10;
$color = $_POST["colors"] ?? $_COOKIE["color"] ?? $color;

if(isset($_POST["ok"]))
{
    $flaga = 0;
    resetTab($SX,$SY);
}

for ($i = 0; $i < $SY; $i++)
    for ($j = 0; $j < $SX; $j++)
        $_SESSION[$j . "," . $i] = $_SESSION[$j . "," . $i] ?? 0;

$_SESSION["SX"] = $SX;
$_SESSION["SY"] = $SY;
setcookie("color", $color, time() + (86400 * 30));

if (isset($_GET["x"]) && isset($_GET["y"])) {
    if (!$flaga) {
        $flaga = 1;
        $_SESSION["X1"] = $_GET["x"];
        $_SESSION["Y1"] = $_GET["y"];
    } else {
        $flaga = 0;
        $X1 = $_SESSION["X1"];
        $Y1 = $_SESSION["Y1"];
        $X2 = $_GET["x"];
        $Y2 = $_GET["y"];
        plotLine($X1, $Y1, $X2, $Y2);
        unset($_GET['x']);
        unset($_GET['y']);
    }
}

for ($i = 0; $i < $SY; $i++) {
    echo "<div>";
    for ($j = 0; $j < $SX; $j++) {
        if (!$_SESSION[$j . "," . $i])
            echo "<a class=\"block " . $color . "\" href=\"./?x=" . $j . "&y=" . $i . "\"></a>";
        else
            echo "<a class=\"block lg\" href=\"./?x=" . $j . "&y=" . $i . "\"></a>";
    }
    echo "</div>";
}

$_SESSION["f"] = $flaga;
?>


<html>
<head>
    <title>Superglobals</title>

    <style type="text/css">
        .block {
            display: inline-block;
            width: 30px;
            height: 30px;
            padding: 0px;
            margin: 0px;
        }

        .block:hover {
            background-color: lightgray;
        }

        .lg {
            background-color: lightgray;
        }

        .red {
            background-color: red;
        }

        .blue {
            background-color: blue;
        }

        .green {
            background-color: green;
        }

        .gray {
            background-color: gray;
        }

        .white {
            background-color: white;
        }
    </style>
</head>
<body>
<form method="post">
    <b>Szerokość </b><input type="number" name="X" value=null><br/>
    <b>Wysokość </b><input type="number" name="Y" value=null><br/>
    <b>Kolor </b><select name="colors">
        <option <?php if ($color == 'gray') echo 'selected'; ?> value="gray">gray</option>
        <option <?php if ($color == 'red') echo 'selected'; ?> value="red">red</option>
        <option <?php if ($color == 'green') echo 'selected'; ?> value="green">green</option>
        <option <?php if ($color == 'blue') echo 'selected'; ?> value="blue">blue</option>
        <option <?php if ($color == 'white') echo 'selected'; ?> value="white">white</option>
    </select><br/>
    <input type="submit" name="ok">
</form>
</body>
</html>
