<?php

function redirectIfGuest(){
    if(!isset($_SESSION["user"])){
        header('Location: /login');
        die;
    }
}
function redirectIfLogged(){
    if(isset($_SESSION["user"])){
        header('Location: /home');
        die;
    }
}