<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: index.php");
}

$db = new mysqli("localhost", "root", "", "votacao");

if (isset($_GET['id_escolha'])) {
    $id_escolha = intval($_GET['id_escolha']); // Sanitiza o valor recebido
    $id_usuario = $_SESSION['id']; // Pega o ID do usuário logado da sessão

    // Atualiza o ID da escolha para o usuário logado na tabela pessoa
    $stmt = $db->prepare("UPDATE pessoa SET id_escolha = ? WHERE id_pessoa = ?");
    $stmt->bind_param("ii", $id_escolha, $id_usuario);
    $stmt->execute();


    $stmt = $db->prepare("SELECT e.nome, COUNT(p.id_escolha) AS votos
    FROM escolha e
    JOIN pessoa p ON e.id = p.id_escolha
    GROUP BY e.id
    ORDER BY votos DESC");
$stmt->execute();
$resultado = $stmt->get_result();

echo "<h1>Resultado da Votação</h1>";

// Se houver resultados
if ($resultado->num_rows > 0) {
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
} else {
echo "<p>Não há votos registrados.</p>";
}

}