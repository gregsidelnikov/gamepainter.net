<?php



/* ---- not working? ---- */


session_start();

$json = '{';

if (isset($_SESSION['id'])) {
    $k = 0;
    foreach($_SESSION['items'] as $key1 => $value1) {
        if ($k > 0) $json .= ",";
        $json .= '"' . $key1 . '":{';
        $i = 0;
        foreach ($_SESSION['items'][$key1] as $key2 => $value2) {
            if ($i > 0) $json .= ",";
            $json .= '"'.$key2.'":"'.addslashes($value2).'"';
            $i++;
        }
        $json .= '}';
        $k++;
    }
}
else
{
    //echo "EMPTY";
}

$json .= '}';

print $json;




?>