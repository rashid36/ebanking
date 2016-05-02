<?php
require_once('connection.php');
	class REST {
		
            	public $_allow = array();
		public $_content_type = "application/json";
		public $_request = array();
		
		private $_method = "";		
		private $_code = 200;
		private $_format = '_json';
		
		public function __construct(){
                 date_default_timezone_set('Asia/Karachi');
			$this->inputs();
                        if (isset($_REQUEST['format'])){
                            if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'xml' || $_REQUEST['format'] == 'json') {
                                    $this->_format = '_'.$_REQUEST['format'];
                            }
                        }
		}
		
		/*public function get_referer(){
			return $_SERVER['HTTP_REFERER'];
		}*/
		
		public function response($data,$status){
			$this->_code = ($status)?$status:200;
			//$this->set_headers();
			$func = strtolower(trim(str_replace("/","",$this->_format)));
			if((int)method_exists($this,$func) > 0) {
				$output = $this->$func($data);
			} else {
				$output = $this->_format($data);
			}
			return $output;
		}//End response
		
		private function get_status_message(){
			$status = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}
		
		public function get_request_method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		private function inputs(){
			switch($this->get_request_method()){
				case "POST":
					$this->_request = $this->cleanInputs($_POST);
					break;
				case "GET":
				case "DELETE":
					$this->_request = $this->cleanInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"),$this->_request);
					$this->_request = $this->cleanInputs($this->_request);
					break;
				default:
					$this->response('',406);
					break;
			}
		}		
		
		private function cleanInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		
		/*Formats*/
		private function _json($data){
			if(is_array($data)){
				return json_encode($data);
			} else {
				return $data;
			}
			
		}//End json
		
		
		/*public function _xml($data = null, $structure = null, $basenode = 'xml')
		{
		if ($data === null and ! func_num_args())
		{
			$data = $this->_data;
		}

		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set('zend.ze1_compatibility_mode', 0);
		}

		if ($structure === null)
		{
			$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
		}

		// Force it to be something useful
		if ( ! is_array($data) AND ! is_object($data))
		{
			$data = (array) $data;
		}
		
		foreach ($data as $index => $record)
		{
			if(is_array($record)) {
				foreach($record as $key => $value) {

			// no numeric keys in our xml please!
			if (is_numeric($key))
            {
                // make string key...           
                $key = ($basenode != $basenode) ? $basenode : 'item';
            }

			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z_\-0-9]/i', '', $key);

            // if there is another array found recrusively call this function
            if (is_array($value) || is_object($value))
            {

                $node = $structure->addChild($key);

                // recrusive call.
               $this->_xml($value, $node, $key);
            }

            else
            {
                // add single node.
				$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");

				$structure->addChild($key, $value);
			}
				}
			}
		}

		return header('Content-Type: text/xml').$structure->asXML();
	}//End _xml*/
		function _xml($records){
			$xml_string = '<?xml version="1.0"?>
			<Response>
			';
			
			foreach($records as $index => $record) {
				if(is_array($record)) {
					foreach($record as $key => $value) {
						
						if(is_array($value)) {
							if (!is_numeric($key)) {
							$xml_string .= '<'.$key.'>
						';
							}
							foreach($value as $tag => $val) {
								if (is_array($val)) {
									if (!is_numeric($tag)) {
										$xml_string .= '<'.$tag.'>
										';
									}
									foreach($val as $tagInner => $valInner) {
										
										
											if (is_array($valInner)) {
											if (!is_numeric($tagInner)) {
											$xml_string .= '<'.$tagInner.'>
								';
											}
											foreach($valInner as $tagInner1 => $valInner1) {
												
												$valInner1 = htmlspecialchars(html_entity_decode($valInner1, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
												$xml_string .= '<'.$tagInner1.'>'.$valInner1.'</'.$tagInner1.'>
												';
											}
											if (!is_numeric($tagInner)) {
											$xml_string .= '</'.$tagInner.'>
								'; 			}
										}else{
											$valInner = htmlspecialchars(html_entity_decode($valInner, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
											$xml_string .= '<'.$tagInner.'>'.$valInner.'</'.$tagInner.'>
											';
										}
									}
									if (!is_numeric($tag)) {
									$xml_string .= '</'.$tag.'>
						';
									}
								
								} else {
									$val = htmlspecialchars(html_entity_decode($val, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
									$xml_string .= '<'.$tag.'>'.$val.'</'.$tag.'>
									';
								}
							}
							if (!is_numeric($key)) {
								$xml_string .= '</'.$key.'>
							';
							}
						} else {
							$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
							$xml_string .= '<'.$key.'>'.$value.'</'.$key.'>
								';
						}
						
					}
				}
			}
			
			$xml_string .= '</Response>';
			return header('Content-Type: text/xml').$xml_string;
		}//End _xml	
	
	
		private function set_headers(){
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			header("Content-Type:".$this->_content_type);
		}
	}	