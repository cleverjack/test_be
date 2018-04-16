<?php



namespace App\Classes\response;





class Api

{



    /**

     * Function will

     *   - return Json success response to the User

     *

     * @param $code

     * @param array $data

     * @param array $bindUser

     * @param bool $wantJsonOutput

     * @return array|string

     */

    public static function success($code, $data = array(), $bindUser = array(), $wantJsonOutput = false)

    {

        global $routeConfig;

        try {

            //If code is empty or data is empty don't send any response.

            if (!empty($code)) {

                $jsonArr = array(

                    'success' => true,

                    'message' => array(

                        'id' => $code,

                        'description' => vsprintf(\Illuminate\Support\Facades\Lang::get("api.$code"), $bindUser)),

                    'data' => $data,

                    'timestamp' => time()

                );

                return $wantJsonOutput ? json_encode($jsonArr) : $jsonArr;

            } else {

                return;

            }

        } catch (\Exception $e) {

            $return = array(

                'status' => false,

                'message' => array(

                    'id' => 100,

                    'description' => 'file- ' . $e->getFile() . ' Description- ' . $e->getMessage() . ' Line- ' . $e->getLine()

                ),

                'data' => (object)array(),

                'timestamp' => time(),

                'version' => isset($routeConfig['route']['version']) ? $routeConfig['route']['version'] : ''

            );

            return $wantJsonOutput ? json_encode($return, JSON_NUMERIC_CHECK) : $return;

        }

    }



    /**

     * Function will

     *   - return Json error response to the User

     *

     * @param $code

     * @param array $data

     * @param array $bindUser

     * @param bool $wantJsonOutput

     * @param array $bindSystem

     * @param null $strMessage

     * @return array|string

     */

    public static function error($code, $data = array(), $bindUser = array(), $wantJsonOutput = false, $bindSystem = array(), $strMessage = null)

    {

        global $routeConfig;

        try {

            //If code is empty or data is empty don't send any response.

            if (!empty($code)) {

                //Send Email notifications to the user about the Errors

                global $globalConfig, $appConfig;



                $description = vsprintf(\Illuminate\Support\Facades\Lang::get("api.$code"), $bindUser);

                if ($globalConfig['errorLogging'] == true && in_array($code, $globalConfig['error']['codes'])) {



                    global $appConn;



                    // Set Mongo Client

                    if (false == valObj($appConn['mongo'], 'Jenssegers\Mongodb\Connection')) {

                        $appConn['mongo'] = \Illuminate\Support\Facades\DB::connection('mongodb');

                    }

                    $timestampBefore = LARAVEL_START - (24 * 60 * 60);



                    $error['msg'] = $bindUser;



                    $input = \Illuminate\Support\Facades\Input::all();

                    if (empty($input)) {

                        $input = \Illuminate\Support\Facades\Input::json()->all();

                    };



                    $strRequestedUrl = \Illuminate\Support\Facades\Request::url();

                    $error['requestInfo'] = array(

                        'Request Url ' => $strRequestedUrl,

                        'Request Method ' => \Illuminate\Support\Facades\Request::method(),

                        'Request Parameters ' => "<code style='background-color: #eee;

                                                        font-family: Consolas,Menlo,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,sans-serif;

                                                        font-size: 13px;

                                                        margin-bottom: 1em;

                                                        max-height: 600px;

                                                        overflow: auto;

                                                        padding: 5px;

                                                        width: auto;'>" . json_encode($input) . "</code>",

                        'Error Code' => $code,

                        'Error Message' => $strMessage,

                        'Duration' => (microtime(true) - LARAVEL_START) . ' seconds'

                    );



                    $error['completeTrace'] = $bindSystem;



                    $dataPoints = array(

                        'receiver' => 'Team',

                        'inputs' => $error['requestInfo'],

                        'error_msg' => $bindSystem

                    );



                    $error['created_at'] = LARAVEL_START;

                    $error['api'] = $strRequestedUrl;

                    $error['error_title'] = $strMessage;

                    $error['status'] = 'NEW';



                    $find = $appConn['mongo']->collection('system_errors')

                        ->where('created_at', '>=', $timestampBefore)

                        ->where('api', '=', $error['api'])

                        ->where('error_title', '=', $strMessage)

                        ->first();



                    // If already created error then don't email and insert

                    if (false == valArr($find)) {

                        $appConn['mongo']->collection('system_errors')->insert($error);

                    }

                }



                //Send Response to the user

                $jsonArr = array(

                    'success' => false,

                    'message' => array(

                        'id' => $code,

                        'description' => $description

                    ),

                    'data' => $data,

                    'timestamp' => time(),

                    'version' => isset($routeConfig['route']['version']) ? $routeConfig['route']['version'] : ''

                );

                return $wantJsonOutput ? json_encode($jsonArr) : $jsonArr;

            } else {

                return;

            }

        } catch (\Exception $e) {

            $return = array(

                'status' => false,

                'message' => array(

                    'id' => 100,

                    'description' => 'file- ' . $e->getFile() . ' Description- ' . $e->getMessage() . ' Line- ' . $e->getLine()

                ),

                'data' => array(),

                'timestamp' => time(),

                'version' => isset($routeConfig['route']['version']) ? $routeConfig['route']['version'] : ''

            );

            return $wantJsonOutput ? json_encode($return, JSON_NUMERIC_CHECK) : $return;

        }

    }

}

