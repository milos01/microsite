<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;
use App\TokenElement;
use App\TokenOrder;
use Auth;

class TokenController extends Controller
{
    public function showTokenPage(){
        return view('token');
    }

    public function showElementsPage(){
    	return view('contentElements');
    }

    public function saveContentElement(Request $request){
    	$website_id = $this->findSite($request->userSite);

    	$token = new TokenElement();
    	$token->website_id = $website_id;
    	$token->user_id = Auth::id();
    	$token->url = $request->url;
        $token->current_headline = null;
        $token->new_headline = null;
        $token->current_paragraph = null;
        $token->new_paragraph = null;
        $token->image = null;
    	$token->description = $request->description;
    	$token->element_type = $request->elType;
    	if ($request->elType == "Headline") {
    		$token->current_headline = $request->currentHeadline;
    		$token->new_headline = $request->newHeadline;
    	}else if($request->elType == "Paragraph"){
    		$token->current_paragraph = $request->currentParagraph;
    		$token->new_paragraph = $request->newParagraph;
    	}else{
    		$token->image = $request->image;
    	}
    	$token->payed = 0;
    	$token->save();
        return response($token, 200);
    }

    private function findSite($siteName){
    	$ws = Website::where('domain', $siteName)->first();
    	return $ws->id;
    }

    public function getSavedElements(){
        $elements = TokenElement::where('user_id', Auth::id())->where('payed', 0)->get();
        return response($elements, 200);
    }

    public function updateSavedElements(Request $request){

        $website_id = $this->findSite($request->userSite);

        $token = TokenElement::findorFail($request->id);
        $token->website_id = $website_id;
        $token->url = $request->url;
        $token->description = $request->description;
        $token->current_headline = null;
        $token->new_headline = null;
        $token->current_paragraph = null;
        $token->new_paragraph = null;
        $token->image = null;
        $token->element_type = $request->elType;
        if ($request->elType == "Headline") {
            $token->current_headline = $request->currentHeadline;
            $token->new_headline = $request->newHeadline;
        }else if($request->elType == "Paragraph"){
            $token->current_paragraph = $request->currentParagraph;
            $token->new_paragraph = $request->newParagraph;
        }else{
            $token->image = $request->image;
        }
        $token->save();
        return response($token, 200);
    }

    public function removeElements(Request $request){
        $token = TokenElement::findorFail($request->id);
        $token->delete();
        return response("ok", 200);
    }
}
