<?php
session_start();
session_unset();
session_destroy();

// Remove a chave 'userLoggedIn' do localStorage antes de redirecionar
echo '<script>
    localStorage.removeItem("userLoggedIn");
    window.location.href = "../Login/login.php";
</script>';
exit();

