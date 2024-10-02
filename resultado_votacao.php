<?php
session_start();
if ((!isset($_SESSION['id'])) || (!isset($_GET['id_escolha']))) {
    header("location: index.php");
}

$db = new mysqli("localhost", "root", "", "votacao");

$id_escolha = $_GET['id_escolha']; 
$id_usuario = $_SESSION['id'];

$sql = "UPDATE pessoa SET id_escolha = $id_escolha WHERE id = $id_usuario;";
$db->query($sql);

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

