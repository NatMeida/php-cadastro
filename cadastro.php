<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de alunos</title>

    <style>
        #sucess {
            color: green;
            font-weight: bold;
        }

        #error {
            color: red;
            font-weight: bold;
        }

        #warning {
            color: orange;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <a href="index.html">Home</a>
    <hr>

    <h2>Cadastro de Alunos</h2>
    <div>
        <form method="post" enctype="multipart/form-data">

            RA:<br>
            <input type="text" size="10" name="ra"><br><br>

            Nome:<br>
            <input type="text" size="30" name="nome"><br><br>

            Curso:<br>
            <select name="curso">
                <option></option>
                <option value="Edificações">Edificações</option>
                <option value="Enfermagem">Enfermagem</option>
                <option value="GeoCart">Geodésia e Cartografia</option>
                <option value="Informática">Informática</option>
                <option value="Mecânica">Mecânica</option>
                <option value="Qualidade">Qualidade</option>
            </select><br><br>

            Foto:<br>
            <input type="file" name="foto" accept="image/gif, image/png, image/jpg, image/jpeg"><br><br>

            <input type="submit" value="Cadastrar">

            <hr>

        </form>
    </div>

</body>

</html>

<?php
define('UPLOAD_DIR', 'upload/pictures/');
define('MAX_FILE_SIZE', 1024 * 1024 * 2); // 2MiB

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $ra = $_POST["ra"];
        $nome = $_POST["nome"];
        $curso = $_POST["curso"];

        $foto = $_FILES["foto"];
        $fotoName = $foto["name"];
        $fotoType = $foto["type"];
        $fotoSize = $foto["size"];

        if ((trim($ra) == "") || (trim($nome) == "")) {
            echo "<span id= 'warning'>RA e nome são obrigatórios!</span>";
        } else if (trim($fotoName) == "" && !preg_match('/^image\/(jpg|jpeg|png|gif)$/',$tipoFoto)) {
            echo "<span id= 'warning'>Foto inválida!</span>";
        } else if ($fotoSize > MAX_FILE_SIZE) {
            echo "<span id= 'warning'>Foto muito grande!</span>";
        } else {
            $fileInfo = new SplFileInfo($fotoName);
            $fileExtension = $fileInfo->getExtension();
            $finalFileName = UPLOAD_DIR	. $ra . '.' . $fileExtension;

            if (move_uploaded_file($foto["tmp_name"], $finalFileName)) {
                include("database.php");
    
                $stmt = $pdo->prepare("select * from alunos where ra = :ra");
                $stmt->bindParam(':ra', $ra);
                $stmt->execute();
    
                $rows = $stmt->rowCount();
    
    
                if ($rows <= 0) {
                    $stmt = $pdo->prepare("insert into alunos (ra, nome, curso, foto) values (:ra, :nome, :curso, :foto)");
                    $stmt->bindParam(':ra', $ra);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':curso', $curso);
                    $stmt->bindParam(':foto', $finalFileName);
    
                    $stmt->execute();
                    echo "<span id='sucess'>Aluno cadastrado!</span>";
                } else {
                    unlink($finalFileName);
                    echo "<span id='error'>RA já existente!</span>";
                }
            } else {
                echo "<span id='error'>Erro ao salvar a foto!</span>";
            };

        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $pdo = null;
}
