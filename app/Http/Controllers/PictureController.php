<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Image;

class PictureController extends Controller
{
    public function uploadPicture(Request $request){
        if($request->hasFile('file')){
            $input = $request->all();
     
            $rules = array(
                'file' => 'image|max:3000|mimes:jpeg,jpg,png',
            );
     
            $validation = Validator::make($input, $rules);
     
            if ($validation->fails()) {
                return response($validation->errors(),200);
            }
     		
            $destinationPath = 'uploads'; // upload path
            // $extension = $request->file('file')->getClientOriginalExtension(); // getting file extension
            $fileName = $request->file('file')->getClientOriginalName();
            // $upload_success = $request->file('file')->move(public_path('img'), $fileName); // uploading file to given path
            Image::make($request->file('file'))->save(public_path('uploads/img/'.$fileName));

            
            return response($fileName, 200);
        }
    }
}
