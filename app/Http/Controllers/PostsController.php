<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use App\ogmInOutFile;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->session()->put('type', $request
                ->has('type') ? $request->get('type') : ($request->session()
                ->has('type') ? $request->session()->get('type') : 1));

        $request->session()->put('search', $request
                ->has('search') ? $request->get('search') : ($request->session()
                ->has('search') ? $request->session()->get('search') : ''));

        $request->session()->put('field', $request
                ->has('field') ? $request->get('field') : ($request->session()
                ->has('field') ? $request->session()->get('field') : 'date'));

        $request->session()->put('sort', $request
                ->has('sort') ? $request->get('sort') : ($request->session()
                ->has('sort') ? $request->session()->get('sort') : 'asc'));

        $ogmFiles = new ogmInOutFile();
        
        $ogmFiles = $ogmFiles
            ->where('letter', '=', $request->session()->get('type'))
            ->where(function ($query) use ($request){
                $query
                    ->where('subject', 'like', '%' . $request->session()->get('search') . '%')
                    ->orWhere('id', 'like', '%' . $request->session()->get('search') . '%');
            })
            ->orderBy($request->session()->get('field'), $request->session()->get('sort'))
            ->paginate(10);

            //dd($ogmFiles);
            //dd($request->session()->get('sort'));

            $type = $request->session()->get('type');

            if($request->ajax()){
                return view('index')->with('ogmFiles', $ogmFiles)->with('type', $type);
            }

            return view('ajax')->with('ogmFiles', $ogmFiles)->with('type', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addDate' => 'required',
            'addSubject' => 'required',
            'addFileUpload' => 'file|required'
        ]);

        if ($validator->fails())
            return response()->json([
            'fail' =>true,
            'errors' => $validator->errors()
            ]);

        //Create new Data 
        $ogmFiles = new ogmInOutFile();
        $ogmFiles->date = $request->input('addDate');
        $ogmFiles->to = $request->input('addTo');
        $ogmFiles->from = $request->input('addFrom');
        $ogmFiles->name = $request->input('addName');
        $ogmFiles->subject = $request->input('addSubject');
        $ogmFiles->letter = $request->input('addLetter');
        $ogmFiles->save();
 
        //Handle File Upload
        if ($request->hasFile('addFileUpload')) {

            //get File Name
            $fileNameWithExtension = $request->file('addFileUpload')->getClientOriginalName();
            $fileNameToStore = $ogmFiles->id . '' . $fileNameWithExtension;

            //Upload Image (Store to a folder)
            //add if else for ingoing and out going
            if($ogmFiles->letter){
                $path = $request->file('addFileUpload')->storeAs('public/ingoing', $fileNameToStore);
            }else{
                $path = $request->file('addFileUpload')->storeAs('public/outgoing', $fileNameToStore);
            }
            
        }else{
            $fileNameToStore = null;
        }
        
        $ogmFiles->file = $fileNameToStore;
        $ogmFiles->save();
        
        return response()->json([
            'fail' => false,
            'redirect_url' => route('index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ogmFiles = ogmInOutFile::find($id);

        return response()->json([
            'data' => $ogmFiles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'editDate' => 'required',
            'editSubject' => 'required',
            'editFileUpload' => 'file'
        ]);

        if ($validator->fails())
            return response()->json([
                'fail' =>true,
                'errors' => $validator->errors()
            ]);


        //Find Data 
        $ogmFiles = ogmInOutFile::find($id);
        $ogmFiles->date = $request->input('editDate');
        $ogmFiles->to = $request->input('editTo');
        $ogmFiles->from = $request->input('editFrom');
        $ogmFiles->name = $request->input('editName');
        $ogmFiles->subject = $request->input('editSubject');

        if($ogmFiles->letter != $request->input('editLetter')){
            if($request->input('editLetter')){
                Storage::move('public/outgoing/' . $ogmFiles->file, 'public/ingoing/' . $ogmFiles->file);
            }else{
                Storage::move('public/ingoing/' . $ogmFiles->file, 'public/outgoing/' . $ogmFiles->file);
            }
        }

        $ogmFiles->letter = $request->input('editLetter');

        $ogmFiles->save();
 
        //Handle File Upload
        if ($request->hasFile('editFileUpload')) {

            //get File Name
            $fileNameWithExtension = $request->file('editFileUpload')->getClientOriginalName();
            $fileNameToStore = $ogmFiles->id . '' . $fileNameWithExtension;

            //Upload Image (Store to a folder)
            //edit if else for ingoing and out going

            
            if($ogmFiles->letter){
                Storage::delete('public/ingoing/' . $ogmFiles->file);
                $path = $request->file('editFileUpload')->storeAs('public/ingoing', $fileNameToStore);
            }else{
                Storage::delete('public/outgoing/' . $ogmFiles->file);
                $path = $request->file('editFileUpload')->storeAs('public/outgoing', $fileNameToStore);
            }

            $ogmFiles->file = $fileNameToStore;
            $ogmFiles->save();
        }

        return response()->json([
            'fail' => false,
            'redirect_url' => route('index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ogmFiles = ogmInOutFile::find($id);
        
        if($ogmFiles->letter){
            if($ogmFiles->file != null){
                //Delete the file
                Storage::delete('public/ingoing/' . $ogmFiles->file);
            }
        }else{
            if($ogmFiles->file != null){
                //Delete the file
                Storage::delete('public/outgoing/' . $ogmFiles->file);
            }
        }
        $ogmFiles->delete();

        return redirect('/');
    }
    
    public function view($id)
    {
        $ogmFiles = ogmInOutFile::find($id);

        if($ogmFiles->letter){
            if($ogmFiles->file != null){
                return response()->file(storage_path('app/public/ingoing/') . $ogmFiles->file);
            }
        }else{
            if($ogmFiles->file != null){
                return response()->file(storage_path('app/public/outgoing/') . $ogmFiles->file);
            }
        }
    }

    public function download($id)
    {
        $ogmFiles = ogmInOutFile::find($id);

        if($ogmFiles->letter){
            if($ogmFiles->file != null){
                return response()->download(storage_path('app/public/ingoing/') . $ogmFiles->file);
            }
        }else{
            if($ogmFiles->file != null){
                return response()->download(storage_path('app/public/outgoing/') . $ogmFiles->file);
            }
        }
    }
}
