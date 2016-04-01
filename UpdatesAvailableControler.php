<?php
require_once 'BaseController.php';
class UpdatesAvailableController extends BaseController{
	
	public function __construct(){
		$this->type = "updates-available";
	}//end __construct()
	
	public function crawlStats(){
																		//24h in seconds
		if($this->lastUpdate == NULL || (time() - $this->lastUpdate) > 3600){
			$this->stats = shell_exec("apt list --upgradable | wc");
			$this->parseValues();
			$this->lastUpdate = time();
			return;
		}//end if()
		$this->value = NULL;
	}//end crawlStats()
	
	protected function parseValues(){
		
		preg_match("([0-9]+)", $this->stats, $value);
		
		$this->value = ($value[0]-1);
		
	}//end parseValues()
	
}//end class

?>