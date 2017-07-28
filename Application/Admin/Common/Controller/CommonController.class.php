<?php
namespace Admin\Common\Controller;
use Common\Controller\AuthController;

class CommonController extends AuthController {
	//侧边栏列表
	public function side_list(){

	}

	public function writeDataToXls($expTitle,$expCellName,$expTableData){
		//http://www.thinkphp.cn/code/2124.html
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
		$fileName = 'member'.date('_YmdHis').'.xls';//or $xlsTitle 文件名称可根据自己情况设定
		$cellNum = count($expCellName);
		$dataNum = count($expTableData);
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("David")
									 ->setLastModifiedBy("David")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		// Add some data
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
		}
		// Miscellaneous glyphs, UTF-8
		for($i=0;$i<$dataNum;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
			}
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($xlsTitle);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=\"$fileName\"");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;

	}

   /*
    *输出CSV文件
    *$filename:文件名称 $data:要写入的数据
    */
    public function writeDataToCsv( )
    {
			//http://blog.csdn.net/chaozhi_guo/article/details/51003590
			//http://bbmz.org/post-169.html
			$datas = array(
				array('中国', '喜迎'),
				array('斯巴达', '召开'),
			);
			// 设定http输出头
			header('Content-Type: application/vnd.ms-excel;charset=utf8');
			header('Content-Disposition: attachment; filename=test.csv');
			header('Pragma: no-cache');
			header('Expires: 0');
			$fp = fopen('php://output', 'w');
			//输出BOM头
			fwrite($fp, chr(0XEF) . chr(0xBB) . chr(0XBF));
			//输出头
			fputcsv($fp, array('表头', '表头测试',));
			foreach ($datas as $value) {
				$cell = array(
					$value[0],
					$value[1],
				);
				fputcsv($fp, $cell);
			}
			fclose($fp);
    }


}
?>
