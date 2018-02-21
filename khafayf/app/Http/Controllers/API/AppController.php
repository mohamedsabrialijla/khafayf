<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

//use App\Models\Confirmation;
//use App\Models\Token;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\ConstantController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Psy\Util\Json;
use Mockery\Exception;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use DB;

class AppController extends Controller
{
 
    // App Static


    public function message(Request $request)
    {
        //return $request->all();
        
            $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'mobile'=>'required',
            'email'=>'required|email',
            'details'=>'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = $errors->toArray();
                $message = '';
                foreach ($errors as $key => $value) {
                    $message .= $value[0] . ',';
                }
                return mainResponse(false, $message , null, 203, 'items');
            }
        //return $request->all();
        
        
        
        if(!$validator->fails())
        {
            $jobs = New Contact;
            $jobs->name = $request->name;
            $jobs->email = $request->email;
            $jobs->mobile = $request->mobile;
            $jobs->details = $request->details;
            $jobs->save();
            $message = __('errors.sucess_send'); 
            return mainResponse(true, $message , null, 200, 'items');
            
        }
    }


 public function get_setting()
    {
        //return 'asd';
        $aboutus =  Setting::find(1);
        if (count($aboutus) > 0) {
            $aboutus = $aboutus->toArray();
            $message = __('success') ;
            return mainResponse(true, $message, $aboutus, 200, 'data');
        } else {
            $aboutus = $aboutus->toArray();
            $message = __('Not Found');
            return mainResponse(false, $message, $aboutus, 203, 'data');
        }  
    }


       public function aboutus()
    {
        //return 'asd';
        $aboutus =  Page::find(1);
        if (count($aboutus) > 0) {
            $aboutus = $aboutus->toArray();
            $message = __('success') ;
            return mainResponse(true, $message, $aboutus, 200, 'data');
        } else {
            $aboutus = $aboutus->toArray();
            $message = __('Not Found');
            return mainResponse(false, $message, $aboutus, 203, 'data');
        }  
    }

     public function privacy_policy()
    {
        //return 'asd';
        $privacy_policy =  Page::find(2);
        if (count($privacy_policy) > 0) {
            $privacy_policy = $privacy_policy->toArray();
            $message = __('success') ;
            return mainResponse(true, $message, $privacy_policy, 200, 'data');
        } else {
            $privacy_policy = $privacy_policy->toArray();
            $message = __('Not Found');
            return mainResponse(false, $message, $privacy_policy, 203, 'data');
        }  
    }

     public function terms_use()
    {
        //return 'asd';
        $terms_use =  Page::find(3);
        if (count($terms_use) > 0) {
            $terms_use = $terms_use->toArray();
            $message = __('success') ;
            return mainResponse(true, $message, $terms_use, 200, 'data');
        } else {
            $terms_use = $terms_use->toArray();
            $message = __('Not Found');
            return mainResponse(false, $message, $terms_use, 203, 'data');
        }  
    }


    public function settings()
    {
        //return 'asd';
        $settings =  Setting::find(1);
        if (count($settings) > 0) {
            $settings = $settings->toArray();
            $message = __('success') ;
            return mainResponse(true, $message, $settings, 200, 'settings');
        } else {
            $settings = $settings->toArray();
            $message = __('Not Found');
            return mainResponse(false, $message, $settings, 203, 'settings');
        }  
    }






}


