<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPassword;
use App\Models\DoctorSpeciality;
use App\Models\User;
use App\Models\UserDoctorInformaion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        } else {
            $req_data = request()->only('email', 'password');
            if (Auth::attempt($req_data)) {
                $user = User::where('id', Auth::user()->id)->with('user_role')->first();
                $data['access_token'] = $user->createToken('accessToken')->accessToken;
                $data['user'] = $user;
                return response()->json($data, 200);
            } else {
                $data['message'] = 'user not exists!!';
                $data['data']['email'] = ['email or password incorrect'];
                $data['data']['password'] = ['email or password incorrect'];

                return response()->json($data, 401);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'user_name' => ['required', 'min:4', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'image' => ['required'],
            'contact_number' => ['required'],
            'dob' => ['required'],
            'street' => ['required'],
            'city' => ['required'],
            'zip_code' => ['required'],
            'country' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        } else {
            $data = $request->except(['password', 'password_confirmation', 'image']);
            $data['role_serial'] = 4;
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = 'uploads/users/pp-' . $user->user_name . '-' . $user->id . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                Image::make($file)->fit(200, 200)->save(public_path($path));
                $user->photo = $path;
            }
            $user->slug = $user->name . $user->id . rand(1000, 9999);
            $user->role_serial != 5 ? $user->status = 'pending' : $user->status = 'active';
            $user->save();

            Auth::login($user);
            $user = User::where('id', Auth::user()->id)->with('user_role')->first();
            $user->access_token = $user->createToken('accessToken')->accessToken;
            return response()->json($user, 200);
        }
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'logout',
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            // 'user_name' => ['required', 'min:4', 'unique:users'],
            // 'email' => ['required', 'unique:users'],
            'contact_number' => ['required'],
            // 'dob' => ['required'],
            // 'street' => ['required'],
            'city' => ['required'],
            'zip_code' => ['required'],
            'country' => ['required'],
            //
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['name', 'password']);

        if ($request->has('password') && strlen($request->password) > 0) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'err_message' => 'validation error',
                    'data' => $validator->errors(),
                ], 422);
            }
        }

        $data['password'] = Hash::make($request->password);
        $user = User::find(Auth::user()->id)->fill($data)->save();

        $data['user'] = User::where('id', Auth::user()->id)->with('user_role')->first();
        return response()->json($data, 200);
    }

    public function update_profile_pic(Request $request)
    {
        if ($request->hasFile('image')) {
            $user = User::find(Auth::user()->id);
            $file = $request->file('image');
            $path = 'uploads/users/pp-' . $user->user_name . '-' . $user->id . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            Image::make($file)->fit(200, 200)->save(public_path($path));
            $user->photo = $path;

            // $path = Storage::put('uploads', $request->file('image'));
            // $user->photo = $path;

            $user->save();
            $data['user'] = User::where('id', Auth::user()->id)->select(['photo'])->first();
            return response()->json($data, 200);
        }
    }

    public function forget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        $user->forget_token = Hash::make(uniqid(50));
        $user->save();

        return Mail::to('mshefat924@gmail.com')->send(new ForgetPassword($user->forget_token));
    }

    public function forget_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forget_token' => ['required', 'exists:users'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $temp_pass = Hash::make(uniqid(10));
        $user = User::where('forget_token', $request->forget_token)->first();
        $user->forget_token = null;
        $user->password = Hash::make($temp_pass);
        $user->save();

        return Mail::to('mshefat924@gmail.com')->send(new ForgetPassword(" your password is:  " . $temp_pass));
    }

    public function check_auth()
    {

        if (Auth::check()) {
            return response()->json(Auth::user());
        }
        return response()->json(Auth::check());
    }

    public function users()
    {
        $users = User::where('status','active')->get();
        return response()->json($users);
    }

    public function pharmacy_location()
    {
        $locations = User::where('role_serial',4)->select([
            'id',
            'lat',
            'lng',
            'photo',
            'user_name',
            'first_name',
            'last_name',
            'email',
            'contact_number',
            'street'
        ])->where('status','active')->get();

        return response()->json($locations,200);
    }

    public function doctor_location()
    {
        $locations = User::where('role_serial',3)->select([
            'id',
            'lat',
            'lng',
            'photo',
            'user_name',
            'first_name',
            'last_name',
            'email',
            'contact_number',
            'street',
            'role_serial'
        ])
        ->where('status','active')->get();

        return response()->json($locations,200);
    }

    public function doctor_schedule_info_by_date()
    {
        $date = Carbon::parse(request()->date);
        session()->put('user_appoinment_date',$date);
        $user_info = UserDoctorInformaion::where('doctor_id',Auth::user()->id)->first();
        return response()->json($user_info, 200);
    }

    public function doctor_speciality()
    {
        $specialities = DoctorSpeciality::where("status",1)->get();
        return response()->json($specialities,200);
    }

    public function specialist_doctors($designation_id)
    {
        $speciality = DoctorSpeciality::where('id',$designation_id)
                                ->where("status",1)
                                ->with([
                                    'doctors:id,role_serial,first_name,last_name,user_name,photo,lat,lng,street,zip_code,email,contact_number'
                                ])
                                ->first();
        return response()->json($speciality,200);
    }
}
