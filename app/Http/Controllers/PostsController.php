<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ogmInOutFile;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->put('search', $request
              ->has('search') ? $request->get('search') : ($request->session()
              ->has('search') ? $request->session()->get('search') : ''));

        $ogmFiles = new ogmInOutFile();
        
        $ogmFiles = $ogmFiles->where('subject', 'like', '%' . $request->session()->get('search') . '%')
                ->orWhere('id', 'like', '%' . $request->session()->get('search') . '%')
                ->orderBy('created_at', 'asc')
                ->paginate(10);

        if($request->ajax()){
            return view('index')->with('ogmFiles', $ogmFiles);
        }else{
            return view('ajax')->with('ogmFiles', $ogmFiles);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'addDate' => 'required',
            'addSubject' => 'required',
            'addFileUpload' => 'file|required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'fail' =>true,
                'errors' => $validator->errors()
            ]);
        }

        //Create new Data 
        $ogmFiles = new ogmInOutFile();
        $ogmFiles->date = $request->input('addDate');
        $ogmFiles->to = $request->input('addTo');
        $ogmFiles->from = $request->input('addFrom');
        $ogmFiles->name = $request->input('addName');
        $ogmFiles->letter = $request->input('addLetter');
        $ogmFiles->save();
 
        //Handle File Upload
        if ($request->hasFile('addFileUpload')) {

            //get File Name
            $fileNameWithExtension = $request->file('addFileUpload')->getClientOriginalName();
            $fileNameToStore = $ogmFiles->id . '.' . $fileNameWithExtension;

            //Upload Image (Store to a folder)
            //add if else for ingoing and out going
            $path = $request->file('addFileUpload')->storeAs('public/ingoing', $fileNameToStore);
        }else{
            $fileNameToStore = null;
        }
        
        $ogmFiles->file = $fileNameToStore;
        $ogmFiles->save();

        return response()->json([
            'fail' => false
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
        //
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
        $validator = $request->validate([
            'addDate' => 'required',
            'addSubject' => 'required',
            'addFileUpload' => 'file'
        ]);

        if ($validator->fails()){
            return response()->json([
                'fail' =>true,
                'errors' => $validator->errors()
            ]);
        }

        //Find Data 
        $ogmFiles = ogmInOutFile::find($id);
        $ogmFiles->date = $request->input('addDate');
        $ogmFiles->to = $request->input('addTo');
        $ogmFiles->from = $request->input('addFrom');
        $ogmFiles->name = $request->input('addName');
        $ogmFiles->letter = $request->input('addLetter');
        $ogmFiles->save();
 
        //Handle File Upload
        if ($request->hasFile('addFileUpload')) {

            //get File Name
            $fileNameWithExtension = $request->file('addFileUpload')->getClientOriginalName();
            $fileNameToStore = $ogmFiles->id . '.' . $fileNameWithExtension;

            //Upload Image (Store to a folder)
            //add if else for ingoing and out going
            $path = $request->file('addFileUpload')->storeAs('public/ingoing', $fileNameToStore);

            $ogmFiles->file = $fileNameToStore;
            $ogmFiles->save();
        }

        return response()->json([
            'fail' => false
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
}
