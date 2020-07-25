<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

if (isset($_POST["add"])) {
    if (strlen($_POST["make"]) < 1) {
        $_SESSION["addfail"] = "Make is required";
        header("Location: add.php");
        return;
    } else {
        if (is_numeric($_POST["mileage"]) && is_numeric($_POST["year"])) {

            $stmt = $pdo->prepare("insert into autos(make, year, mileage) values(:mk, :yr, :mi)");
            $stmt->execute(
                array(
                    ":mk" => $_POST["make"],
                    ":yr" => $_POST["year"],
                    ":mi" => $_POST["mileage"],
                )
            );

            $_SESSION["success"] = "Record inserted";
            header("Location: view.php");
            return;
        } else {
            $_SESSION["addfail"] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        }
    }
}

if (isset($_POST["cancel"])) {
    header("Location: view.php");
    return;
}
?>

<html>

<head>
    <title>Dharmang Gajjar</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo htmlentities($_SESSION["name"]) ?> </h1>

        <?php
        if (isset($_SESSION["addfail"])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION["addfail"]) . "</p>\n");
            unset($_SESSION["addfail"]);
        }
        ?>

        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60" /></p>
            <p>Year:
                <input type="text" name="year" /></p>
            <p>Mileage:
                <input type="text" name="mileage" /></p>
            <input type="submit" value="Add" name="add">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>

</html>