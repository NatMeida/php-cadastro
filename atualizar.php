<?php
try {
    $ra_old = $_POST["ra_old"];
    $ra = $_POST["ra"];
    $nome = $_POST["nome"];
    $curso = $_POST["curso"];

    include("database.php");

    $stmt = $pdo->prepare("update alunos set ra = :ra, nome = :nome, curso = :curso where ra = :ra_old");

    $stmt->bindParam(':ra', $ra);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':curso', $curso);
    $stmt->bindParam(':ra_old', $ra_old);

    $stmt->execute();

    $msg = $stmt->rowCount() >= 1 ? "Registro atualizado com sucesso!" : "Registro não atualizado!";
} catch (PDOException $e) {
    $msg = "Erro: " . $e->getMessage();
} finally {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>

<?= $msg ?>
