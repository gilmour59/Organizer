<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ogmInOutFile;

class PostsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'addDate' => 'required',
            'addSubject' => 'required',
            'addFileUpload' => 'file|required'
        ]);

        //Create new Data 
        $data = new ogmInOutFile();
        $data->date = $request->input('addDate');
        $data->to = $request->input('addTo');
        $data->from = $request->input('addFrom');
        $data->name = $request->input('addName');
        $data->letter = $request->input('addLetter');
        $data->save();
 
        //Handle File Upload
        if ($request->hasFile('addFileUpload')) {
            //get File Name
            $fileNameWithExtension = $request->file('addFileUpload')->getClientOriginalName();
            $fileNameToStore = $data->id . '.' . $fileNameWithExtension;
            //Upload Image (Store to a folder)
            //add if else for ingoing and out going
            $path = $request->file('addFileUpload')->storeAs('public/ingoing', $fileNameToStore);
        }else{
            $fileNameToStore = null;
        }
        
        $data->file = $fileNameToStore;
        $data->save();

        //Redirecting With Flashed Session Data
        return redirect('/')->with('success', 'Post Added!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
