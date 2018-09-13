<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ogmInOutFile;

class SearchController extends Controller
{
    public function index(){

        return view('index');
    }

    public function action(Request $request){

        if($request->ajax()){
            $output = "";
            $query = $request->get('query');
            if($query != ''){
                $data = ogmInOutFile::where('subject', 'like', '%' . $query . '%')
                ->orWhere('id', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            }else{
                $data = ogmInOutFile::orderBy('id', 'desc')->paginate(10);
            }
            $total_row = $data->total();
            $pagination = '<div>'. $data->links() .'</div>';

            $dataList = array(
                'table_data' => $data,
                'total_data' => $total_row,
                'pagination' => $pagination
            );

            echo json_encode($dataList);
        }        
    }

    public function view($id = ''){

        return response()->file('C:\Users\Gil\Pictures\level3helmet.jpg');
    }
}
