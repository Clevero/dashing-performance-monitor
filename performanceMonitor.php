<?php
session_start();
require_once 'CpuUsageController.php';
require_once 'DiskUsageController.php';
require 'FreeRamController.php';
require_once 'LoadAverageController.php';
require_once 'NetworkUsageController.php';
require_once 'UpdatesAvailableControler.php';
require_once 'UptimeController.php';
$_SESSION['previousIdle'] = -1;	//in object attribute packen
$_SESSION['previousTotal'] = -1;

$cpu = new CpuUsageController();
$disk = new DiskUsageController();
$ram = new FreeRamController();
$load = new LoadAverageController();
$network = new NetworkUsageController();
$updates = new UpdatesAvailableController();
$uptime = new UptimeController();

while(true){
	
	$cpu->crawlStats();
	$disk->crawlStats();
	$ram->crawlStats();
	$load->crawlStats();
	$network->crawlStats();
	$updates->crawlStats();
	$uptime->crawlStats();
	
	//push it to the server	
	BaseController::push($cpu);
	
	BaseController::push($disk);
	
	BaseController::push($load);
	
	BaseController::push($ram);
	
	BaseController::push($network);
	
	BaseController::push($updates);
	
	BaseController::push($uptime);
	
	sleep(1);
	
}




?>