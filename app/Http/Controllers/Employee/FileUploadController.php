<?php

namespace App\Http\Controllers\Employee;
use Illuminate\Http\Request;
use App\Models\employeeInfo;


class FileUploadController
{
    private $arrEmployeementType = [
        'アルバイト' => 'A',
        '社員' => 'B'
    ];
    public function uploadIndex()
    {
        return view('employee.fileUploadIndex', []);
    }

    // ファイルアップロード
    public function fileImport(Request $req)
    {
        $responseData = [
            'success' => false,
            'message' => '',
            'html' => ''
        ];
        try{
            if( !$req->hasFile('files') ) {
                throw new \Exception('保存するファイルがありません。');
            }
            $arrEncodeType = ['ASCII', 'UTF-8', 'JIS', 'EUC-JP', 'EUC-KR', 'SJIS-win'];
            $arrDataToInsert = [];
            $returnHtml = "<table border='1'>";

            $fileHandle = fopen($req->file('files')[0], 'r');
            if( $fileHandle !== false ) {
                $row = 0;
                while( ($fileData = fgetcsv($fileHandle, 10000, ',')) !== false ) {
                    $returnHtml .= "<tr>";

                    $arrConvert = array_map(function($item) use ($arrEncodeType) {
                        $strEncodeType = mb_detect_encoding($item, $arrEncodeType);
                        return mb_convert_encoding($item, 'UTF-8', $strEncodeType);
                    }, $fileData);

                    if( $row >= 1 ) {
                        // DB保存
                        $arrDataToInsert[] = [
                            'first_name'        => $arrConvert[1],
                            'last_name'         => $arrConvert[0],
                            'main_group'        => $arrConvert[3],
                            'sub_group'         => $arrConvert[4],
                            'phone_number'      => $arrConvert[6],
                            'employeement_type' => $this->getEmployeementType($arrConvert[5]),
                            'mail_address'      => $arrConvert[7],
                            'employee_code'     => $arrConvert[8],
                            'salary'            => (int) $arrConvert[10],
                            'commuting_expense' => (int) $arrConvert[11],
                            'note'              => $arrConvert[12],
                            'employeement_date' => $arrConvert[2],
                            'birth_date'        => $arrConvert[9],
                        ];
                    }

                    // html
                    foreach( $arrConvert as $row =>  $columnValue ) {
                        $returnHtml .= "<td>";
                        $returnHtml .= $columnValue;
                        $returnHtml .= "</td>";
                    }
                    $returnHtml .= "</tr>";
                    $row++;
                }
                fclose($fileHandle);

                if( !empty($arrDataToInsert) ) {
                    EmployeeInfo::insert($arrDataToInsert);
                }
            }
            $returnHtml .= "</table>";
            
            $responseData['success'] = true;
            $responseData['html'] = $returnHtml;
        } catch( \Exception $e ) {
            $responseData['message'] = $e->getMessage();
        } finally {
            return response()->json($responseData);
        }
    }

    private function getEmployeementType( $str ) {
        if( empty($str) || !in_array($str, $this->arrEmployeementType) ) {
            return 'A';
        }
        return $this->arrEmployeementType[$str];
    }
}
