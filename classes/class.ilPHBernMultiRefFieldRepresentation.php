<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Reference/class.ilDclReferenceFieldRepresentation.php');
require_once('class.ilPHBernMultiRefPlugin.php');
require_once('./Services/Form/classes/class.ilNumberInputGUI.php');

/**
 * Class ilPHBernMultiRefFieldRepresentation
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiRefFieldRepresentation extends ilDclReferenceFieldRepresentation {

	/**
	 * @var ilDclFieldTypePlugin
	 */
	protected $pl;

	/**
	 * ilPHBernConditionalReferenceFieldRepresentation constructor.
	 *
	 * @param ilDclBaseFieldModel $field
	 */
	public function __construct(ilDclBaseFieldModel $field) {
		$this->pl = ilPHBernMultiRefPlugin::getInstance();

		parent::__construct($field);
	}

	/**
	 * @param ilObjDataCollection $dcl
	 * @param string              $mode
	 *
	 * @return ilPropertyFormGUI
	 */
	public function buildFieldCreationInput(ilObjDataCollection $dcl, $mode = 'create') {
		$opt = ilDclBaseFieldRepresentation::buildFieldCreationInput($dcl, $mode);
		$options = array();
		// Get Tables
		$tables = $dcl->getTables();
		foreach ($tables as $table) {
			foreach ($table->getRecordFields() as $field) {
				//referencing references may lead to endless loops.
				if ($field->getDatatypeId() != ilDclDatatype::INPUTFORMAT_REFERENCE) {
					$options[$field->getId()] = $table->getTitle() . self::REFERENCE_SEPARATOR . $field->getTitle();
				}
			}
		}
		$prop_table_selection = new ilSelectInputGUI($this->lng->txt('dcl_reference_title'), 'prop_' .ilDclBaseFieldModel::PROP_REFERENCE);
		$prop_table_selection->setOptions($options);

		$opt->addSubItem($prop_table_selection);

		$prop_ref_link = new ilDclCheckboxInputGUI($this->lng->txt('dcl_reference_link'), 'prop_'.ilDclBaseFieldModel::PROP_REFERENCE_LINK);
		$prop_ref_link->setInfo($this->lng->txt('dcl_reference_link_info'));
		$opt->addSubItem($prop_ref_link);

		$mandatory_fields = new ilNumberInputGUI($this->pl->txt('mandatory_fields'), 'prop_' .ilPHBernMultiRefFieldModel::PROP_MANDATORY_FIELDS);
		$opt->addSubItem($mandatory_fields);

		$max_selectable = new ilNumberInputGUI($this->pl->txt('max_selectable'), 'prop_' .ilPHBernMultiRefFieldModel::PROP_MAX_SELECTABLE);
		$opt->addSubItem($max_selectable);

		return $opt;
	}


	public function getInputField(ilPropertyFormGUI $form, $record_id = 0) {
		$input = parent::getInputField($form, $record_id);
		$input->setInfo(sprintf($this->pl->txt('info_input_field'),
			$this->field->getProperty(ilPHBernMultiRefFieldModel::PROP_MANDATORY_FIELDS),
			$this->field->getProperty(ilPHBernMultiRefFieldModel::PROP_MAX_SELECTABLE)));
		return $input;
	}
}