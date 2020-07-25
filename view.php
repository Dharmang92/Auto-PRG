<!DOCTYPE html>
<html>

<head>
    <title>Dharmang Gajjar</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

if (isset($_POST["logout"])) {
    header('Location: index.php');
    return;
}
?>

<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo htmlentities($_SESSION["name"]) ?> </h1>

        <?php
        require_once "pdo.php";

        if (isset($_SESSION["success"])) {
            echo ('<p style="color: green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
            unset($_SESSION["success"]);
        }

        echo "<h2>Automobiles</h2>";

        $stmt = $pdo->query("select * from autos");

        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data = $row["year"] . " " . $row["make"] . " / " . $row["mileage"];
            echo "<li>" . htmlentities($data) . "</li>";
        }
        echo "</ul>";
        ?>

        <p>
            <a href="add.php">Add New</a> |
            <a href="logout.php">Logout</a>
        </p>
    </div>
</body>

</html>