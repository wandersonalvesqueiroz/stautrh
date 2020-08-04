<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/class/connection.php';
require_once __DIR__.'/base/controller/BaseServicesController.php';

global $db;
global $baseController;

$db = new connectBD();
$baseController = new BaseServicesController();
$baseController->init();
