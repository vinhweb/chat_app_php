<?php

include_once "app/controller/UserController.php";
include_once "app/Config.php";

$user = new UserController();
$user->getData();