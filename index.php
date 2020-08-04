<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'class/connection.php';
require_once 'base/controller/BaseServicesController.php';

$classBaseController = new BaseServicesController();
$classBaseController->init();
