<?php



if(isset($_POST["signup-submit"])){//isset = si laction a etait fait $post superglobal

    require 'dbh.ext.php';

    $name = $_POST["prenom"];

    $username = $_POST["username"];

    $email = $_POST["email"];

    $password = $_POST["password"];

    $password2 = $_POST["password2"];

   

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){//validation mail et nom

        header("Location: ../ACCOUNT/signup.php?error=invalidusername&email");

        exit();

    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        header("Location: ../ACCOUNT/signup.php?error=invalidemail");

        exit();

    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){

        header("Location: ../ACCOUNT/signup.php?error=invalidusername");

        exit();

    }else if($password!==$password2){

        header("Location: ../ACCOUNT/signup.php?error=PWDdontmatch");

        exit();

    }else {

        $sql = "SELECT username FROM gamecard WHERE username='".$username."';";// verifier si il y a deja cette utilisateur

        $res = mysqli_query($conn,$sql);//mysqli bool $conn qui me permet de faire la coexion avec mysql et 2 parametre 

        if(!$res){

            header("Location: ../ACCOUNT/signup.php?error=sqlerror");

            exit();

        }else{

            $resultCheck = mysqli_num_rows($res);// verifier si il y a deja cette utilisateur avec le nombre de column si plus grand que 0 alors deja pris

            if($resultCheck>0){

                header("Location: ../ACCOUNT/signup.php?error=USERNAMETAKEN");

                exit();

            }else{

                $hashedPwd = password_hash($password,PASSWORD_DEFAULT);//mot de passe pas decteter base de donner

                $sql = "INSERT INTO gamecard(name,username,email,pwd) VALUES('".$name."','".$username."','".$email."','".$hashedPwd."');";// renter les infos de lutilisatur dans notre tableau

                $res = mysqli_query($conn,$sql);

                if(!$res){

                    header("Location: ../ACCOUNT/signup.php?error=sqlerror");

                    exit();

                }else {

                    header("Location: ../MESSAGES/signup.msg.php?signup=SUCCESS");

                    exit();

                }

            }

        }

    }

    mysqli_close($conn);

   

}else {

    header("Location: ../ACCOUNT/signup.php");

    exit();

}