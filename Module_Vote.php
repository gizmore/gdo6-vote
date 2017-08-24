<?php
namespace GDO\Vote;

use GDO\Core\Module;
use GDO\GWF\Module_GWF;

final class Module_Vote extends Module
{
	public $module_priority = 25;
	
	public function onLoadLanguage() { $this->loadLanguage('lang/votes'); }
	
	public function onIncludeScripts()
	{
		$min = Module_GWF::instance()->cfgMinifyJS() !== 'no' ? '.min' : '';
		$this->addJavascript('js/gwf-vote-ctrl.js');
		$this->addCSS('css/gwf-votes.css');
	}
}
