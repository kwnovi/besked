<?php

class View{

	private $header;
	private $footer;
	protected $template;
	protected $data;

	public function __construct($template = null, $data = null){
		$this->header = __TEMPLATE_DIR__.'header.php';
		$this->footer = __TEMPLATE_DIR__.'footer.php';	
		$this->template = $template;
		$this->data = $data;
	}

	public function render(){
		if($this->data !== null)
			extract($this->data);
        ob_start();
        include ($this->header);
        include ($this->template);
        include ($this->footer);
        ob_end_flush();
	}
}