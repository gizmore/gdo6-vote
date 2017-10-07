<?php
namespace GDO\Vote;

use GDO\Core\GDO_Module;
use GDO\Core\Module_Core;

final class Module_Vote extends GDO_Module
{
	public $module_priority = 25;
	
	public function onLoadLanguage() { $this->loadLanguage('lang/votes'); }
	
	public function onIncludeScripts()
	{
		$min = Module_Core::instance()->cfgMinifyJS() !== 'no' ? '.min' : '';
		if (module_enabled('Angular'))
		{
		    $this->addJavascript('js/gwf-vote-ctrl.js');
		}
		$this->addCSS('css/gwf-votes.css');
	}
}
