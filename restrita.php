<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location: index.php");
}

    $db = new mysqli("localhost", "root", "", "votacao");
    
    $stmt = $db->prepare("select * from escolha");
    $stmt->execute();
    $resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votação para liderança da turma 3TI</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div class='container'>
    <h1>Votação para liderança da turma 3TI</h1>
      <?php 
    if($resultado->num_rows==0){
        echo "Não há escolhas disponíveis. Morra sem líder";
    }else{
        $escolha = $resultado->fetch_all(MYSQLI_ASSOC);
  
        foreach($escolha as $e){
            echo "<a href='resultado_votacao?id_escolha={$e['id']}'>{$e['nome']}<a>";
        }
    }

    echo "<a href='form_add_escolha.php'>Adicionar escolha</a>";
    echo "<a href='logout.php'>Sair</a>";

?>
    </div>
</body>
</html>