<?php
class TestDataReader {

	private $dataFileName; //assiging the filename

	function __construct($FileName) {
		$this->dataFileName = $FileName;
	}

	public function readTestDataFromExcelFile($testDataSheetName, $ColumnName) {
		if (! file_exists ( $this->dataFileName )) {
			throw new Exception ( "Please give a valid Excel testData " );
		}

		$objPHPExcel = new PHPExcel ();
		$objPHPExcel = PHPExcel_IOFactory::load ( $this->dataFileName );
		$objPHPExcel->setActiveSheetIndexByName ( $testDataSheetName );
		$objWorksheet = $objPHPExcel->getActiveSheet ();
		$highestRow = $objWorksheet->getHighestRow ();
		$colRow = $objWorksheet->getHighestColumn ();
		$highestCol = PHPExcel_Cell::columnIndexFromString ( $colRow );
		//echo "**********" . $highestCol;
		$Datahashmap = array();
		for($ColCount = 0; $ColCount < $highestCol; $ColCount ++) {
			$key = $objWorksheet->getCellByColumnAndRow ( $ColCount, 1 )->getValue ();
			$value = $objWorksheet->getCellByColumnAndRow ( $ColCount, 2 )->getValue ();
			$Datahashmap[$key] = $value;
		}
		return $Datahashmap;
	}
}

?>
