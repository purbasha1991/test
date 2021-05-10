<?php
 /**
 * The base AppController file for other controllers to extend and use
 * Created On   : 08-Feb-2018
 * Note         : Do not modify code in this file without the consent of the author
 * 
 * ======================================================================
 * |Update History                                                      |
 * ======================================================================
 * |<Updated by>            |<Updated On> |<Remarks>                    |
 * ----------------------------------------------------------------------
 * |Name Goes Here          |01-Jan-2018  |Remark goes here        
 * ----------------------------------------------------------------------
 * |                        |             |                  
 * ----------------------------------------------------------------------
 * 
 * @package AppController
 * @author  Jabahar Mohapatra
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Components\FlashMessages;

//use Illuminate\Routing\Controller as BaseController;

class AppController extends Controller
{
    /**
     * The request object
     *
     * @var object
     */
    protected $request;

    /**
     * The variable to store variables to be passed to the view
     *
     * @var array
     */
    protected $viewVars = ['intPageNo' => 1, 'intRecsPerPage' => 40, 'arrPaging' => [], 'openFlag' => 'C', 'arrRecs' => []];

    /**
     * Stores the search conditions (in list view pages)
     *
     * @var array
     */
    protected $conditions = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function __construct(Request $objRequest)
    {
        // define('PUBLIC_PATH', 'http://localhost/solis-world-laravel/public/uploads/');
        // define('STORAGE_PATH', 'http://localhost/solis-world/storage/app/uploads/');
        // define('SOLIS_FILE_UPLOAD_TEMP_PATH', 'uploads/temp');
       
        define('API_URL', 'http://localhost/solis-world-laravel/api/');
        define('AUTH_KEY', env('JWT_SECRET'));
        define('STORAGE_URL', env('STORAGE_URL'));
        $this->middleware('auth');
        $this->request = $objRequest;

        $arrControllerParts = explode('\\', get_class($this));
        $strControllerName = array_pop($arrControllerParts);

        $strModelClass = 'App\Models\\' . str_replace('Controller', 'Model', $strControllerName);

        if (class_exists($strModelClass)) {
            $this->model = new $strModelClass;
        }

        if (request('hdn_PageNo')) {

            $this->viewVars['intPageNo'] = request('hdn_PageNo');

        }

    }
    protected function encryptor($action, $string) {
        try {
            $output = false;
            $encrypt_method = "AES-256-CBC";
            //pls set your unique hashing key
            $secret_key = 'csmpl@123';
            $secret_iv = 'csmtechnology';
            // hash
            $key = hash('sha256', $secret_key);
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            //do the encyption given text/string/number
            if ($action == 'encrypt') {
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            } else if ($action == 'decrypt') {
                //decrypt the given text/string/number
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
            if (!$output) {
                return $string;
            } else {
                return $output;
            }
        } catch (Exception $e) {
            // $this->writeException($e);
            //header("Location:" . APP_URL . "error"); 
        }
    }
    protected function respondWithErrorMessage($validator)
    {
        $required = $messages = [];
        $validatorMessages = $validator->errors()->toArray();
        foreach($validatorMessages as $field => $message) {
            if (strpos($message[0], 'required')) {
                $required[] = $field;
            }

            foreach ($message as $error) {
                $messages[] = $error;
            }
        }

        if (count($required) > 0) {
            $fields = implode(', ', $required);
            $message = "Missing required fields $fields";

            return $this->respondWithMissingField($message);
        }


        return $this->respondWithValidationError(implode(', ', $messages));
    }
    protected function respondWithMissingField($message)
    {
        return json_encode([
            'status' => 400,
            'message' => $message,
        ], 400);
    }
    private function respondWithValidationError($message)
    {
        return json_encode([
            'status' => 406,
            'message' => $message,
        ], 406);
    }
    protected function check_base64_image($base64) {
         $image_parts = explode(";base64,", $base64);
        if ( base64_encode(base64_decode($image_parts[1], true)) === $image_parts[1]){
            return true;
        } else {
            return false;
        }

        // imagepng($img, 'tmp.png');
        // $info = getimagesize('tmp.png');

        // unlink('tmp.png');

        // if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
        //     return true;
        // }

        // return false;
    }
}
