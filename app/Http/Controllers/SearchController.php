<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingoing;

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
                $data = Ingoing::where('subject', 'like', '%' . $query . '%')->orWhere('id', 'like', '%' . $query . '%')->orderBy('created_at', 'desc')->get();
            }else{
                $data = Ingoing::orderBy('id', 'desc')->get();
            }
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '<tr>
                        <td>' . $row->id . '</td>
                        <td>' . $row->subject . '</td>
                    </tr>';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="2">No Data Found</td>
                </tr>';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }        
    }
}
