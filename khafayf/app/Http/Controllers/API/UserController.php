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
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Psy\Util\Json;
use Mockery\Exception;
use Hash;
use DB;

use Abraham\TwitterOAuth\TwitterOAuth;

use App\Models\CategoryBody;
use App\Models\Restaurants;
use App\Models\Craftname;

class UserController extends Controller
{
    
  public function getAccessToken(Request $request)
    {
        
        try {
            $url = url('/oauth/token');
            $headers = ['Accept' => 'application/json'];
            $http = new Client();
            $response = $http->post($url, [
                'headers' => $headers,
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 3,
                    'client_secret' => 'RAesX7wO4N65G2BwEijHKGVfcSMzHWu4D3Odzcfy',
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => '',
                ],
            ]);
            $data = json_decode((string)$response->getBody(), true);
            $user = User::query()->where(['email' => $request->get('email')])->first();

            $user->access_token = $data['access_token'];
//            if ($request->has('device_token')) {
//                Token::query()->create([
//                    'user_id' => $user->id,
//                    'token' => $request->get('device_token'),
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now(),
//                ]);
//            }
            $message =  (app()->getLocale() == 'ar') ? 'نجحت عملية التسجيل' : 'success';
            return mainResponse(true, $message, $user, 200, 'data');
        } catch (Exception $e) {
            return mainResponse(false, $e->getMessage(), [], $e->getCode(), 'data');
        } catch (RequestException $requestException) {
            $error=__('errors.RequestException');
            return mainResponse(false, $error, [], 203,'data');
        }
    }


  
    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = $errors->toArray();
                $message = '';
                foreach ($errors as $key => $value) {
                    $message .= $value[0] . ',';
                }
                return mainResponse(false, $message, null, 203, 'items');
            }
            $getUser = User::query()->where('email', $request->get('email'))->first();
            if (is_null($getUser)) {
                
                $error=__('errors.invalid_email');
                return mainResponse(false, $error, [], 201, 'items');
            }
            return $this->getAccessToken($request);
        } catch (Exception $e) {
            return mainResponse(false, $e->getMessage(), [], $e->getCode(), 'items');
        }
    }



    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'mobile' => 'required|min:8|unique:users',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = $errors->toArray();
                $message = '';
                foreach ($errors as $key => $value) {
                    $message .= $value[0] . ',';
                }
                return mainResponse(false, $message, null, 203, 'items');
            }

            // $profile_image = 'image/';

            // if ($request->hasFile('profile_image')) {
            //     return $request->hasFile('profile_image');
            //     $image = $request->file('profile_image');
            //     $path = $image->store('/images/user');
            //     $profile_image = $path;
            // }
            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'mobile' => $request->get('mobile'),
                'profile_image' => 'uploads/users/avatar.png',
                'password' => bcrypt($request->get('password')),
                
                // 'profile_image' => $profile_image,
            ]);

            if ($user) {
                return $this->login($request);
            }
            $error=__('errors.user_not_created');
            return mainResponse(false, $error, null, 203, 'items');
        } catch (RequestException $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'items');
        } catch (ValidationException $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'items');
        } catch (Exception $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'items');
        }
    }

    public function join_driver(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'mobile' => 'required|min:8|unique:users',
                'details' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = $errors->toArray();
                $message = '';
                foreach ($errors as $key => $value) {
                    $message .= $value[0] . ',';
                }
                return mainResponse(false, $message, null, 203, 'data');
            }

            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'mobile' => $request->get('mobile'),
                'profile_image' => 'uploads/users/avatar.png',
                'details' => $request->get('details'),
                'user_type' => 1,
                
                // 'profile_image' => $profile_image,
            ]);

            if ($user) {
                $message =  $message =  (app()->getLocale() == 'ar') ? '  نجحت عملية التسجيل للسائق انتظر الموافقة وراجع البريد الالكتروني' : 'success for driver whait approval check email';
                return mainResponse(true, $message, $user, 200, 'data');
            }
            $error=__('errors.user_not_created');
            return mainResponse(false, $error, null, 203, 'data');
        } catch (RequestException $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'data');
        } catch (ValidationException $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'data');
        } catch (Exception $e) {
            return mainResponse(false, $e->getMessage(), null, $e->getCode(), 'data');
        }
    }



//    public function sendVerificationCode(Request $request)
//    {
//        try {
//            $code = random_number(5);
//            $data['message'] = $code . ' رمز التحقق الخاص بك هو ';
//            $request->request->add($data);
//            $send = $this->sendSMS($request->get('mobile'), $data['message']);
//            if ($send['code'] && ($send['code'] == 1)) {
//                $user = User::query()->where('mobile', $request->get('mobile'))->first();
//                Confirmation::query()->create([
//                    'user_id' => $user->id,
//                    'code' => $code,
//                    'confirmed' => 0,
//                ]);
//                return mainResponse(true, 'لقد تم ارسال رمز التحقق الى رقمك', 'verification code has sent to your phone', null, 200);
//            }
//        } catch (Exception $e) {
//            return mainResponse(false, $e->getMessage(), $e->getMessage(), null, $e->getCode());
//        }
//    }

//    public function sendSMS($mobile, $bodySMS)
//    {
//        $data = "AppSid=ya7JSBtKNaqzH0AH1KyQJp5waYWN&Recipient=$mobile&Body=$bodySMS";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://api.unifonic.com/rest/Messages/Send");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_HEADER, FALSE);
//        curl_setopt($ch, CURLOPT_POST, TRUE);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
//        $response = curl_exec($ch);
//        curl_close($ch);
//        return $response;
//    }

//    public function verify(Request $request)
//    {
//        try {
//            $validator = Validator::make($request->all(), [
//                'code' => 'required',
//                'mobile' => 'required|digits:10',
//            ]);
//            if ($validator->fails()) {
//                $errors = $validator->errors();
//                $errors = $errors->toArray();
//                $message = '';
//                foreach ($errors as $key => $value) {
//                    //$message .= $value[0] . PHP_EOL;
//                    $message .= $value[0] . ',';
//                }
//                return mainResponse(false, $message, $message, null, 203);
//            }
//            $user = User::query()->where('mobile', $request->get('mobile'))->first();
//            $confirm = Confirmation::query()->where('user_id', $user->id)->orderBy('id', 'desc')->first();
//            if ((!is_null($confirm)) && ($confirm->code == $request->get('code'))) {
//                $user->verified = 1;
//                $user->save();
//                $confirm->confirmed = 1;
//                $confirm->save();
//                //return $this->login($request);
//                return mainResponse(true, "تم تأكيد رمز التحقق", 'verification code confirmed successfully', null, 200);
//            } else {
//                return mainResponse(false, "رمز التحقق الذي قمت بإدخاله غير صحيح", 'verification code does not match', null, 203);
//            }
//        } catch (Exception $e) {
//            return mainResponse(false, $e->getMessage(), $e->getMessage(), null, $e->getCode());
//        }
//    }

    public function logout(Request $request)
    {
        if (auth('api')->user()->token()->revoke()) {
            return mainResponse(true, 'logged out successfully', null, 200, 'data');
        } else {
            return mainResponse(false, 'something went wrong', null, 203, 'data');
        }
    }

    public function get_user_data()
    {
        $id = auth('api')->id();
        $user = User::query()->findOrFail($id);
        $user['access_token']= $user->createToken('mobile')->accessToken;
        return mainResponse(true, 'success', $user, 200, 'data');
    }

    // public function show($id)
    // {
    //     $user = User::query()->findOrFail($id);
    //     return response()->json($user);
    // }

    public function update(Request $request)
    {   
        
        $id = auth('api')->id();
        //return $id;
        $user = User::query()->findOrFail($id);
        $rules = [
        'name'=> 'required|min:1',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'mobile' => 'required|min:8|unique:users,mobile,'.$user->id,
        ];
        
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = $errors->toArray();
            $message = '';
            foreach ($errors as $key => $value) {
                $message .= $value[0] . ',';
            }
            return mainResponse(false, $message, null, 203, 'data');
        }
        
        
        if($request->profile_image){
        $profile_image = '';
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $path = $image->store('/uploads/users');
            $profile_image = $path;
        }
        }
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->mobile = $request->get('mobile');
        if($request->profile_image){
       $user->profile_image = $profile_image;}
       

       
        if ($user->save()) {
            $user->refresh();
            $user->toArray();
            
            $user['access_token']= $user->createToken('mobile')->accessToken;
           
            $error=__('errors.data_update');
             
            return mainResponse(true, $error, $user, 200, 'data');
        }
        
        $error=__('errors.not_update');
        return mainResponse(false, $error, null, 203, 'data');
    }

    public function reset_password(Request $request)
    {
         $id = auth('api')->id();
        $user = User::query()->findOrFail($id);
        $rules['old_password'] = 'required';
        $rules['new_password'] = 'required|min:6';
        $rules['confirm_new_password'] = 'required|same:new_password|min:6';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = $errors->toArray();
            $message = '';
            foreach ($errors as $key => $value) {
                $message .= $value[0] . ',';
            }
            return mainResponse(false, $message, null, 203, 'data');
        }
        
        
        
        if(Hash::check($request->get('old_password'), $user->password)){
            $user->password = bcrypt($request->get('new_password')) ;
        } else {
            $message = __('errors.password_same');
         return mainResponse(false, $message, null, 200, 'data');   
        }
       
        if ($user->save()) {
            $user->refresh();
            
            $error=__('errors.password_update');
            return mainResponse(true, $error, null, 200, 'data');
        }
       
        $error=__('errors.not_update');
        return mainResponse(false, $error, null, 203, 'data');


    } 
    
    
   
    

}


