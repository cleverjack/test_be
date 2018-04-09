<?php

/**
 * Function to get users information from MONGODB
 * @param $strToken
 * @param bool $allDetails
 */
function getAdminUserByToken($strToken, $allDetails = false)
{
    try {
        global $appConn;

        if (0 > strlen($strToken) || '' == $strToken)
            return false;

        //Fetch user from mongoDB
        $userTokenInfo = $appConn[MONGO_DB]->collection('admin_sessions')
            ->where('_id', $strToken)
            ->first();

        //check User Token info is available in mongo DB
        if (valArr($userTokenInfo) == true) {

            //Check All details required OR not
            if ($allDetails == false) {
                return (int)$userTokenInfo['id'];
            }

            return $userTokenInfo;
        }
        return null;
    } catch (Exception $e) {
        die(exception($e));
    }
}

/**
 * Get User token info
 * @param array $wheres
 */
function getTokenInfo($wheres = array(array('token', '=', '')))
{
    global $appConn;
    try {
        $db = $appConn['mongo']->collection('users');

        foreach ($wheres as $where) {
            if (count($where) == 2) {
                $where[2] = $where[1];
                $where[1] = '=';
            }
            $db->where($where[0], $where[1], $where[2]);
        }

        $data = (array)$db->first();

        if (empty($data)) { //token info not found
            return \ApplicationBase\Facades\Api::error(5040, array('error' => 'not found'), array('User information'));
        }
        return \ApplicationBase\Facades\Api::success(6010, $data, array('Token info fetched'));
    } catch (Exception $e) {
        die(exception($e));
    }
}
