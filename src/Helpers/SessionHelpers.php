<?php
function loadSession(array $arr)
{
    foreach ($arr as $key => $value) {
        $_SESSION["messages"][$key] = $value;
    }
}
function sessionVar($key)
{
    return $_SESSION["messages"][$key];
}
function inSession($key){
    if(isset($_SESSION["messages"][$key])){
        return true;
    }
    return false;
}
function clearSessionMessages(){
    unset($_SESSION['messages']);
}
