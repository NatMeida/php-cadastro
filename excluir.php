<?php
if (isset($_POST["ra"]) && ($_POST["ra"] != "")) {
    include("database.php");

    $ra = $_POST["ra"];

    $stmt = $pdo->prepare("select foto from alunos where ra = :ra");
    $stmt->bindParam(':ra', $ra);
    $stmt->execute();

    $foto = $stmt->rowCount() == 1 ? $stmt->fetch()['foto'] : null;
    
    if ($foto != null && unlink($foto)) {
        $stmt = $pdo->prepare("delete from alunos where ra = :ra");
        $stmt->bindParam(':ra', $ra);
        
        $stmt->execute();

        $msg = $stmt->rowCount() >= 1 ? "Registro excluído com sucesso!" : "Registro não excluído!";
    } else {
        $msg = "Foto não excluída!";
    }

} else {
    $msg = "RA não informado";
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir!</title>
</head>

<body>
    <h2><?= $msg ?></h2>
</body>

</html>