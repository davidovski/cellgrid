<!DOCTYPE html>

<?php
    $GRID_SIZE = 64;

    $grid = json_decode(file_get_contents('array.json'), true);
    if (empty($grid)) {
        for($x = 0; $x < $GRID_SIZE; ++$x) {
            $grid[$x] = array();
            for($y = 0; $y < $GRID_SIZE; ++$y) {
                $grid[$x][$y] = "#ffffff";
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pos = explode(",", $_POST["cell"]);
        $grid[$pos[0]][$pos[1]] = $_POST["color"];

        file_put_contents('array.json',  json_encode($grid));
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>cellgrid</title>

    <style>
        
        @font-face {
            font-family: pixel;
            src: url("font.woff")
        }

        body {
            background: #282a2e;
            color: #c5c8c6;
            font-family: pixel, Courier New, Verdana, Arial;
            font-size: 1em;
            text-align: center;
        }

        .grid {
            overflow: scroll;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        #selector {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);

            height: 0%;

            opacity: 0;
            visibility: hidden;
            float: right;

            transition: height 0.5s;
            overflow: hidden;
            white-space: nowrap;
            padding: 1%;
            background: #373b41;
        }

        #selector:target {
            height: 3em;
            visibility: visible;
            opacity: 1;
        }

        input[type='radio'] {
            opacity: 0;
            height: 100%;
            width: 100%;
            margin: 0;
        }

        input[type='radio']:checked {
            opacity: 1;
        }

        td {
            position: relative;
            width: 10px;
            height: 10px;
        }


        table {
            border: 0.1em solid black;
            font-size: 1px;
            width: 640px;
            height: 640px;
        }

        input[type="color"] {
            width: 20px;
            height: 20px;
        }

        

    </style>

</head>

<body>
    <form class="main" action="/" method="post">

        <div class="grid">
            <table  border="0" cellspacing="0" cellpadding="0">
                <?php 
                   for($x = 0; $x < $GRID_SIZE; ++$x) {
                       echo("<tr>");
                       for($y = 0; $y < $GRID_SIZE; ++$y) {
                           $id = "$x,$y";
                           $color = $grid[$x][$y];
                           echo "<td style='background-color:$color;>";
                           echo "<label for='cell1'>";
                           echo "<a href='#selector'>";
                           echo "<input type='radio' name='cell' id='cell$id' value='$id'>";
                           echo "</a>";
                           echo "</label>";
                           echo "</td>";
                       }
                       echo("</tr>");
                   }
               ?>
            </table>
        </div>
        
        <div id="selector">
            <span>Select Color:</span>
            <br>
            <input type="color" id="color" name="color">
            <input type="submit" value="Submit">
        </div>
    </form>
</body>
</html>
