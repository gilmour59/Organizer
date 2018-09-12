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
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '<tr>
                        <td class="align-middle">' . $row->id . '</td>
                        <td class="align-middle">' . $row->date . '</td>
                        <td class="align-middle">' . $row->to . '</td>
                        <td class="align-middle">' . $row->from . '</td>
                        <td class="align-middle">' . $row->name . '</td>
                        <td style="text-align:left">' . $row->subject . '</td>
                        <td class="align-middle"> <a style="font-size:12px" href=" '. route('search.view') .'" target="_blank" class="btn btn-success">View</a> </td>
                        <td class="align-middle"> <a style="font-size:12px" href="" class="btn btn-primary">Download</a> </td>
                        <td class="align-middle"> <a style="font-size:12px" href="" class="btn btn-info">Edit</a> </td>
                        <td class="align-middle"> <a style="font-size:12px" href="" class="btn btn-danger">X</a> </td>
                    </tr>';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="10">No Data Found</td>
                </tr>';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
                //ADD LINK VARIABLE HERE AND TEST
            );

            echo json_encode($data);
        }        
    }

    public function view($id = ''){

        return response()->file('C:\Users\Gil\Pictures\level3helmet.jpg');
    }
}
