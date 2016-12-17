<?php include('../Migration/Composition.php');
    //error_reporting(E_ALL);//E_ALL)
    $Connection = new db();
    if (is_numeric($_POST['key'])) {
        $Article = db::get("`content`", get_all_from('content'), "`key` = '". $_POST['key'] ."'",1,1);
        print json_encode($Article[0]);
    } else {
        print mysql_error();
    }
?>