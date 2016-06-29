<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package
 * @author    Steffen Mohring
 */

use Contao\Message;

class Cleaner {

	public function formData($strName){

		if(\Input::get('do') == 'files' && \Input::get('act') == 'edit'){

			if(\Input::post('name')){

				$orgfile = \Input::post('name');
				$file = Cleaner::cleanFilename($orgfile);

				\Input::setPost('name', $file);
			}
		}

		if(\Input::get('do') == 'files' && \Input::get('act') == 'move'){

			if($_FILES['files']['name'] && is_array($_FILES['files']['name'])){
				foreach($_FILES['files']['name'] as $key => $file){
					$_FILES['files']['name'][$key] = Cleaner::cleanFilename($file);
				}
			}
		}
	}

	public static function cleanFilename ($file){

		$file = utf8_romanize($file);
		$file = strtolower($file);

		$pattern = array(
			'/[^a-z0-9\d_äöüß\. ]/',
			'/ä/',
			'/ö/',
			'/ü/',
			'/ß/',
			'/ +/',      //Eins oder mehrere Leerzeichen
			'/_+/'       //Ein oder mehrere Underscores ersetzen
		);

		$replacement = array(
			'',
			'ae',
			'oe',
			'ue',
			'ss',
			'-',
			'-',
		);

		return preg_replace($pattern, $replacement, $file);
	}
}