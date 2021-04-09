<?php


namespace CommonBundle\Helpers;


use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class ExcelHelper
 * @package CommonBundle\Helpers
 */
class ExcelHelper
{
    /**
     * @param $cols
     * @param $data
     * @param string $title
     * @return string
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel($cols, $data, $title = 'Export')
    {
        $target = 'uploads/download';
        $dir = './' . $target;
        $this->mdir($dir);
        $spreadsheet = new Spreadsheet();
        $activeSpreadsheet = $spreadsheet->setActiveSheetIndex(0);
        $j = 'A';
        foreach ($cols as $value) {
            $activeSpreadsheet->setCellValue($j . '1', $value);
            $j++;
        }

        $i = 2;
        foreach ($data as $value) {
            $j = 'A';
            foreach ($value as $v) {
                $activeSpreadsheet->setCellValue($j . $i, $v);
                $j++;
            }
            $i++;
        }

        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('php://output');

        $writer->save($dir . DIRECTORY_SEPARATOR . $title . '.xlsx');
        return $target . DIRECTORY_SEPARATOR . $title . '.xlsx';
    }

    /**
     * @param $mulCols
     * @param $mulData
     * @param string $title
     * @return string
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportMatchApplication($mulCols, $mulData, $title = 'Export')
    {
        $target = 'uploads/download';
        $dir = './' . $target;
        $this->mdir($dir);
        $spreadsheet = new Spreadsheet();
        $k = 0;
        foreach ($mulCols as $key => $cols) {
            if ($k == 1) {
                $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $key);
                $activeSpreadsheet = $spreadsheet->addSheet($myWorkSheet, $k);
            } else {
                $activeSpreadsheet = $spreadsheet->setActiveSheetIndex($k);
                $activeSpreadsheet->setTitle($key);
            }
            $j = 'A';
            foreach ($cols as $value) {
                $activeSpreadsheet->setCellValue($j . '1', $value);
                $j++;
            }

            $i = 2;
            foreach ($mulData[$key] as $value) {
                $j = 'A';
                foreach ($value as $v) {
                    $activeSpreadsheet->setCellValueExplicit($j . $i, $v, "s");
                    $j++;
                }
                $i++;
            }
            $k++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('php://output');

        $writer->save($dir . DIRECTORY_SEPARATOR . $title . '.xlsx');
        return $target . DIRECTORY_SEPARATOR . $title . '.xlsx';
    }

    /**
     * @param $dir
     */
    private function mdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}
