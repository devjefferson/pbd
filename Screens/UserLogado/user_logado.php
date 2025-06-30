<?php
session_start();
include '../../conexoes/conexaoOFC.php';
// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Screens/Login/login.php");
    exit();
}

// Verifica se o usuário é administrador
$is_admin = $_SESSION['is_admin'] ?? 0;
$name = $_SESSION['nome_empresa'];
// Carrega informações do usuário
//$nome_usuario = htmlspecialchars($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="pt-br" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../Screens/Homepage/Homepage - CSS/style.css">
    <link rel="stylesheet" href="../../Screens/Homepage/Homepage - CSS/header.css">
    <link rel="stylesheet" href="../../Screens/Homepage/Homepage - CSS/main.css">
    <link rel="stylesheet" href="../../Screens/Homepage/Homepage - CSS/footer.css">
    <link rel="stylesheet" href="section_1_one.css">
    <link rel="stylesheet" href="./logged_in_user.css">
    <link rel="stylesheet" href="user.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>

    <script src="../../Screens/Homepage/Homepage - JS/menu.js" defer></script>
    <script src="../../Screens/Homepage/Homepage - JS/cadastro_funcionario.js" defer></script>
    <script src="../../Screens/Homepage/Homepage - JS/cpf_cep.js" defer></script>
    <script src="../Geral/header.js" defer></script>
    <script src="./logged_in_user.js" defer></script>

    <title>Portal da alfabetização</title>
</head>
 <body>
 
 <?php if ($is_admin): ?>
        <!-- Conteúdo para administradores -->
        <h2 id="titulo_admin">Painel de Administração</h2>
        <div class="container_admin">

            <a class="menu_admin" href="./logout.php">
                <div class="leave_admin">
                    <img class="image_leave" src="../../images/login_user/logout.png" alt="logout" />
                    <h6 class="text_leave">Sair da conta</h6>
                </div> <!-- {class="leave" > END} -->
            </a>

            <a class="menu_admin" href="../../Screens/Admin/admin_empresasOFC.php"> 
                <div class="editar_perfil_admin">
                    <i class="fa-solid fa-gear"></i>
                    <h6 class="cf_title">Acessar empresas</h6>
                </div> <!-- {class="nome_empresa" > END} -->
            </a>
        </div>
            
 <?php else: ?>
    <header>
        <div class="container">
            <nav class="nav-menu">
                <div> <a href= "../../Screens/UserLogado/user_logado.php" class="logo">PDA</a></div>

                <div class="size-text">
                    <button class="button-size_text" id="increase-font">A+</button>
                    <button class="button-size_text" id="decrease-font">A-</button>
                </div> <!-- class="size-text" FIM -->
                    
                <div><i id="mode-icon" class="fa-solid fa-moon icons"></i></div>
    

                    <button class="user_logado">
                        <i class="fa-solid fa-user"></i>
                        <?php echo 'Ola, ' . $name; ?> 
                        <div id="logado"></div>
                    </button> <!-- {class="user_logado" > END} -->
                     
                    <div class="menu-logado">
                        <a class="editar-perfil" href="./editarPerfil/editarPerfil.html.php">
                            <i class="fa-solid fa-gear"></i>
                            <div class="cf_text">
                                <h6 class="cf_title">Editar Perfil</h6>
                                <p class="cf_subtitle">Atualize suas credenciais</p>
                            </div> <!-- class="cf_text" > END -->
                        </a> <!-- {class="nome_empresa" > END} -->
                    
                        <a class="cadastrar_funcionario" href="./cadastroFuncionarios/cadastrofuncionarios.php">
                            <i class="fa-solid fa-wrench"></i>
                            <div class="cf_text">
                                <h6 class="cf_title">Cadastro de funcionários</h6>
                                <p class="cf_subtitle">Cadastre seus funcionários no projeto</p>
                            </div> <!-- class="cf_text" > END -->
                        </a> <!-- {class="cadastrar_funcionario cdf" > END} -->
                    
                        <a class="leave" href="./logout.php">
                            <img class="image_leave" src="../../images/login_user/logout.png" alt="logout" />
                            <h6 class="text_leave">Sair da conta</h6>
                        </a> <!-- {class="leave" > END} -->
                    </div> <!-- {class="menu-logado" > END} -->
                    
                    </nav> <!-- {class="nav-menu" > END} -->
                    </div> <!-- {class="container" > END} -->
                    
        </header>

        <main>
            <div class="container">
                <div class="container-title-border-main">
                    <h1 class="title_main" id="move-start">portal da alfabetização</h1>
                    <div class="border-title-main"></div>
                </div> <!-- class="container-title-border-main" END -->
            
                <!-- =======================
                    SECTION_ONE > BEGINNING 
                    ======================= -->
                <section class="section_one">
                    <div class="image_main"></div>
            
                    <div class="box_text_main">
                        <h3 class="box_text_main_title">Aprender é Transformar</h3>
                        <p class="box_text_main_paragraph">Descubra o prazer da leitura e escrita com uma abordagem 
                        simples e prática, criada especialmente para você.</p>
                        <a class="box_text_main_button" id="cdf" href="./cadastroFuncionarios/cadastrofuncionarios.php">Cadastre o seu funcionário</a>
                    </div> <!-- class="box_text_main" END -->
                </section>
                <!-- =================
                    SECTION_ONE > END 
                    ================= -->

        </main>
        <?php endif; ?>
        <footer class="footer">
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


    


