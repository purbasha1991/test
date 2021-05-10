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
        define('STORAGE_URL', env('STORAGE_URL'));
        
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
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
    protected function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
  
}
