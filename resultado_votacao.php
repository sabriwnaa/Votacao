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

echo "<h1>Resultado da Votação</h1>";

$vencedor = null;
while ($row = $resultado->fetch_assoc()) {
echo "<p>{$row['nome']}: {$row['votos']} votos</p>";

// Determina o vencedor, que é a escolha com mais votos
if ($vencedor === null || $row['votos'] > $vencedor['votos']) {
$vencedor = $row;
}
}

// Exibe quem foi o vencedor
echo "<h2>O vencedor é: {$vencedor['nome']} com {$vencedor['votos']} votos!</h2>";

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

    echo "<a href='logout.php'>Sair</a>";
