<?php

function redirect(String $url){
    header("Location: $url");
    exit;
}