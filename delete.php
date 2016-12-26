<?php
$host = 'localhost';
$database = 'users';
$user = 'user';
$password = 'qwerty';

$mysqli = new mysqli($host, $user, $password, $database);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = getRealPOST();

    $table = $_POST['table'];
    $id = $_POST['id'];

    $query = "DELETE FROM `".$table."` WHERE idusers = '".$id."'";
    echo ($query);
    $mysqli->query($query);
    echo "Updated success";
    $mysqli->close();
}

function getRealPOST() {
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
