<?php
    if(isset($_POST['botao'])){

        $nome = htmlspecialchars($_POST['nome']);
      
        $db = new mysqli('localhost','root','','votacao'); 
        
        $sql = "INSERT INTO escolha (nome) VALUES ('$nome')";
        
        $db->query($sql);

        header("location: restrita.php");
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pessoa</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>
        <div class='box'>
            <h1>Adicionar escolha</h1>

            <form method='post' action='form_add_escolha.php'>
                <label>Nome:</label>
                <input type='text' name='nome' require>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' value='Adicionar'>
                </div>
                <a href='restrita.php'>Voltar</a>
            </form>
            
        </div>
    </div>
</body>
</html>