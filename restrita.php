<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location: index.php");
}

$id_pessoa = $_SESSION['id'];

    $db = new mysqli("localhost", "root", "", "votacao");

    $stmt = $db->prepare("SELECT id_escolha FROM pessoa WHERE id = ?");
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pessoa = $resultado->fetch_assoc();
    
    // Se já votou (id_escolha não é nulo)
    if ($pessoa['id_escolha'] !== null) {
        header('location: resultado_votacao.php');
    }
    
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Votação</h1>
        </div>

        <div class='main' style='flex-direction:column;'>
            <div class='cabecalhoOpcoes'>
                <h2>Opções</h2>  
                <a class='botao' style='text-decoration:none;' href='form_add_escolha.php'>Adicionar opção</a>

          
            </div>
          <div class='opcoes'>
                            
                <?php 
                if($resultado->num_rows==0){
                    echo "Não há escolhas disponíveis. Morra sem líder";
                }else{
                    $escolha = $resultado->fetch_all(MYSQLI_ASSOC);
            
                    foreach($escolha as $e){
                        echo "<a class='botao' style='text-decoration:none; width: 250px; margin: 20px;'href='resultado_votacao.php?id_escolha={$e['id']}'>{$e['nome']}<a>";
                    }
                }

                ?>

            </div>
        </div>

        <div class='footer'>
            <a class='botao' style='text-decoration: none;' href='logout.php'>Sair</a>
        </div>

    
    </div>
</body>
</html>