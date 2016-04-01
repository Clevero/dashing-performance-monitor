<?php

require_once 'BaseController.php';
class LoadAverageController extends BaseController{
	
	public function __construct(){
		parent::__construct();
		$this->type = "load";
	}//end __construct()
	
	public function crawlStats(){
		if($this->lastUpdate == NULL || time() - ($this->lastUpdate)>60){
		
			$this->stats = shell_exec("cat /proc/loadavg");
			
			$this->parseValues();
			$this->lastUpdate= time();
			return;
		}//end if()
		$this->value = NULL;
		
	}//end crawlStats()
	
	protected function parseValues(){
// 		$this->value = substr($this->stats, 0, 4);
		
		$this->value = array();
		$this->value["60"] =  substr($this->stats, 0, 4);
		$this->value["300"] = substr($this->stats, 5, 4);
		$this->value["900"] = substr($this->stats, 10, 4);
		
		
		
		$arrayOfArrays = array();
		
// 		for($i = sizeof($this->value)-1; $i > 0; $i--){
			
// 			$arrayOfArrays[] = array("x" => key($this->value[$i]), "y" => (double)$this->value[$i]);
			
			
// 		}//end for()

// 		$this->value = array_reverse($this->value, true);
		while($a = current($this->value)){
		
			$arrayOfArrays[] = array("x" => key($this->value), "y" => (double)$a);
		
		
			next($this->value);
		}//end while()
		$this->value = $arrayOfArrays;
	}//end parseValues()
	
}//end class

?>