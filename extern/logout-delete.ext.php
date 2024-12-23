<?php
    

    session_start();
    session_unset();// session libre
    session_destroy();

    header("Location: ../MESSAGES/delete.msg.php");
    exit();