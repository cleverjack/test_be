<?php

namespace App\Classes\validator;



use App\Classes\response\Api;



class validator

{

    public static function validate($defaultInputs = array(), $rules = array(), $onlyJson = false, $messages = array())

    {

        $inputs = array();

        if (!$onlyJson) {

            $inputs = \Illuminate\Support\Facades\Input::all();

        }

        if (empty($inputs)) {

            $inputs = \Illuminate\Support\Facades\Input::json()->all();

        }



        //merge, trim users Input and apply strip_tags if input is string

        $inputs = cleanInputData(array_merge_recursive_ex($defaultInputs, $inputs));

        //check Any rules are available

        if (empty($rules)) {

            return Api::success(6010, $inputs, array('Validation'));

        }



        $inputs = unsetKeys($inputs, array('timestamp', 'signature'));



        //Validate Inputs
        if (!empty($messages)) {
            $validator = \Illuminate\Support\Facades\Validator::make($inputs, $rules, $messages);
        }else{
            $validator = \Illuminate\Support\Facades\Validator::make($inputs, $rules);
        }



        if ($validator->fails()) {

            return Api::error(1000, array('inputs' => $inputs), array($validator->messages()->first()));

        }

        return Api::success(6010, $inputs, array('Validation'));

    }

}