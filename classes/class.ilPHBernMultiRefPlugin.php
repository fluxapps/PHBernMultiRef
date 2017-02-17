<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Plugin/class.ilDclFieldTypePlugin.php');

/**
 * Class ilPHBernMultiRefPlugin
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiRefPlugin extends ilDclFieldTypePlugin {
	/**
	 * Get Plugin Name. Must be same as in class name il<Name>Plugin
	 * and must correspond to plugins subdirectory name.
	 *
	 * Must be overwritten in plugin class of plugin
	 *
	 * @return    string    Plugin Name
	 */
	function getPluginName() {
		return "PHBernMultiRef";
	}
}