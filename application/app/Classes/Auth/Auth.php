<?php
/**
 * Created by PhpStorm.
 * User: Jay
 * Date: 6/10/2016
 * Time: 2:12 PM
 */

namespace App\Classes\Auth;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Classes\response\Api;

class Auth
{


    public static function getUserInfo($wheres = array(array()), $returnColumns = array())
    {
        try {

            if (!empty($wheres)) {

                foreach ($wheres as $where) {

                     if (count($where) <= 1 || count($where) >= 4) {

                        return Api::error(1020, array('error' => 'where array'), array('where array passed'));
                    }

                    if (count($where) == 2) {
                        $where[2] = $where[1];
                        $where[1] = '=';
                    }

                   // $users = DB::table('users')->get();
                    $db = DB::table('users')->where($where[0], $where[1], $where[2]);

                }

            } else {

                return Api::error(1020, array('error' => 'where array'), array('where array passed'));
            }

            $data = (array)$db->first();

            if (empty($data)) { //token info not found
                return Api::error(5040, array(), array('User information'));
            }
            if (isset($data['_id'])) {
                $data['id'] = $data['_id']->{'$id'};
                unset($data['_id']);
            }
            return Api::success(6010, $data, array('Token info fetched'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }

    /**
     * Get Users from Mongo
     * @param array $wheres
     * @param array $return
     * @param int $skip
     * @param int $limit
     */
    public static function getAllUsers($wheres = array(), $return = array(), $skip = 0, $limit = 0)
    {
        try {
            $db = DB::table('users');

            foreach ($wheres as $where) {
                if (count($where) == 2) {
                    $where[2] = $where[1];
                    $where[1] = '=';
                }
                $db->where($where[0], $where[1], $where[2]);
            }
            if ($limit == 0) {
                $data = (array)$db->get($return);
            } else {
                $data = (array)$db->orderBy('user_id', 'asc')->skip($skip)->limit($limit)->get($return);
            }
            if(!empty($data)){
                foreach($data as $key => $value){
                    $data[$key]['id']=$data[$key]['_id']->{'$id'};
                    unset($data[$key]['_id']);
                }
            }
            return Api::success(6010, $data, array('Users fetched'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }

    public static function saveUser($data)
    {

        try {
            $data['updated_at'] = LARAVEL_START;

            if (!empty($data['_id'])) {
                User::where('_id', $data['_id'])->update($data);

            } else {
                $id = new \MongoId();
                $defaultUserProperties = array(
                    '_id' => '',
                    'fb_id' => '0',
                    'google_id' => '0',
                    'google_pic' => '',
                    'profile_pic' => '',
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'amount_spent' => 0,
                    'last_login_at' => LARAVEL_START,
                    'ip_address' => getClientIp(),
                    'is_password_reset' => false,
                    'is_deleted' => false,
                    'created_at' => LARAVEL_START,
                    'updated_at' => LARAVEL_START
                );
                $userProperties = array_merge($defaultUserProperties, $data);
                $userProperties['_id'] = $id;
                $data['created_at'] = LARAVEL_START;
                DB::table('users')->insert($userProperties);
                $userProperties['id'] = $userProperties['_id']->{'$id'};
                unset($userProperties['_id']);
                return Api::success(2030, $userProperties, ['User']);
            }
        } catch (\Exception $e) {
            die(exception($e));
        }
    }

    public static function destroySessionToken($wheres = array(array())){
        try {
            if (!empty($wheres)) {
                foreach ($wheres as $where) {
                    if (count($where) <= 1 || count($where) >= 4) {
                        return Api::error(1020, array('error' => 'where array'), array('where array passed'));
                    }
                    if (count($where) == 2) {
                        $where[2] = $where[1];
                        $where[1] = '=';
                    }
                    $db = DB::table('usersessions')->where($where[0], $where[1], $where[2]);
                }
            } else {
                return Api::error(1020, array('error' => 'where array'), array('where array passed'));
            }

            $data = (array)$db->delete();

            return Api::success(6010, $data, array('Token destroy successfully'));

        } catch (\Exception $e) {
            die(exception($e));
        }
    }
    public static function  getSessionToken($wheres = array(array())){
        try {
            if (!empty($wheres)) {
                foreach ($wheres as $where) {
                    if (count($where) <= 1 || count($where) >= 4) {
                        return Api::error(1020, array('error' => 'where array'), array('where array passed'));
                    }
                    if (count($where) == 2) {
                        $where[2] = $where[1];
                        $where[1] = '=';
                    }
                    $db = DB::table('usersessions')->where($where[0], $where[1], $where[2]);

                }
            } else {
                return Api::error(1020, array('error' => 'where array'), array('where array passed'));
            }

            $data = (array)$db->first();

            if (empty($data)) { //token info not found
                return Api::error(5040, array(), array('User information'));
            }
            if (isset($data['_id'])) {
                $data['id'] = $data['_id']->{'$id'};
                unset($data['_id']);
            }
            return Api::success(6010, $data, array('Token info fetched'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }


}