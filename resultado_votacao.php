<?php
session_start();
if ((!isset($_SESSION['id']))) {
    header("location: index.php");
}

$db = new mysqli("localhost", "root", "", "votacao");

$id_pessoa = $_SESSION['id'];
if (isset($_GET['id_escolha'])) {
    $id_escolha = $_GET['id_escolha'];

    $sql = "UPDATE pessoa SET id_escolha = $id_escolha WHERE id = $id_pessoa;";
    $db->query($sql);
}

// Obter resultados da votação
$stmt = $db->prepare("SELECT e.nome, COUNT(p.id_escolha) AS votos
    FROM escolha e
    LEFT JOIN pessoa p ON e.id = p.id_escolha
    GROUP BY e.id
    ORDER BY votos DESC");
$stmt->execute();
$resultado = $stmt->get_result();

// Inicializa o vencedor
$vencedores = [];
$maxVotos = 0;

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
            <h1>Resultado da Votação</h1>
        </div>

        <div class='main'>
            <div class='votacao'>
                
                <div class='resultadoVotacao'>
                    <div class='vencedor'>
                        <?php 
                        // Exibir resultados e determinar vencedores
                        while ($row = $resultado->fetch_assoc()) {
                            if ($row['votos'] > $maxVotos) {
                                $maxVotos = $row['votos'];
                                $vencedores = [$row]; // Reinicia a lista de vencedores
                            } elseif ($row['votos'] === $maxVotos) {
                                $vencedores[] = $row; // Adiciona à lista de vencedores
                            }
                        }
                        
                        if (count($vencedores) === 1) {
                            // Caso haja apenas um vencedor
                            echo "<h1>Vencedor(a): {$vencedores[0]['nome']}</h1>";
                        } else {
                            // Caso haja um empate entre vários vencedores
                            $nomesVencedores = array_column($vencedores, 'nome');
                            $nomesVencedores = implode(", ", $nomesVencedores);
                            echo "<h1>Empate entre: $nomesVencedores com $maxVotos votos</h1>";
                        }
                        
                        ?>
                    </div>
                    <div class='todosVotos'>
                        <?php
                        // Reiniciar o cursor do resultado para listar novamente
                        $resultado->data_seek(0); // Volta para o início do resultado

                        while ($row = $resultado->fetch_assoc()) {
                            echo "<p>{$row['nome']}: {$row['votos']} votos</p>";
                        }
                        ?>
                    </div>
                </div>
                
                <div class='seuVoto'>
                    
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

                    echo "<h2>Você votou em:</h2>";
                    echo "<h1>" . htmlspecialchars($escolha['nome']) . "</h1>";
                    
                    ?>
                </div>
            </div>
        </div>

        <div class='footer'>
            <a class='botao' style='text-decoration: none;' href='logout.php'>Sair</a>
        </div>


    </div>
</body>
</html>
