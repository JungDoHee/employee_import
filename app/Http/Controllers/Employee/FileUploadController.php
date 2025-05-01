<?php

namespace App\Http\Controllers\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\employee_info_file;


class FileUploadController
{
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
        ];
        try{
            if( !$req->hasFile('files') ) {
                throw new \Exception('保存するファイルがありません。');
            }

            $DEmployeeInfoFile = new employee_info_file;

            foreach($req->file('files') as $file) {
                if(strtolower($file->getClientOriginalExtension()) != 'csv') {
                    throw new \Exception('csvファイルでアップロードしてください');
                }
                $path = $file->storeAs('uploads', $file->getClientOriginalName(), 'local');
                $DEmployeeInfoFile->file_path = $path;
                $DEmployeeInfoFile->save();
            }
            $responseData['success'] = true;
        } catch( \Exception $e ) {
            $responseData['message'] = $e->getMessage();
        } finally {
            return response()->json($responseData);
        }
    }
}
