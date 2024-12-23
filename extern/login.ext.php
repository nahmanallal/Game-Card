<?php

if (!isset($_POST["login-sumbit"])){
    require 'dbh.ext.php';// base de donner por interagir
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM gamecard WHERE username='".$username."' OR email='".$username."'; ";// verification si le mail ou le nom est dans la base de donner
    $res = mysqli_query($conn, $sql);//appliquer sur mysql 
    if(!$res){
        header("Location: ../ACCOUNT/login.php?error=sqlerror");
        exit();
    }else{
        if($row = mysqli_fetch_assoc($res)){//renvoie un tableau avec ce quon a demander un tab dans un tab
            $pwdCheck = password_verify($password, $row["pwd"]);//$row[pwd] recupere la valeur de pwd dans le tableau demander et le verifier avec pwd si egal
            if($pwdCheck == false){
                header("Location: ../ACCOUNT/login.php?error=wrongpassword");
                exit();
            }else if($pwdCheck == true){
                session_start();// peut reutiliser tout les session
                $_SESSION["userId"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["status"] = $row["status"];
                header("Location: ../MESSAGES/login.msg.php?login=SUCCES");
                exit();

            }
        }else{
            header("Location: ../ACCOUNT/login.php?error=dontexist");
            exit();
        }
    }
    mysqli_close($conn);



}else{
    header("Location: ../ACCOUNT/login.php");
    exit();
}