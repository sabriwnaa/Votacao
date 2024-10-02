<?php
    if(isset($_POST['botao'])){

        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $senha = htmlspecialchars($_POST['senha']);
      
        $db = new mysqli('localhost','root','','votacao'); 
        
        $password_hash = password_hash($_POST['senha'],PASSWORD_BCRYPT);

         $stmt = $db->prepare("insert into pessoa (email,senha) values (?,?)");
        
         $stmt->bind_param("ss",$email,$password_hash);

        $stmt->execute();

        header("location: index.php");
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pessoa</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div class='container'>
        <div class='box'>
            <h1>Cadatrar-se</h1>

            <form method='post' action='form_add_pessoa.php'>
                <label>E-mail:</label>
                <input type='text' name='email' require>
                <label>Senha:</label>
                <input type='password' name='senha' require>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' value='Adicionar'>
                </div>
                <a href='index.php'>Voltar</a>
            </form>
            
        </div>
    </div>
</body>
</html>