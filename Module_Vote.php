<?php
namespace GDO\Vote;

use GDO\Core\GDO_Module;
use GDO\Core\Module_Core;
use GDO\DB\GDT_UInt;

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
		if (module_enabled('JQuery'))
		{
			$this->addJavascript('js/gdo-vote.js');
		}
			
		$this->addCSS('css/gwf-votes.css');
	}
	
	/**
	 * Store some stats in hidden settings.
	 */
	public function getUserConfig()
	{
		return array(
			GDT_UInt::make('likes')->initial('0'),
		);
	}
}
