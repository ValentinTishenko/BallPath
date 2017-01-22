<?php
/**
 * Created by PhpStorm.
 * User: Валентин
 * Date: 18.01.2017
 * Time: 18:33
 */
include 'inc/function.php';
?>
<html>
    <head>
        <title>Ball Path</title>
    </head>
    <body>
        <?php
            $data = rFile();
            $matrix=$data['matrix'];


            $start=explode(',',$data['start']);
            $start[1]=preg_replace("#[^\d]#", "", $start[1]);
            $start[0]=preg_replace("#[^\d]#", "", $start[0]);
            echo 'Start-'.$start[0].','.$start[1];
            echo '<br>';

            $finish=explode(',',$data['finish']);
            $finish[1]=preg_replace("#[^\d]#", "", $finish[1]);
            $finish[0]=preg_replace("#[^\d]#", "", $finish[0]);
            echo 'Finish-'.$finish[0].','.$finish[1];
            echo '<br>';

            $matrix[$start[0]][$start[1]]='S';
            $matrix[$finish[0]][$finish[1]]='F';


        for ($i = 1; $i < $data['line'] + 1; $i++) {
            for ($j = 1; $j < $data['column'] + 1; $j++) {
                if ($matrix[$i][$j] == 1) {
                    $matrix[$i][$j] = 'O';

                }


            }
        }
        echo 'Начальная матрица<br>';
        printMatrix($data,$matrix);
        $buf=search($start,$finish,$matrix,$data);
        $matrix=swap($buf,$matrix);
            echo '<br><br>Матрица в которой кратчайший путь обозначен символами ‘U’, ‘D’, ‘L’, ‘R’ и шары обозначены символом ‘O’, последняя клетка пути обозначена символом F.<br>';
        
        printMatrix($data,$matrix);
        ?>

    </body>
</html>
