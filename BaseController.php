<?php

abstract class BaseController{
	
	protected $value;
	protected $stats;
	protected $type;
	protected $lastUpdate;
	protected $view;
	
	
	public function __construct(){
		$this->lastUpdate = NULL;
	}//end __construt()
	
	public function getView(){
		return $this->view;
	}//end getView()
	
	public function getValue(){
		return $this->value;
	}//end getValue()
	
	public function getType(){
		return $this->type;
	}//end getType()
	
	public static function push(BaseController $controller){
		
		$TOKEN = "mySecretToken123";
		
		$HOST = "http://192.168.122.1:3030/widgets/" . $controller->getType();
		
		$ch = curl_init($HOST);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		
		if($controller->getValue() != NULL){
			if(is_array($controller->getValue())){
				
				$data = json_encode(array("auth_token" => $TOKEN, "points" => $controller->getValue()));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($data))
				);
				curl_exec($ch);
				return;
			}//end if()
			else if($controller->getView() == "Meter"){
				$data = json_encode(array("auth_token" => $TOKEN, "value" => $controller->getValue()));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($data))
				);
				curl_exec($ch);
				
				return;
			}//ende else if()
			$data = json_encode(array("auth_token" => $TOKEN, "current" => $controller->getValue()));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data))
			);
			curl_exec($ch);
			
		}//end if()
	}//end push()
	
	public abstract function crawlStats();
	
	protected abstract function parseValues();
	
}//end class

?>