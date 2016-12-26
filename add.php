<?php

function create_insert_query($table, $firstField, $secondField, $thirdField, $firstValue, $secondValue, $thirdValue)
{
    $query = "INSERT INTO `" . $table
        . "` (`" . $firstField . "`, `" . $secondField . "`, `" . $thirdField . "`)"
        . " VALUES ('" . $firstValue . "', '" . $secondValue . "', '" . $thirdValue . "')";
    return $query;
}

function create_select_query($table, $firstField, $firstValue, $secondField, $secondValue, $thirdField, $thirdValue)
{
    $query = "SELECT * FROM " . $table
        . " WHERE " . $firstField . "='" . $firstValue
        . "' AND " . $secondField . "='" . $secondValue
        . "' AND " . $thirdField . "='" . $thirdValue . "'";
    return $query;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST = getRealPOST();

    $host = 'localhost';
    $database = 'users';
    $user = 'user';
    $password = 'qwerty';

    $mysqli = new mysqli($host, $user, $password, $database);
    $table = $_POST['table'];
    $firstField = $_POST['firstField'];
    $secondField = $_POST['secondField'];
    $thirdField = $_POST['thirdField'];
    $firstValue = $_POST['firstValue'];
    $secondValue = $_POST['secondValue'];
    $thirdValue = $_POST['thirdValue'];

    $query = create_insert_query($table, $firstField, $secondField, $thirdField, $firstValue, $secondValue, $thirdValue);

    $mysqli->query($query);

    $query = create_select_query($table, $firstField, $firstValue, $secondField, $secondValue, $thirdField, $thirdValue);

    $request = $mysqli->query($query);
    $row = mysqli_fetch_array($request);
    $id = $row['idusers'];
    echo($id);
    $mysqli->close();
    return $id;
}

function getRealPOST()
{
    $pairs = explode("&", file_get_contents("php://input"));
    $vars = array();
    foreach ($pairs as $pair) {
        $nv = explode("=", $pair);
        $name = urldecode($nv[0]);
        $value = urldecode($nv[1]);
        $vars[$name] = $value;
    }
    return $vars;
}

?>
