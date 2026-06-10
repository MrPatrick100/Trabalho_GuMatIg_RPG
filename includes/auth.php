<?php

session_start();

if (empty($_SESSION['id_usuario'])) {
    header('Location: ../pages/login.php');
    exit;
}