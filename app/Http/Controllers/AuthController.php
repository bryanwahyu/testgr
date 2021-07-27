<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
class AuthController extends Controller
{    public function get_data()
    {
        $json['data']=Auth::user();
        $json['kode']=200;

        return response()->json($json);

    }
    public function login(Request $req)
    {
        if(Auth::attempt(['email' => $req->email, 'password' => $req->password]))
        {
            $json['data']=Auth::user();
            $json['token']=Auth::user()->CreateToken('taxi')->accessToken;
            $json['msg']="welcome";
            $json['code']=200;
        }
        else
        {
            $json['msg']='sorry your email and password are wrong';
            $json['code']=203;
        }

        return response()->json($json);
    }
    public function change_password(Request $req)
    {
        $req->validate([
            'old_password'=>'required',
            'new_password'=>'required'
        ]);

        //check old password
        if(Hash::check($req->old_password,Auth::user()->password)){
                Auth::user()->password=bcrypt($req->new_password);
                Auth::user()->save();

                $json['code']=200;
                $json['msg']="your password has been changed";
            }
            else{
                $json['code']=201;
                $json['msg']="Wrong password please contact you Adminstrator";
            }

        return response()->json($json);
    }
    public function change_it_self(Request $req)
    {
        $user=Auth::user();

        $user->fill($req->all());
        $user->save();

        $json['code']=200;
        $json['data']=$user;
        $json['msg']="data has been  changed";

        return response()->json($json);
    }

    public function registerAdmin(Request $request)
    {
        // check if user have no data will make an super user without login attemps
        if(User::count()!=0 && !Auth::check()){
            $json['msg']="User has been one  registered please Login first ";
            return  response()->json($json);
        }

        //validate form
        $request->validate([
            'username'=>'required|unique:users',
            'email' => 'required|unique:users|max:255',
            'first_name' => 'required',
            'last_name'=>'required',
            'phone'=>'required',
            'password'=>'required'
        ]);
        //get all request
        $input=$request->all();
        $input['password']=bcrypt($request->password);

        //create model
        $user=new User;
        $user->fill($input);
        $user->save();

        //output data
        $json['data']=$user;
        $json['code']=200;
        $json['msg']='Admin has been added';

        return response()->json($json);
    }
}

