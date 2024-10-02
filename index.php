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
        <div class='box'>
            <h1>Votação</h1>
            <form action='login.php' method='post'>
                <label>E-mail:</label>
                <input type='text' name='email' require>
                <label>Senha:</label>
                <input type='password' name='senha' require>
                <div class='grupo_botao'>
                    <input type='submit' name='botao' value='Acessar'>
                </div>
                <a href='form_add_pessoa.php'>Adicionar nova pessoa</a>
                
            </form>
        </div>
    </div>
</body>
</html>