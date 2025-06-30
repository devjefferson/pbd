<?php   
// Conexão com o banco
include '../../../dashboard_userOFC.php';


$id_empresa = $_SESSION['user_id'] ?? null;
$name = $_SESSION['nome_empresa'] ?? null;

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$id_empresa) {
        $mensagem = "<div class='feedback-msg error-msg'>Erro: Empresa não identificada.</div>";
    } else {
        if (isset($_POST['adicionar'])) {

            $email = $_POST['email'];
            $rg = $_POST['rg'];
            $cpf = $_POST['cpf'];

            $check_sql = "SELECT * FROM funcionarios WHERE (email = ? OR rg = ? OR cpf = ?) AND id_empresa = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("sssi", $email, $rg, $cpf, $id_empresa);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result->num_rows > 0) {
                $mensagem = "<div class='feedback-msg error-msg'>Erro: Email, RG ou CPF já cadastrados no banco de dados.</div>";
            } else {
                // Insere o funcionário, pois não houve duplicatas
                $sql = "INSERT INTO funcionarios (nome_func, email, data_nasc, numero, complemento, rua, bairro, cidade, 
                    estado, cep, escolaridade, sexo, turno, cpf, rg, id_empresa) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param(
                        "sssssssssssssssi",
                        $_POST['nome_func'],
                        $_POST['email'],
                        $_POST['data_nasc'],
                        $_POST['numero'],
                        $_POST['complemento'],
                        $_POST['rua'],
                        $_POST['bairro'],
                        $_POST['cidade'],
                        $_POST['estado'],
                        $_POST['cep'],
                        $_POST['escolaridade'],
                        $_POST['sexo'],
                        $_POST['turno'],
                        $_POST['cpf'],
                        $_POST['rg'],
                        $id_empresa
                    );

                    if ($stmt->execute()) {
                        $mensagem = "<div class='feedback-msg success-msg'>Novo funcionário adicionado com sucesso!</div>";
                    } else {
                        $mensagem = "<div class='feedback-msg error-msg'>Erro ao adicionar funcionário: " . htmlspecialchars($stmt->error) . "</div>";
                    }

                    $stmt->close();
                } else {
                    $mensagem = "<div class='feedback-msg error-msg'>Erro de preparação na consulta: " . htmlspecialchars($conn->error) . "</div>";
                }
            }
        }
    }
}

if (isset($_POST['editar'])) {
    $id = isset($_POST['id_funcionario']) ? $_POST['id_funcionario'] : null;
    $nome_func = isset($_POST['nome_func']) ? $_POST['nome_func'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $data_nasc = isset($_POST['data_nasc']) ? $_POST['data_nasc'] : null;
    $numero = isset($_POST['numero']) ? $_POST['numero'] : null;
    $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : null;
    $rua = isset($_POST['rua']) ? $_POST['rua'] : null;
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : null;
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    $cep = isset($_POST['cep']) ? $_POST['cep'] : null;
    $escolaridade = isset($_POST['escolaridade']) ? $_POST['escolaridade'] : null;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
    $turno = isset($_POST['turno']) ? $_POST['turno'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $rg = isset($_POST['rg']) ? $_POST['rg'] : null;

    $sql = "UPDATE funcionarios SET nome_func='$nome_func', email='$email', data_nasc='$data_nasc', 
    numero='$numero', complemento='$complemento', rua='$rua', bairro='$bairro', cidade='$cidade', estado='$estado', 
    cep='$cep', escolaridade='$escolaridade', sexo='$sexo', turno='$turno', cpf='$cpf', rg='$rg' WHERE id_funcionario=$id";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div id='feedback' class='feedback-msg success-msg'>Usuário editado com sucesso!</div>";
    } else {
        $mensagem = "<div id='feedback' class='feedback-msg error-msg'>Erro ao editar usuário: " . $conn->error . "</div>";
    }
}

if (isset($_POST['excluir'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM funcionarios WHERE id_funcionario=$id";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div id='feedback' class='feedback-msg success-msg'>Usuário excluído com sucesso!</div>";
    } else {
        $mensagem = "<div id='feedback' class='feedback-msg error-msg'>Erro ao excluir usuário: " . $conn->error . "</div>";
    }
}


$sql = "SELECT id_funcionario, nome_func, email, data_nasc, numero, complemento, rua, bairro, cidade, estado, cep, escolaridade, sexo, turno, cpf, rg 
        FROM funcionarios 
        WHERE id_empresa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionários</title>
    <link rel="stylesheet" href="cadastrofuncionarios.css">
    <link rel="stylesheet" href="../../Geral/header.css">
    <link rel="stylesheet" href="../../Geral/global.css">
    <link rel="stylesheet" href="../logged_in_user.css">
    <link rel="stylesheet" href="../../../Screens/Homepage/Homepage - CSS/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" defer integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>

    <script src="../../Geral/header.js" defer></script>
    <script src="../logged_in_user.js" defer></script>
    <script src="cadastro_funcionario.js" defer></script>
    <script src="cpf_cep_rg.js" defer></script>
</head>
<body>
<header>
    <div class="container">
        <nav class="nav-menu">
            <div> <a href= "../user_logado.php" class="logo">PDA</a></div>

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
                <a class="editar-perfil" href="../editarPerfil/editarPerfil.html.php">
                    <i class="fa-solid fa-gear"></i>
                    <div class="cf_text">
                        <h6 class="cf_title">Editar Perfil</h6>
                        <p class="cf_subtitle">Atualize suas credenciais</p>
                    </div> <!-- class="cf_text" > END -->
                </a> <!-- {class="nome_empresa" > END} -->
            
                <a class="cadastrar_funcionario" href="cadastrofuncionarios.php">
                    <i class="fa-solid fa-wrench"></i>
                    <div class="cf_text">
                        <h6 class="cf_title">Cadastro de funcionários</h6>
                        <p class="cf_subtitle">Cadastre seus funcionários no projeto</p>
                    </div> <!-- class="cf_text" > END -->
                </a> <!-- {class="cadastrar_funcionario cdf" > END} -->
            
                <a class="leave" href="../logout.php">
                    <img class="image_leave" src="../../../images/login_user/logout.png" alt="logout" />
                    <h6 class="text_leave">Sair da conta</h6>
                </a> <!-- {class="leave" > END} -->
            </div> <!-- {class="menu-logado" > END} -->
            
        </nav> <!-- {class="nav-menu" > END} -->
    </div> <!-- {class="container" > END} -->
</header>
<main>
    <div class="container">
            <h2>Cadastre um funcionário</h2>
            <?php
        // Exibe a mensagem de sucesso ou erro
        echo $mensagem;
        ?>

<!-- Área com rolagem para a tabela de funcionários -->
        <div class="tabela-container">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>email</th>
                    <th>Ações</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $row["id_funcionario"] . "</td>
                        <td>" . $row["nome_func"] . "</td>
                        <td>" . date("d/m/Y", strtotime($row['data_nasc'])) . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>
                        <button class='button' onclick=\"editarUsuario(" . $row["id_funcionario"] . ", '" . $row["nome_func"] . "', '" . $row["email"] . "', '" . $row["data_nasc"] . "', '" . $row["cpf"] . "', '" . $row["rg"] . "', '" . $row["sexo"] . "', '" . $row["escolaridade"] . "', '" . $row["turno"] . "', '" . $row["cep"] . "', '" . $row["estado"] . "', '" . $row["cidade"] . "', '" . $row["bairro"] . "', '" . $row["rua"] . "', '" . $row["numero"] . "', '" . $row["complemento"] . "')\">Editar</button>
                        <form method='post' style='display:inline-block'>
                        <input type='hidden' name='id' value='" . $row["id_funcionario"] . "'>
                        <button class='button' type='submit' name='excluir' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?')\">Excluir</button>
                        </form>
                        </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='17'>Nenhum dado encontrado</td></tr>";
                }
                ?>
            </table>
        </div>
        <form action="gerar_excel.php" method="post">
            <button type="submit" class="button">
                <img src="../../../images/user_logado/sim.png" alt="Ícone de Download" style="width:20px; height:20px; vertical-align: middle;">
                Baixar Planilha em Excel
            </button>
        </form>

        <h2>Adicionar ou Editar Usuário</h2>

        <form method="post" class="form-section" id="form">
        <input type="hidden" name="id_funcionario" id="id_funcionario">
     
        <div class="input_group">
            <div class="container_input">
                <input type="text" name="nome_func" id="nome_func" class="input-field" placeholder="Nome" >
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="email" id="email" class="input-field" placeholder="email" >
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="data_nasc" id="data_nasc" class="input-field" placeholder="Data de Nascimento" >
                <span class="spans"></span>
            </div>
        </div>

        <div class="input_group">
            <div class="container_input">
                <select name="sexo" id="sexo">
                    <option value="" selected>Sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outros">Outros</option>
                </select>
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <select name="turno" id="turno">
                    <option value="" selected>Turno</option>
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                </select>
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
            <select name="escolaridade" id="escolaridade">
                    <option value="" selected>Escolaridade</option>
                    <option value="AF">Analfabeto</option>
                    <option value="EFI">Ensino Fundamental incompleto</option>
                    <option value="EMI">Ensino Médio incompleto</option>
                </select>
                <span class="spans"></span>
            </div>
        </div>

        <div class="input_group">
            <div class="container_input">
                <input type="text" name="cpf" id="cpf" class="input-field" placeholder="CPF" >
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="rg" id="rg" class="input-field" placeholder="RG" >
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="cep" id="cep" class="input-field" placeholder="CEP">
                <span class="spans"></span>
            </div>
        </div>

        <div class="input_group">
            <div class="container_input">
                <input type="text" name="rua" id="rua" class="input-field" placeholder="Rua" readonly>
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="bairro" id="bairro" class="input-field" placeholder="Bairro" readonly>
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="cidade" id="cidade" class="input-field" placeholder="Cidade" readonly>
                <span class="spans"></span>
            </div>
        </div>

        <div class="input_group">
            <div class="container_input">
                <input type="text" name="estado" id="estado" class="input-field" placeholder="Estado" readonly>
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="numero" id="numero" class="input-field" placeholder="Número" >
                <span class="spans"></span>
            </div>
            
            <div class="container_input">
                <input type="text" name="complemento" id="complemento" class="input-field" placeholder="Complemento (opicional)">
                <span class="spans"></span>
            </div>
        </div>

            <div class="buttons">
                <button type="submit" name="adicionar" class="button">Adicionar</button>
                <button type="submit" name="editar" class="button">Salvar Edição</button>
                <button type="button" id="clearBtn" class="button">Limpar</button>
            </div>
        
        </form>
    </div>
<!-- Script para remover mensagens -->
    <script>
        setTimeout(function () {
            const feedbacks = document.querySelectorAll('.feedback-msg');
            feedbacks.forEach(feedback => {feedback.style.opacity = '0';
            setTimeout(() => feedback.remove(), 500); // Remove do DOM após a transição
        });
    }, 5000); // 5 segundos
    </script>
    <script>
        function editarUsuario(id, nome_func, email, data_nasc, cpf, rg, sexo, escolaridade, turno, cep, estado, cidade, bairro, rua, numero, complemento) {
            // Preenche os campos com os dados do usuário
            document.getElementById('id_funcionario').value = id;
            document.getElementById('nome_func').value = nome_func;
            document.getElementById('email').value = email;
            document.getElementById('data_nasc').value = data_nasc;
            document.getElementById('cpf').value = cpf;
            document.getElementById('rg').value = rg;
            document.getElementById('sexo').value = sexo;
            document.getElementById('escolaridade').value = escolaridade;
            document.getElementById('turno').value = turno;
            document.getElementById('cep').value = cep;
            document.getElementById('estado').value = estado;
            document.getElementById('cidade').value = cidade;
            document.getElementById('bairro').value = bairro;
            document.getElementById('rua').value = rua;
            document.getElementById('numero').value = numero;
            document.getElementById('complemento').value = complemento;
            
            // Obter a posição da seção de formulário
            const formSection = document.querySelector('.form-section');
            const offset = formSection.offsetTop - 100; // Ajusta a rolagem 
            // Rolagem suave 
            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        }
        
        
    </script>
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

<?php
$conn->close();
?>