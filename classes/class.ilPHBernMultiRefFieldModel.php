<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once("./Modules/DataCollection/classes/Fields/Reference/class.ilDclReferenceFieldModel.php");

/**
 * Class ilPHBernMultiRefFieldModel
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiRefFieldModel extends ilDclReferenceFieldModel {

	const PROP_MAX_SELECTABLE = 'phbe_multiref_max_selectable';
	const PROP_MANDATORY_FIELDS = 'phbe_multiref_mandatory_fields';


	/**
	 * @var ilDclFieldTypePlugin
	 */
	protected $pl;


	/**
	 * ilPHBernMultiRefFieldModel constructor.
	 *
	 * @param int $a_id
	 */
	public function __construct($a_id = 0) {
		$this->pl = ilPHBernMultiRefPlugin::getInstance();

		parent::__construct($a_id);
	}


	public function getValidFieldProperties() {
		return array(ilDclBaseFieldModel::PROP_REFERENCE, ilDclBaseFieldModel::PROP_REFERENCE_LINK, self::PROP_MAX_SELECTABLE, self::PROP_MANDATORY_FIELDS);
	}

	public function getProperty($key) {
		if ($key == parent::PROP_N_REFERENCE) {
			return true;
		}
		return parent::getProperty($key);
	}


	public function checkValidity($value, $record_id = NULL) {
		$max_selectable = $this->getProperty(self::PROP_MAX_SELECTABLE);
		$mandatory_fields = $this->getProperty(self::PROP_MANDATORY_FIELDS);
		if (count($value) > $max_selectable || count($value) < $mandatory_fields) {
			throw new ilDclInputException(ilDclInputException::CUSTOM_MESSAGE, $this->pl->txt('exception_wrong_count'));
		}
		return parent::checkValidity($value, $record_id);
	}
}