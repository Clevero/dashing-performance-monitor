<?php

require_once 'BaseController.php';
class DiskUsageController extends BaseController{
	
	public function __construct(){
		parent::__construct();
		$this->type = "disk";
	}//end __construct()()
	
	public function crawlStats(){
		
		if($this->lastUpdate == NULL || time() - ($this->lastUpdate) > 600){
		
			$this->stats = shell_exec("df | grep ' /$'");
			
			$this->parseValues();
			$this->lastUpdate = time();
			return;
		}//end crawlStats()
		$this->value = NULL;
	}//end crawlStats()
	
	protected function parseValues(){
		preg_match("([0-9.]+%)", $this->stats, $value);
		$this->value = substr($value[0], 0, strlen($value[0])-1);
	}//end parseValues()
	
}//end class

?>