<?php
function rFile()
{

    $file = fopen('config.txt', 'r') or die("не удалось открыть файл");
    $config['line'] = htmlentities(fgets($file));
    $config['column'] = htmlentities(fgets($file));
    $config['start'] = htmlentities(fgets($file));
    $config['finish'] = htmlentities(fgets($file));

    for ($i = 1; $i < $config['line'] + 1; $i++) {
        for ($j = 1; $j < $config['column'] + 1; $j++) {
            $config['matrix'][$i][$j] = htmlentities(fread($file, 1));
        }

    }
    fclose($file);
    return $config;
}

function search($start, $finish, $matrix, $data)
{
    $fifo[0] = $start[0];
    $fifo[1] = $start[1];
    $fifo['value'] = 0;
    $pointer[0] = array_shift($fifo);
    $pointer[1] = array_shift($fifo);
    $pointer['value'] = array_shift($fifo);

    $status = '';
   // echo 'pointer=' . $pointer[0] . ',' . $pointer[1] . ' value= ' . $pointer['value'];
    echo '<hr>';
    while (1) {
        if ($pointer[0] - 1 != 0) {
            if ($matrix[$pointer[0] - 1][$pointer[1]] != 'F') {
                if ($matrix[$pointer[0] - 1][$pointer[1]] != 'O' && $matrix[$pointer[0] - 1][$pointer[1]] != 'S' && $matrix[$pointer[0] - 1][$pointer[1]] == 0) {
                    $matrix[$pointer[0] - 1][$pointer[1]] = $pointer['value'] + 1;
                    $point[0] = $pointer[0] - 1;
                    $point[1] = $pointer[1];
                    $point['value'] = $matrix[$pointer[0] - 1][$pointer[1]];
                    $fifo[] = $point;
                }
            } elseif ($matrix[$pointer[0] - 1][$pointer[1]] == 'F') {
               // echo 'Finish';
                $value[0]=$pointer[0];
                $value[1]=$pointer[1];
              -  $value['val']='U';
                $buf[]=$value;
                break;
            }
        }
        if ($pointer[0] + 1 != $data['line']) {
            if ($matrix[$pointer[0] + 1][$pointer[1]] != 'F') {
                if ($matrix[$pointer[0] + 1][$pointer[1]] != 'O' && $matrix[$pointer[0] + 1][$pointer[1]] != 'S' && $matrix[$pointer[0] + 1][$pointer[1]] == 0) {
                    $matrix[$pointer[0] + 1][$pointer[1]] = $pointer['value'] + 1;
                    $point[0] = $pointer[0] + 1;
                    $point[1] = $pointer[1];
                    $point['value'] = $matrix[$pointer[0] + 1][$pointer[1]];
                    $fifo[] = $point;
                }
            } elseif ($matrix[$pointer[0] + 1][$pointer[1]] == 'F') {
                //echo 'Finish';
                $value[0]=$pointer[0];
                $value[1]=$pointer[1];
                $value['val']='D';
                $buf[]=$value;
                break;
            }
        }




        if ($pointer[1] - 1 != 0) {
            if ($matrix[$pointer[0]][$pointer[1] - 1] != 'F') {
                if ($matrix[$pointer[0]][$pointer[1] - 1] != 'O' && $matrix[$pointer[0]][$pointer[1] - 1] != 'S' && $matrix[$pointer[0]][$pointer[1] - 1] == 0) {
                    $matrix[$pointer[0]][$pointer[1] - 1] = $pointer['value'] + 1;
                    $point[0] = $pointer[0];
                    $point[1] = $pointer[1] - 1;
                    $point['value'] = $matrix[$pointer[0]][$pointer[1] - 1];
                    $fifo[] = $point;
                }
            } elseif ($matrix[$pointer[0]][$pointer[1] - 1] == 'F') {
                //echo 'finish';
                $value[0]=$pointer[0];
                $value[1]=$pointer[1];
                $value['val']='L';
                $buf[]=$value;
                break;}
        }
        if ($pointer[1] + 1 != $data['line']) {
            if ($matrix[$pointer[0]][$pointer[1] + 1] != 'F') {
                if ($matrix[$pointer[0]][$pointer[1] + 1] != 'O' && $matrix[$pointer[0]][$pointer[1] + 1] != 'S' && $matrix[$pointer[0]][$pointer[1] + 1] == 0) {
                    $matrix[$pointer[0]][$pointer[1] + 1] = $pointer['value'] + 1;
                    $point[0] = $pointer[0];
                    $point[1] = $pointer[1] + 1;
                    $point['value'] = $matrix[$pointer[0]][$pointer[1] + 1];
                    $fifo[] = $point;
                }
            } elseif ($matrix[$pointer[0]][$pointer[1] + 1] == 'F') {
               // echo 'finish';
                $value[0]=$pointer[0];
                $value[1]=$pointer[1];
                $value['val']='R';
                $buf[]=$value;
                break;
            }
        }
        $pointer = array_shift($fifo);
        //printMatrix($data, $matrix);
    }
    //echo '<br>';
   // printMatrix($data, $matrix);
    //echo '<br>';

    //echo buf[0][0].' '.buf[0][1].' ';
    //echo $pointer[0] . ',' . $pointer[1].','.$buf[0]['val'];
    for ($i = 1; $i < 100; $i++) {
        if ($pointer[0] - 1 != 0 && $matrix[$pointer[0] - 1][$pointer[1]] + 1 == $matrix[$pointer[0]][$pointer[1]]) {
          //  echo '<BR>' . $matrix[$pointer[0] - 1][$pointer[1]];
            $pointer[0]=$pointer[0] - 1;
            $pointer[1]=$pointer[1];

            $val[0]=$pointer[0];
            $val[1]=$pointer[1];
            $val['val']='D';
            array_unshift($buf,$val);

            //echo ' '.$pointer[0].','.$pointer[1].' ';

            //echo 'D';

        }

        if ($pointer[0] + 1 != $data['line'] && $matrix[$pointer[0] + 1][$pointer[1]] + 1 == $matrix[$pointer[0]][$pointer[1]]) {
            //echo '<BR>' . $matrix[$pointer[0] + 1][$pointer[1]];
            $pointer[0]=$pointer[0] + 1;
            $pointer[1]=$pointer[1];

            $val[0]=$pointer[0];
            $val[1]=$pointer[1];
            $val['val']='U';
            array_unshift($buf,$val);
            //echo ' '.$pointer[0].','.$pointer[1].' ';
            //echo 'U';

        }
        if ($pointer[1] - 1 != 0 && $matrix[$pointer[0]][$pointer[1] - 1] + 1 == $matrix[$pointer[0]][$pointer[1]]) {
           // echo '<br>' . $matrix[$pointer[0]][$pointer[1] - 1];
            $pointer[0]=$pointer[0];
            $pointer[1]=$pointer[1]-1;
            $val[0]=$pointer[0];
            $val[1]=$pointer[1];
            $val['val']='R';
            array_unshift($buf,$val);
           // echo ' '.$pointer[0].','.$pointer[1].' ';
            //echo 'R';


        }
        if ($pointer[1] + 1 != $data['line'] && $matrix[$pointer[0]][$pointer[1] + 1] + 1 == $matrix[$pointer[0]][$pointer[1]]) {
           // echo '<BR>' . $matrix[$pointer[0]][$pointer[1] + 1];
            $pointer[0]=$pointer[0];
            $pointer[1]=$pointer[1]+1;
            $val[0]=$pointer[0];
            $val[1]=$pointer[1];
            $val['val']='L';
            array_unshift($buf,$val);
           // echo ' '.$pointer[0].','.$pointer[1].' ';
            //echo'L';
        }
    }
    //echo '<br>';
    //printMatrix($data, $matrix);
    echo '<br>';
    echo '<pre>';
   // print_r($buf);
    return $buf;
}

function printMatrix($data, $matrix)
{

    for ($i = 1; $i < $data['line'] + 1; $i++) {
        for ($j = 1; $j < $data['column'] + 1; $j++) {
            echo '|' . $matrix[$i][$j] . '|';


        }
        echo '</br>';


    }
}
function swap($buf,$matrix){
    $$matrix;
    $q=0;
    foreach ($buf as $v) {
        echo $v['val'].'=>';
        $matrix[$v[0]][$v[1]]=$v['val'];
        $q++;
    }
    echo 'F -кратчайший путь в виде последовательности шагов.';
    echo '<br><br>'.$q.'-количество шагов в кратчайшем пути.';
    return $matrix;
    
}
