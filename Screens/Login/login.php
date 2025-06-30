<?php
session_start();
?>


<!DOCTYPE html>
<html lang="pt-br" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="../Geral/global.css">
    <link rel="stylesheet" href="../Geral/header.css">
    <link rel="stylesheet" href="../Homepage/Homepage - CSS/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>
    <script src="./login.js" defer></script>
    <script src="../Geral/header.js" defer></script>

    <title>Portal da alfabetização</title>
</head>
<body>
    <header>
        <div class="container">
            <nav class="nav-menu">
                <a href="../../index.html">
                    <div class="logo">PDA</div>
                </a>

                <div class="size-text">
                    <button class="button-size_text" id="increase-font">A+</button>
                    <button class="button-size_text" id="decrease-font">A-</button>
                </div> <!-- class="size-text" FIM -->
                
                <div><i id="mode-icon" class="fa-solid fa-moon icons"></i></div>
            </nav> <!-- class="nav-menu" FIM -->
        </div> <!-- class="container" FIM -->
    </header>

    <main>
        <div class="container">
            <form action="valid_login.php" name="form" method="POST"id="loginForm">
                <h1>Login</h1>
                <div class="container_input">
                    <label for="loginEmail">Email:</label>
                    <input type="text" name="loginEmail" id="loginEmail" placeholder="Digite seu email" >
                    <span id="emailError"></span>
                </div>
                <div class="container_input">
                    <label for="loginPassword">Senha:</label>
                    <input type="password" name="loginSenha" maxlength="8" id="loginSenha" placeholder="Digite sua senha" >
                </div>
                <div id="errorMessage">
                    <?php
                    if (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']);
                    }
                    ?>
                </div>
                <div class="buttons">
                    <input type="submit" name="login"id="loginBtn">
                    <button type="button" id="clearLogin">Limpar</button>
                </div>
                <div id="log">
                    <p>Ainda não tem uma conta?</p>
                    <a href="../../Screens/CadastroEmpresa/cadastro.html" id="cadastrar_conta">Cadastrar</a>
                </div>
            </form>
        </div>

    </main>
    <footer>
        <h2>Portal da alfabetização</h2>
        
        <ul class="menu_devs">
            <li><a className="click-disappear" href="#move-start">Inicio</a></li>
        </ul>

        <h3>Desenvolvedores</h3>

        <div class="devs">
            <p>Anderson Ferreira</p>
            <p>João Perrut</p>
            <p>Pedro</p>
            <p>Mariana Herbst</p>
            <p>Taiane</p>
        </div>
    
        <p class="direitos_reservados">&copy; 2024 Todos os direitos reservados</p>
    </footer> 

</body>
</html>
