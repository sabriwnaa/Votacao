<?php
session_start();
if ((!isset($_SESSION['id'])) ) {
    header("location: index.php");
}

$db = new mysqli("localhost", "root", "", "votacao");

$id_pessoa = $_SESSION['id'];
if (isset($_GET['id_escolha'])) {
    $id_escolha = $_GET['id_escolha']; 
   
    $sql = "UPDATE pessoa SET id_escolha = $id_escolha WHERE id = $id_pessoa;";
    $db->query($sql);
}

$stmt = $db->prepare("SELECT e.nome, COUNT(p.id_escolha) AS votos
    FROM escolha e
    JOIN pessoa p ON e.id = p.id_escolha
    GROUP BY e.id
    ORDER BY votos DESC");
$stmt->execute();
$resultado = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da votação</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Resultado da Votação</h1>;
        </div>
    
        <div class='main'>
            <div class='votacao'>
                
                <div class='resultadoVotacao'>
                    <div class='vencedor'>
                            <?php 
                            
                                    while ($row = $resultado->fetch_assoc()) {
                                        $vencedor = null;
                                        if ($vencedor === null || $row['votos'] > $vencedor['votos']) {
                                        $vencedor = $row;
                                        }
                                        
                                    }
                                    
                                    echo "<h1>Vencedor(a): {$vencedor['nome']}</h1>";

                            
                            
                            
                            ?>
                    </div>
                    <div class='todosVotos'>
                        <?php

                        while ($row = $resultado->fetch_assoc()) {
                        echo "<p>{$row['nome']}: {$row['votos']} votos</p>";

                        }

                        ?>
                                    
                    </div>

                </div>
                
                
                <div class='seuVoto'>

                </div>

            </div>
            
            
        </div>

        <div class='footer'>
            <a class='botao' href='logout.php'>Sair</a>
        </div>
    
    


<?php

// Consulta para pegar o id_escolha do usuário
$stmt = $db->prepare("SELECT id_escolha FROM pessoa WHERE id = ?");
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$resultado = $stmt->get_result();
$pessoa = $resultado->fetch_assoc();

$id_escolha = $pessoa['id_escolha'];
    
    $stmt2 = $db->prepare("SELECT nome FROM escolha WHERE id = ?");
    $stmt2->bind_param("i", $id_escolha);
    $stmt2->execute();
    $resultado_escolha = $stmt2->get_result();
    $escolha = $resultado_escolha->fetch_assoc();

    echo "Você votou em: " . $escolha['nome'];

?>


    </div>


    
</body>
</html>

