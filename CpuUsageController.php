<?php
require_once 'BaseController.php';
class CpuUsageController extends BaseController{
	
	private $previousIdle;
	private $previousTotal;
	
	public function __construct(){
		$this->previousIdle = -1;
		$this->previousTotal = -1;
		parent::__construct();
		$this->type = "cpu";
	}//end __construct()
	
	public function crawlStats(){
		
		
		if($this->lastUpdate == NULL || (time() - $this->lastUpdate) > 4){
		
			$this->value = 0;
			$this->stats = shell_exec("cat /proc/stat");
			$this->parseValues();
			return;
		}//end if()
			$this->value = NULL;
	}//end crawlStats()
	
	protected function parseValues(){
		preg_match("/^cpu \s*([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+)/", $this->stats, $oldCpuValues);
		preg_match("/^cpu \s*([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+)/", $this->stats, $newCpuValues);
		
		
		
		$user = $oldCpuValues[1];
		$nice = $oldCpuValues[2];
		$sys = $oldCpuValues[3];
		$idle = $oldCpuValues[4];
		$ioWait = $oldCpuValues[5];
		$irq = $oldCpuValues[6];
		$softIrq = $oldCpuValues[7];
		$steal = $oldCpuValues[8];
		
		$guest = $newCpuValues[9];
		$guestNice = $newCpuValues[10];
		
		$total = $user + $nice + $sys + $idle + $ioWait + $irq + $softIrq + $steal + $guest + $guestNice;
		
		if($this->previousIdle > -1 || $this->previousTotal > -1){
			$idleDelta = $idle - $this->previousIdle;
			$totalDelta = $total - $this->previousTotal;
			$this->value = 100-(int)(($idleDelta * 100.0)/($totalDelta+0+5));
			$this->value /= 8;
			$this->value = $this->roundValue($this->value);
		}//end if()
		$this->previousIdle = $idle;
		$this->previousTotal = $total;
		
	}//end parseValues()
	
	private function roundValue($value){
		$value *= 100;
		$value = (int)$value;
		$value /= 100;
		return $value;
	}//end roundValue()
	
}//end class

?>