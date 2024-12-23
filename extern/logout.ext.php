<?php
    

    session_start();
    session_unset();// session libre
    session_destroy();

    header("Location: ../home.php");
    exit();