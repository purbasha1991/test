<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;	
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Components\FlashMessages;
class Controller extends BaseController
{
	public function __construct(Request $objRequest)
    {
        define('AUTH_KEY', env('JWT_SECRET'));
       
        
            if ($objRequest->header('Authorization')) {
                if(AUTH_KEY!=$objRequest->header('Authorization')){
                	// echo response()->json(['error'=> 'Unauthorized Access. Please provide valid Authorization Token.' ,'status'=> 101 ]);
                	echo json_encode(['error'=> 'Unauthorized Access. Please provide valid Authorization Token.' ,'status'=> 101 ]);
                	exit;
                }
                
            }
            else{
            	echo json_encode(['error'=> 'Unauthorized Access. Please provide valid Authorization Token.' ,'status'=> 101 ]);
            	//echo response()->json(['error'=> 'Unauthorized Access. Please provide valid Authorization Token.' ,'status'=> 101 ]);
            	exit;
            }
     
    }
    
  
}
