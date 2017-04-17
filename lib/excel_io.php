<?
require_once 'PHPExcel.php';
require_once (dirname(__FILE__).'/PHPExcel/IOFactory.php');
require_once (dirname(__FILE__).'/PHPExcel/Reader/Excel5.php');
class excel_io {
	function Toarray($path, $_f) {
		$tmparray = explode(".", $_f);
		$tmpnum = count($tmparray);
		$tmpnum = $tmpnum - 1;
		if ($tmparray[$tmpnum] == 'xls') {
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			//use Excel5 for 2003 format
			$excelpath = $path . $_f;
			$objPHPExcel = $objReader -> load($excelpath);
			$sheet = $objPHPExcel -> getSheet(0);
			$highestRow = $sheet -> getHighestRow();
			//取得总行数
			$highestColumn = $sheet -> getHighestColumn();
			//取得总列数
		} else {
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			//use Excel5 for 2003 format
			$excelpath = "./upload/" . $_f;
			$objPHPExcel = $objReader -> load($excelpath);
			$sheet = $objPHPExcel -> getSheet(0);
			$highestRow = $sheet -> getHighestRow();
			//取得总行数
			$highestColumn = $sheet -> getHighestColumn();
			//取得总列数
		}
		$data = array();
		for ($j = 1; $j <= $highestRow; $j++)//从第二行开始读取数据
		{
			$str = "";
			for ($k = 'A'; $k <= $highestColumn; $k++)//从A列读取数据
			{
				$str .= $objPHPExcel -> getActiveSheet() -> getCell("$k$j") -> getValue() . '|*|';
				//读取单元格
			}
			$str = mb_convert_encoding($str, 'UTF-8', 'auto');
			//根据自己编码修改
			$strs = explode("|*|", $str);
			$data[$j] = $strs;
			// echo $str . "<br />";
			//$sql = "insert into u_ip (user,nam,rom_num,ip,mac) values ('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}','{$strs[4]}')";
		}
		return $data;
	}

	function Toxls($data, $f_name, $title = '', $creator = '') {
		//	$data = array(0 => array('id' => 1001, 'username' => '张飞', 'password' => '123456', 'address' => '三国时高老庄250巷101室'), 1 => array('id' => 1002, 'username' => '关羽', 'password' => '123456', 'address' => '三国时花果山'), 2 => array('id' => 1003, 'username' => '曹操', 'password' => '123456', 'address' => '延安西路2055弄3号'), 3 => array('id' => 1004, 'username' => '刘备', 'password' => '654321', 'address' => '愚园路188号3309室'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setCreator($creator) -> setLastModifiedBy($creator) -> setTitle($title) -> setSubject('Office 2007 XLSX Document') -> setDescription('Document for Office 2007 XLSX, generated using PHP classes.') -> setKeywords('office 2007 openxml php') -> setCategory('Result file');
		$i = 1;
		$list = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		foreach ($data as $k => $v) {
			foreach ($v as $key => $val) {
				$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue($list[$key] . $i, $val);
			}
			$i++;
			//i是行数，list是列名称
		}
		$objPHPExcel -> getActiveSheet() -> setTitle($title);
		$objPHPExcel -> setActiveSheetIndex(0);
		$outputFileName = $f_name;
		$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel);
		//ob_start(); ob_flush();
    	header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition:inline;filename="' . $f_name . '"');
		header("Content-Transfer-Encoding: binary");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		$xlsWriter -> save("php://output");
	}
}
?>