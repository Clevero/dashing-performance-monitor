<?php
require_once 'BaseController.php';
class UptimeController extends BaseController{
	
	public function __construct(){
		parent::__construct();
		$this->type = "uptime";
	}//end __construct()
	
	public function crawlStats(){
		if($this->lastUpdate == NULL || (time() - $this->lastUpdate) > 86400){
			$this->stats = shell_exec("cat /proc/uptime");
			$this->parseValues();
			$this->lastUpdate = time();
			return;
		}//end if()
		$this->value = NULL;
	}//end crawlStats()
	
	protected function parseValues(){
		
		preg_match("([0-9.]+)", $this->stats, $value);

		$this->value = (int)($value[0] / 86400);
		
	}//end parseValues()
	
}//end class

?>