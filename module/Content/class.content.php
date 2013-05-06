<?php

/**
 * @package Module_Content
 * @author Mesut Erdemir <erdemirmesut@gmail.com>
 * @copyright 2013 Papirus (http://egolabs.org)
 * @license Read LICENSE file under root folder
 * @link https://github.com/egolabs/papirus
 */
class Module_Content extends Papirus_Module {
	
	function render() {
		$articles = array(
			array('title' => "Test1"), 
			array('title' => "Test2")
		);
		
		ob_start();

		include dirname(__FILE__) . "/layout/title_list.tpl";

		return ob_get_clean();
	}
	
}
