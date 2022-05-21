<?php

include_once "app/controller/AuthController.php";
include_once "app/Config.php";

$auth = new AuthController();
$auth->signUp();