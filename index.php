<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votação</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Crie sua votação</h1>
            <h3>Adicione as opções, vote e visualize o resultado de forma colaborativa</h3>
        </div>
        <div class='box'>
            
            <form action='login.php' method='post'>
                <h2 class='comando'>Entre na sua conta</h2>
                <div class='insercao'>
                    <label>E-mail:</label>
                    <input type='text' name='email' class='entrada' require>
                
                </div>
                <div class='insercao'>
                    <label>Senha:</label>
                    <input type='password' name='senha' class='entrada' require>
                </div>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' class='botao' value='Acessar'>
                </div>
                <a href='form_add_pessoa.php'>Ainda não está cadastrado? Cadastre-se</a>
              
            </form>
        </div>

        <div class='footer'>
            <h3>Sabrina Hahn Melo, 3TI - Programação III</h3>
        </div>
    </div>
</body>
</html>