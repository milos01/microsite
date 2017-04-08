<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Image;

class PictureController extends Controller
{
	/**
     * Upload picture, move picture in /uploads/img folder.
     *
     * @return \Illuminate\Http\Response
     */
	public function uploadPicture(Request $request){
		if($request->hasFile('file')){
			$input = $request->all();
			
			$rules = array(
				'file' => 'image|max:3000|mimes:jpeg,jpg,png',
				);
			
			$validation = Validator::make($input, $rules);
			
			if ($validation->fails()) {
				return response($validation->errors(),422);
			}
			
            $destinationPath = 'uploads'; // upload path           
            $fileName = $request->file('file')->getClientOriginalName();

            Image::make($request->file('file'))->save(public_path('uploads/img/'.$fileName));
            return response($fileName, 200);
        }
    }
}
