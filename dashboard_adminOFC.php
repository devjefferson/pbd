<?php
session_start();
include 'conexoes/conexaoOFC.php';
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    // Redireciona para o login se não for admin
    header("Location: ../Screens/Login/login.html");
    exit();
} 