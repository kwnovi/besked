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

class View{

	private $header;
	private $footer;
	protected $template;
	protected $data;

	public function __construct($template = null, $data = null){
		$this->header = __TEMPLATES_DIR__.'header.php';
		$this->footer = __TEMPLATES_DIR__.'footer.php';	
		$this->template = $template;
		$this->data = $data;
	}

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