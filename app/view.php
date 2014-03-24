<?php
/**
 * View
 *
 * Classe permettant de générer proprement des pages à partir de templates.
 *
 * Licensed under The WTFPL License
 *
 * @license http://www.wtfpl.net/txt/copying/
 * @author Lucien Varaca <k.wnovi@gmail.com>
 * @author Quentin Le Bour <q.lebour@gmail.com>
 */

// TODO
// Permettre d'injecter tel ou tel css/js depuis le php

abstract class View{

	protected $header;
	protected $footer;
	protected $template;
	protected $data;


	// fonction générant la vue
	public function render(){
		if($this->data !== null){
			// passe les données contenues dans 'data' comme variables globale
			// elles deviennent ainsi accessibles dans le fichier de template
			extract($this->data);
		}

		// écriture directe dans le flux de sortie 
        ob_start();
        include ($this->header);
        include ($this->template);
        include ($this->footer);
        ob_end_flush();
	}
}

class LandingView extends View{
	public function __construct($template = null, $data = null){
		$this->header = __TEMPLATES_DIR__.'landing_header.php';
		$this->footer = __TEMPLATES_DIR__.'landing_footer.php';	
		$this->template = $template;
		$this->data = $data;
	}
}

class HomeView extends View{
	public function __construct($template = null, $data = null){
		$this->header = __TEMPLATES_DIR__.'home_header.php';
		$this->footer = __TEMPLATES_DIR__.'home_footer.php';	
		$this->template = $template;
		$this->data = $data;
	}
}