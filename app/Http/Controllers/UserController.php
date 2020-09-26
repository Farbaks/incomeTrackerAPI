<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Job;

class UserController extends Controller
{
    // function to sign up new users
    public function signup(Request $request)
    {   
        $data= Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'phoneNumber'=> 'required',
            'companyName' => 'required',
            'companyAddress' => 'required',
            'password' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data'=> []
            ], 400);
        }

        $checkUser = User::where('email', $request->email)->first();

        if($checkUser != "") {
            return response()->json([
                'status' => 400,
                'message' => 'Email account already exists',
                'data'=> []
            ], 400);
        }

        $checkUser = User::where('phoneNumber', $request->phoneNumber)->first();

        if($checkUser != "") {
            return response()->json([
                'status' => 400,
                'message' => 'Phone number already exists',
                'data'=> []
            ], 400);
        }
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->companyName = $request->companyName;
        $user->companyAddress = $request->companyAddress;
        $user->password = Hash::make($request->password);

        $user->save();

        $user->totalTobs = Job::where('userId', $user->id)->count();
        $user->pendingJobs = Job::where('userId', $user->id)
                                ->where('status', '!=', 'completed')
                                ->where('status', '!=', 'canceled')
                                ->count();
        $user->completedJobs = Job::where('userId', $user->id)
                                ->where('status', 'completed')
                                ->count();
        $user->canceledJobs =  Job::where('userId', $user->id)
                                ->where('status', 'canceled')
                                ->count();
        return response()->json([
            'status' => 200,
            'message' => 'User account has been created',
            'apiToken' => $this->generateAPI($user->id),
            'data' => [
                $user
            ]
        ], 200);
    }

    // Function to sign in users
    public function signin(Request $request)
    {   
        // Validate request
        $data= Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data'=> []
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        
        // Check if user email exists
        if($user == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Email account does not exist',
                'data' => []
            ], 400);
        }

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            // The passwords don't match...
            return response()->json([
                'status' => 400,
                'message' => 'Email or password incorrect',
                'data' => []
            ], 400);
        }
        $user->totalTobs = Job::where('userId', $user->id)->count();
        $user->pendingJobs = Job::where('userId', $user->id)
                                ->where('status', '!=', 'completed')
                                ->where('status', '!=', 'canceled')
                                ->count();
        $user->completedJobs = Job::where('userId', $user->id)
                                ->where('status', 'completed')
                                ->count();
        $user->canceledJobs =  Job::where('userId', $user->id)
                                ->where('status', 'canceled')
                                ->count();
        // Generate api_token
        return response()->json([
            'status' => 200,
            'message' => 'Login succesful',
            'apiToken' => $this->generateAPI($user->id),
            'data' => [
                $user
            ]
        ], 200);


    }

    // Function to generate API token
    public function generateAPI($id) 
    {
        $token = Str::random(60);

        User::find($id)
        ->update([
            'apiToken' => $token
            ]);

        $note = [
            'apiToken' => $token,
            'id'=> $id
        ];
        $encrypted = Crypt::encrypt($note);
        return $encrypted;
    }
}
