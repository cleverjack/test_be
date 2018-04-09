<?php

/**
 * Created by PhpStorm.
 * User: Jay
 * Date: 6/16/2016
 * Time: 5:15 PM
 */

namespace App\Classes\admin\Company;
use App\Models\admin\CompanyBus;
use App\Classes\response\Api;
use Illuminate\Support\Facades\DB;

class Company
{
    /**
     * insert or update the company
     * @param $data
     * @return array|string
     */
    public static function saveCompany($data)
    {
        try {
            $data['updated_at'] = LARAVEL_START;
            if (!empty($data['_id'])) {
                CompanyBus::where('_id', $data['_id'])->update($data);

            } else {
                $id = new \MongoId();
                $defaultUserProperties = array(
                    '_id' => '',
                    'name' => '',
                    'owner_name' => '',
                    'contact_number' => '',
                    'address' => '',
                    'joining_date'=>'',
                    'created_at' => LARAVEL_START,
                    'updated_at' => LARAVEL_START
                );
                $userProperties = array_merge($defaultUserProperties, $data);
                $userProperties['_id'] = $id;
                $data['created_at'] = LARAVEL_START;
                DB::collection('bus_company')->insert($userProperties);
                $userProperties['id'] = $userProperties['_id']->{'$id'};
                unset($userProperties['_id']);
                return Api::success(2030, $userProperties, ['Compnay']);
            }
        } catch (\Exception $e) {
            die(exception($e));
        }
    }

    /**
     * get all the bus company available
     * @param array $wheres
     * @param array $return
     * @param int $skip
     * @param int $limit
     * @return mixed
     */
    public static function getAllBusCompany($wheres = array(), $return = array(), $skip = 0, $limit = 0)
    {
        try {
            $db = DB::collection('bus_company');
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
            return Api::success(6010, $data, array('Company fetched'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }

    /** get Bus Route Information
     * @param array $wheres
     * @param array $returnColumns
     * @return array|string
     */
    public static function getCompanyInfo($wheres = array(array()), $returnColumns = array())
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
                    $db = DB::collection('bus_company')->where($where[0], $where[1], $where[2]);

                }
            } else {
                return Api::error(1020, array('error' => 'where array'), array('where array passed'));
            }

            $data = (array)$db->first($returnColumns);
            if (empty($data)) { //token info not found
                return Api::error(5040, array(), array('Company information'));
            }
            if (isset($data['_id'])) {
                $data['id'] = $data['_id']->{'$id'};
                unset($data['_id']);
            }
            return Api::success(6010, $data, array('Company info fetched'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }
    /**
     * destroySessionToken
     * @param array $wheres
     * @return array|string
     */
    public static function deleteCompany($wheres = array(array())){
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
                    $db = DB::collection('bus_company')->where($where[0], $where[1], $where[2]);
                }
            } else {
                return Api::error(1020, array('error' => 'where array'), array('where array passed'));
            }

            $data = (array)$db->delete();
            return Api::success(6010, $data, array('Company deleted successfully'));
        } catch (\Exception $e) {
            die(exception($e));
        }
    }
}