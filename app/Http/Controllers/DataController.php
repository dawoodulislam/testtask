<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $fileName = time().'.'.$request->file->extension();
        $directory = 'uploads/';
        $request->file->move($directory, $fileName);

        return $fileName;
    }
    public function deleteImage(Request $request){
        $fileName = $request->fileName;
        $path = $fileName;
        if(file_exists(public_path().$path)){
            @unlink(public_path().$path);
        }
        return public_path().$path;
    }

    public function addData(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'gender' => 'required',
            'skills' => 'required'
        ]);

        $skills =  $request->skills;

        $skillsArray = [];

        foreach($skills as $skill){
            $skillsArray[] = $skill;
         }


        return Data::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $request->image,
            'gender' => $request->gender,
            'skills' => json_encode($skillsArray),
            // 'skills' => implode(",", $request->skills),
        ]);
    }

    public function getData(){
        return Data::orderBy('id', 'desc')->get();
    }

    public function editData(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'gender' => 'required',
            'skills' => 'required'
        ]);

        $skills =  $request->skills;

        $skillsArray = [];

        foreach($skills as $skill){
            $skillsArray[] = $skill;
         }

        return Data::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $request->image,
            'gender' => $request->gender,
            'skills' => json_encode($skillsArray),
            // 'skills' => implode(",", $request->skills),
            // 'skills' => $request->skills,
        ]);
    }

    public function deleteData(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'gender' => 'required',
            'skills' => 'required'
        ]);
        $fileName = $request->image;
        $path = $fileName;
        if(file_exists(public_path().$path)){
            @unlink(public_path().$path);
        }
        return Data::where('id', $request->id)->delete();
    }
}
