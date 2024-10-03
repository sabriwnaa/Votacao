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
        <h1>Crie sua votação</h1>
        <h3>Adicione as opções, vote e visualize o resultado de forma colaborativa</h3>
        <div class='box'>
            
            <form action='login.php' method='post'>
                <label>E-mail:</label>
                <input type='text' name='email' class='entrada' require>
                <label>Senha:</label>
                <input type='password' name='senha' class='entrada' require>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' class='botao' value='Acessar'>
                </div>
                <a href='form_add_pessoa.php'>Ainda não está cadastrado? Cadastre-se</a>
              
            </form>
        </div>
    </div>
</body>
</html>