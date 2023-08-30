<?php
if (isset($_POST["ra"]) && ($_POST["ra"] != "")) {
    include("database.php");

    $ra = $_POST["ra"];

    $stmt = $pdo->prepare("select * from alunos where ra = :ra");
    $stmt->bindParam(':ra', $ra);

    $stmt->execute();
    $row = $stmt->fetch();

    $nome = $row['nome'];
    $curso = $row['curso'];
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        die();
    }

    $ra = "";
    $nome = "";
    $curso = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar aluno</title>
</head>

<body>
    <h2>Editar aluno</h2>
    <form method="post" action="atualizar.php">
        <input type="hidden" name="ra_old" value="<?= $ra ?>">

        <label for="ra">RA</label>
        <input type="text" name="ra" value="<?= $ra ?>">

        <label for="nome">Nome</label>
        <input type="text" size="50" name="nome" value="<?= $nome ?>">


        <label for="curso">Curso</label>
        <select name="" id="" value="<?= $curso ?>">
            <option disabled hidden></option>
            <option value="Edificações" <?= $curso === "Edificações" ? "selected" : "" ?>>Edificações</option>
            <option value="Enfermagem" <?= $curso === "Enfermagem" ? "selected" : "" ?>>Enfermagem</option>
            <option value="GeoCart" <?= $curso === "GeoCart" ? "selected" : "" ?>>Geodésia e Cartografia</option>
            <option value="Informática" <?= $curso === "Informática" ? "selected" : "" ?>>Informática</option>
            <option value="Mecânica" <?= $curso === "Mecânica" ? "selected" : "" ?>>Mecânica</option>
            <option value="Qualidade" <?= $curso === "Qualidade" ? "selected" : "" ?>>Qualidade</option>
        </select>

        <input type="submit" value="atualizar">
    </form>
</body>

<style>
    form {
        display: flex;
        flex-direction: column;
        width: 300px;
    }

    label {
        width: 100px;
    }

    label:not(:first-child) {
        margin-top: 10px;
    }

    [type="submit"] {
        margin-top: 10px;
        align-self: flex-end;
    }
</style>

</html>