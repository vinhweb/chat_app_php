<?php

include_once "app/controller/MessageController.php";
include_once "app/controller/AuthController.php";
include_once "app/Config.php";

$auth = new AuthController();
$auth->checkAuth();

$mess = new MessageController();
$mess->insertChat();