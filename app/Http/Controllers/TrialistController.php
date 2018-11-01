<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trialist;

class TrialistController extends Controller
{
    //
    public function index(Request $request){ 
    	//listings
    	$tl = Trialist::simplePaginate();  

    	return response()->json([
    		'success' 		=> true,
    		'status' 		=> 200,
    		'data' 			=> $tl
    	]); 
    }

    public function find(Request $request){
    	$fbUrlCheck = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
		$secondCheck = '/home((\/)?\.[a-zA-Z0-9])?/'; 

		if( preg_match($fbUrlCheck, $request->link) == 0 || preg_match($secondCheck, $request->link) == 1) {
			return response()->json([
	    		'success' 		=> false,
	    		'status' 		=> 200,
	    		'message'		=> 'Invalid Facebook Url'
	    	]);
		} 

		$tl = Trialist::where('link',$request->link)->first();
		if(is_null($tl)){
			return response()->json([
	    		'success' 		=> false,
	    		'status' 		=> 200,
	    		'message'		=> 'Link not found!'
	    	]);
		}

		return response()->json([
    		'success' 		=> true,
    		'status' 		=> 200,
    		'data'			=> $tl
    	]); 
    }

    public function store(Request $request){ 

    	$fbUrlCheck = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
		$secondCheck = '/home((\/)?\.[a-zA-Z0-9])?/'; 

		if( preg_match($fbUrlCheck, $request->link) == 0 || preg_match($secondCheck, $request->link) == 1) {
			return response()->json([
	    		'success' 		=> false,
	    		'status' 		=> 200,
	    		'message'		=> 'Invalid Facebook Url'
	    	]);
		} 

		$tl = Trialist::where('link',$request->link)->first();

		if($tl){
			$tl->count = $tl->count + 1;
			$tl->save();
		}else{
			$tl = new Trialist;
			$tl->link = $request->link;
			$tl->save();
		} 

		return response()->json([
    		'success' 		=> true,
    		'status' 		=> 200,
    		'data'			=> $tl
    	]); 
    }
}
