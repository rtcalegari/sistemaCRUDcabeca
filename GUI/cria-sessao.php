<?php
    session_start();
    $_SESSION['id'] = $_POST['idusuario'];
    $_SESSION['nome'] = $_POST['nome'];
?>