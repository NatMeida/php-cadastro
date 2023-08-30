<?php
include("database.php");

if (isset($_POST["ra"]) && ($_POST["ra"] != "")) {
    $ra = $_POST["ra"];
    $stmt = $pdo->prepare("select * from alunos where ra = :ra order by curso, nome");
    $stmt->bindParam(':ra', $ra);
} else {
    $stmt = $pdo->prepare("select * from alunos order by curso, nome");
}

$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.html">Home</a>
    <hr>
    <h2>Consulta de Alunos</h2>
    <form method="post">
        RA:<br>
        <input type="text" size="10" name="ra">
        <input type="submit" value="consultar">
        <hr>
    </form>

    <?php
    try {
        echo "<form method='post'>";
        echo "<table border='1px'>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th>RA</th>";
        echo "<th>Nome</th>";
        echo "<th>Curso</th>";
        echo "<th>Foto</th>";
        echo "</th>";

        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td><input type='radio' name='ra' value='{$row['ra']}'>";
            echo "<td>{$row['ra']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['curso']}</td>";

            if ($row['foto'] != null) {
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['foto']) . "' width='50px' height='50px' ></td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</table>";
        echo "<br>";

        echo "<div>";
        echo "<button type='submit' formaction='excluir.php'>Excluir</button>";
        echo "<button type='submit' formaction='consulta.php'>Consultar</button>";
        echo "<button type='submit' formaction='edicao.php'>Editar</button>";
        echo "</div>";
    } catch (PDOException $e) {
        echo $e;
    }
    ?>

</body>

<style>
    table {
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
    }

    td:nth-child(1) {
        text-align: center;
    }

    form:has(table) {
        max-width: max-content;
    }

    div:has(button[type='submit']) {
        display: flex;
        justify-content: flex-end;
        column-gap: 0.5rem;
    }
</style>

</html>