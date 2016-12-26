<?php
$host = 'localhost';
$database = 'users';
$user = 'user';
$password = 'qwerty';
// Соединиться с сервером БД
// подключаемся к серверу
$mysqli = new mysqli($host, $user, $password, $database);
//Если был послан POST запрос, то выбираем данные и сохраняем
$query = "SELECT * FROM users";
$table = $mysqli->query($query);
$rows = mysqli_num_rows($table);
$mysqli->close();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Webinse</title>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="helpScripts.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">
    <table id="users" class="table table-hover">
        <tbody>
        <tr>
            <th>First name</th>
            <th>Second name</th>
            <th>Email</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($table) {
            $rows = mysqli_num_rows($table);
            for ($i = 0; $i < $rows; ++$i) {
                $row = mysqli_fetch_array($table);
                echo "<tr>";
                echo "<td class=\"edit firstName {$row['idusers']}\">{$row['firstName']}</td>";
                echo "<td class=\"edit secondName {$row['idusers']}\">{$row['secondName']}</td>";
                echo "<td class=\"edit email {$row['idusers']}\">{$row['email']}</td>";
                echo "<td class=\"del delete {$row['idusers']} \">>>>>>>click<<<<<</td> ";
                echo "</tr>";
            }
        }
        $table->close();
        echo "</tbody>";
        echo "</table>";
        ?>
</div>

<div class="container">
    <input type="button" name="button" class="btn-primary" value="Add person" onClick="addRow()">
</div>

<div class="container" id="addPerson" style="display:none">
    <form action="index.php">
        <label>First name</label><br>
        <input id="firstName" type="text"><br>
        <label>Second name</label><br>
        <input id="secondName" type="text"><br>
        <label>Email</label><br>
        <input id="email" type="text"><br><br>
        <input type="button" class="btn-success" value="Send" onClick="addPerson()">
    </form>
</div>
</body>
</html>