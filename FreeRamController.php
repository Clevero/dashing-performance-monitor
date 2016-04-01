<?php
require_once 'BaseController.php';
class FreeRamController extends BaseController{
	
	
	public function __construct(){
		parent::__construct();
		$this->type = "ram";
		$this->view = "Meter";
	}//end __construct()
	
	public function crawlStats(){
		if($this->lastUpdate == NULL || time() - ($this->lastUpdate)>10){
			$this->parseValues();
			$this->lastUpdate = time();
			return;
		}//end if()
			
		$this->value = NULL;
	}//end crawlStats()
	
	protected function parseValues(){
		$stats = shell_exec("cat /proc/meminfo | grep Buffers");
		preg_match("/([0-9]+)/", $stats, $buffer);
		$buffer = $buffer[0];
		
		$stats = shell_exec("cat /proc/meminfo | grep MemFree");
		preg_match("/([0-9]+)/", $stats, $memFree);
		$memFree = $memFree[0];
		
		$stats = shell_exec("cat /proc/meminfo | grep Cached");
		preg_match("/([0-9]+)/", $stats, $cached);
		$cached = $cached[0];
		
		$kb = $memFree + $buffer + $cached;
		
		
		if($kb > 1048576){
			$this->value = ($kb / 1024 / 1024);
			$this->roundValue();
// 			$this->value .= "GB";
		}else if($kb > 1024){
			$this->value = ($kb / 1024);
			$this->roundValue();
// 			$this->value .= "MB";
		}else{
			$this->value = $kb;
			$this->roundValue();
// 			$this->value .= "KB";
		}//end else
		
	}//end parseValues()
	
	private function roundValue(){
		$this->value *= 10;
		$this->value = (int)$this->value;
		$this->value /= 10;
	}//end roundValue()
	
}//end class

?>