<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Reference/class.ilDclReferenceRecordRepresentation.php');

/**
 * Class ilPHBernMultiRefRecordRepresentation
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiRefRecordRepresentation extends ilDclReferenceRecordRepresentation {

	public function getHTML($link = true) {
		$value = $this->getRecordField()->getValue();
		$record_field = $this->getRecordField();

		if (!$value || $value == "-") {
			return "";
		}

		if (!is_array($value)) {
			$value = array($value);
		}

		$html = "<ul>";

		foreach ($value as $v) {
			$html .= '<li>';
			$ref_record = ilDclCache::getRecordCache($v);
			if (!$ref_record->getTableId() || !$record_field->getField() || !$record_field->getField()->getTableId()) {
				//the referenced record_field does not seem to exist.
				$record_field->setValue(NULL);
				$record_field->doUpdate();
			} else {
				$field = $this->getRecordField()->getField();
				if ($field->getProperty(ilDclBaseFieldModel::PROP_REFERENCE_LINK)) {
					$ref_record = ilDclCache::getRecordCache($v);
					$ref_table = $ref_record->getTable();

					if ($ref_table->getVisibleTableViews($_GET['ref_id'], true)) {
						$html .= $this->getLinkHTML(NULL, $v);
					} else {
						$html .= $ref_record->getRecordFieldHTML($field->getProperty(ilDclBaseFieldModel::PROP_REFERENCE));
					}
				} else {
					$html .= $ref_record->getRecordFieldHTML($field->getProperty(ilDclBaseFieldModel::PROP_REFERENCE));
				}
			}
			$html .= '</li>';
		}

		$html .= '</ul>'; // cut away last <br>

		return $html;
	}
}