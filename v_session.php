<?php
// Verifica si el usuario está autenticado

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}