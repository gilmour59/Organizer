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
        $data = new ogmInOutFile();
        $data->subject = 'Test99';
        $data->save();
        dd($data->id);

        //Handle File Upload
        if ($request->hasFile('fileUpload')) {
            //get File Name
            $fileNameWithExtension = $request->file('fileUpload')->getClientOriginalName();
            $fileNameToStore = $data->id . '.' . $fileNameWithExtension;
            //Upload Image (Store to a folder)
            //add if else for ingoing and out going
            $path = $request->file('fileUpload')->storeAs('public/ingoing_pdf', $fileNameToStore);
        }else{
            $fileNameToStore = null;
        }
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
