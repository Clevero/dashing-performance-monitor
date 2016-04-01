<?php
require_once 'BaseController.php';
class NetworkUsageController extends BaseController{
	
	private $interface = "wlp1s0";
	private $out;
	private $in;
	
	public function __construct(){
		parent::__construct();
		$this->type = "network";
	}//end __construct()
	
	public function crawlStats(){
		
		if($this->lastUpdate == NULL || time() - ($this->lastUpdate)>5){
		
			$rx[] = shell_exec("cat /sys/class/net/$this->interface/statistics/rx_bytes");
			$tx[] = shell_exec("cat /sys/class/net/$this->interface/statistics/tx_bytes");
			sleep(1);
			$rx[] = shell_exec("cat /sys/class/net/$this->interface/statistics/rx_bytes");
			$tx[] = shell_exec("cat /sys/class/net/$this->interface/statistics/tx_bytes");
			
			$this->out = $tx[1] - $tx[0];
			$this->in = $rx[1] - $rx[0];
			
// 			$this->value = ($tbps+$rbps)*8;
			
			if($this->out > 1048576){
				$this->out /= 1024;
				$this->out /= 1024;
				$this->out = $this->roundValue($this->out);
				$this->out .= "Mb/s";
			}else if($this->out > 1024){
				$this->out /= 1024;
				$this->out = $this->roundValue($this->out);
				$this->out .= "Kb/s";
			}else{
				$this->out = "<1Kb/s";
			}

			if($this->in > 1048576){
				$this->in /= 1024;
				$this->in /= 1024;
				$this->in = $this->roundValue($this->in);
				$this->in .= "Mb/s";
			}else if($this->in > 1024){
				$this->in /= 1024;
				$this->in = $this->roundValue($this->in);
				$this->in .= "Kb/s";
			}else{
				$this->in = "<1Kb/s";
			}
			
			$this->lastUpdate = time();
			return;
		}//end if()
		$this->value = NULL;
	}//end crawlStats()
	
	public function getValue(){
		return "⬆" . $this->out . "\n⬇" . $this->in;
	}//end getValue()
	
	private function roundValue($value){
		$value *= 100;
		$value = (int)$value;
		$value /= 100;
		return $value;
	}//end roundValue()
	
	protected function parseValues(){
		
	}//end parseValues()
	
}//end class

?>