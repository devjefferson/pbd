<?php
session_start(); //Faz a verificação 
include 'conexoes/conexaoOFC.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Screens/Login/login.php");
    exit();
}

