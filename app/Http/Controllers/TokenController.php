<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;
use App\TokenElement;
use App\TokenOrder;
use Auth;
use App\Http\Controllers\Helpers\UserHelper as Usr;

class TokenController extends Controller
{
    use Usr;

     /**
     * Save content token.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveContentElement(Request $request){
    	$website_id = $this->findSite($request->userSite);
    	$token = new TokenElement();
    	
    	$token->user_id = $this->loggedUserId();
    	$token->payed = 0;
        $this->makeNewToken($token, $website_id, $request);
        $token->save();
        return response($token, 200);
    }

     /**
     * Find website by website name.
     *
     * @return Integer
     */
    private function findSite($siteName){
    	$ws = Website::where('domain', $siteName)->first();
    	return $ws->id;
    }

    /**
     * Get all saved elements which which are not paid.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSavedElements(){
        $elements = TokenElement::where('user_id', Auth::id())->where('payed', 0)->get();
        return response($elements, 200);
    }

     /**
     * Update all saved elements which are not paid.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSavedElements(Request $request){
        $website_id = $this->findSite($request->userSite);

        $token = TokenElement::findorFail($request->id);
        $this->makeNewToken($token, $website_id, $request);
        $token->save();
        return response($token, 200);
    }

     /**
     * Remove saved element.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeElements(Request $request){
        $token = TokenElement::findorFail($request->id);
        $token->delete();
        return response("ok", 200);
    }

      /**
     * Generate new content update token.
     *
     * @return Void
     */
    private function makeNewToken(TokenElement $token, $website_id, $request){
        $token->website_id = $website_id;
        $token->user_id = $this->loggedUserId();
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
    }
}
