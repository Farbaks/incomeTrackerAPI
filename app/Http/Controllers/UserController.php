<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Login;
use App\Models\Job;
use Event;
use App\Events\ResetPassword;

class UserController extends Controller
{
    // function to sign up new users
    public function signup(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'phoneNumber' => 'required',
            'companyName' => 'required',
            'companyAddress' => 'required',
            'currency' => 'required',
            'password' => 'required',
            'deviceId' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $checkUser = User::where('email', $request->email)->first();

        if ($checkUser != "") {
            return response()->json([
                'status' => 400,
                'message' => 'Email account already exists',
                'data' => []
            ], 400);
        }

        $checkUser = User::where('phoneNumber', $request->phoneNumber)->first();

        if ($checkUser != "") {
            return response()->json([
                'status' => 400,
                'message' => 'Phone number already exists',
                'data' => []
            ], 400);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->companyName = $request->companyName;
        $user->companyAddress = $request->companyAddress;
        $user->currency = $request->currency;
        $user->password = Hash::make($request->password);

        $user->save();

        if ($request->pictureUrl) {
            $name = $user->id . ".jpg";
            $path = $request->file('pictureUrl')->storeAs('avatars', $name, 'public');
            User::find($request->id)->update([
                'pictureUrl' => asset('storage/' . $path)
            ]);
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
        return response()->json([
            'status' => 200,
            'message' => 'User account has been created',
            'apiToken' => $this->generateAPI($user->id, $request->deviceId),
            'data' => $user
        ], 200);
    }

    // Function to sign in users
    public function signin(Request $request)
    {
        // Validate request
        $data = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'deviceId' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        // Check if user email exists
        if ($user == "") {
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
            'apiToken' => $this->generateAPI($user->id, $request->deviceId),
            'data' => $user
        ], 200);
    }

    // Function to sign out users
    public function signout(Request $request)
    {
        $user = Login::where('userId', $request->userID)
            ->where('deviceId', $request->deviceID)
            ->update([
                'apiToken' => NULL
            ]);

        return response()->json([
            'status' => 200,
            'message' => 'Logout succesful',
            'data' => []
        ], 200);
    }

    // Function to check Token Validity
    public function checkToken()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Token valid',
            'data' => []
        ], 200);
    }

    public function getAllUsers()
    {
        $token = Str::random(60);
        $users = User::all();
        foreach ($users as $user) {
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
        }

        return response()->json([
            'status' => 200,
            'message' => 'User accounts have been fetched',
            'data' => $users
        ], 200);
    }

    // function to fetch one user
    public function getThisUser(Request $request)
    {
        $user = User::find($request->userID);
        if ($user == '') {
            return response()->json([
                'status' => 400,
                'message' => 'This user does not exist',
                'data' => []
            ], 400);
        }
        $user->totalTobs = Job::where('userId', $user->id)->count();
        $user->pendingJobs = Job::where('userId', $user->id)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->count();
        $user->completedJobs = Job::where('userId', $user->id)
            ->where('status', 'completed')
            ->count();
        $user->canceledJobs =  Job::where('userId', $user->id)
            ->where('status', 'cancelled')
            ->count();
        return response()->json([
            'status' => 200,
            'message' => 'User account has been fetched',
            'data' => $user
        ], 200);
    }

    // function to fetch one user
    public function getOneUser($id)
    {
        $user = User::find($id);
        if ($user == '') {
            return response()->json([
                'status' => 400,
                'message' => 'This user does not exist',
                'data' => []
            ], 400);
        }
        $user->totalTobs = Job::where('userId', $user->id)->count();
        $user->pendingJobs = Job::where('userId', $user->id)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->count();
        $user->completedJobs = Job::where('userId', $user->id)
            ->where('status', 'completed')
            ->count();
        $user->canceledJobs =  Job::where('userId', $user->id)
            ->where('status', 'cancelled')
            ->count();
        return response()->json([
            'status' => 200,
            'message' => 'User account has been fetched',
            'data' => $user
        ], 200);
    }

    // function to update user details
    public function updateUser(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'phoneNumber' => 'required',
            'companyName' => 'required',
            'companyAddress' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $checkUser = User::where('email', $request->email)->first();

        if ($checkUser != "" && $checkUser->id != $request->userID) {
            return response()->json([
                'status' => 400,
                'message' => 'Email account already exists',
                'data' => []
            ], 400);
        }

        $checkUser = User::where('phoneNumber', $request->phoneNumber)->first();

        if ($checkUser != "" && $checkUser->id != $request->userID) {
            return response()->json([
                'status' => 400,
                'message' => 'Phone number already exists',
                'data' => []
            ], 400);
        }

        User::find($request->userID)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'companyName' => $request->companyName,
            'companyAddress' => $request->companyAddress
        ]);
        $user = User::find($request->userID);
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
            'message' => 'User account has been updated',
            'data' => [
                $user
            ]
        ], 200);
    }

    // function to update user logo
    public function updateLogo(Request $request)
    {
        $data = Validator::make($request->all(), [
            'logo' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $image = $request->logo;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $name = $request->userID . ".png";
        if (Storage::put('avatars/' . $name, base64_decode($image), 'public')) {
            $url = Storage::url('avatars/' . $name);

            User::find($request->userID)->update([
                'pictureUrl' => asset($url)
            ]);
            $user = User::find($request->userID);
            $user->totalTobs = Job::where('userId', $request->userID)->count();
            $user->pendingJobs = Job::where('userId', $request->userID)
                ->where('status', '!=', 'completed')
                ->where('status', '!=', 'canceled')
                ->count();
            $user->completedJobs = Job::where('userId', $request->userID)
                ->where('status', 'completed')
                ->count();
            $user->canceledJobs =  Job::where('userId', $request->userID)
                ->where('status', 'canceled')
                ->count();
            return response()->json([
                'status' => 200,
                'message' => 'User logo has been updated',
                'data' => $user
            ], 200);
        }
        else {
            return response()->json([
                'status' => 400,
                'message' => 'User logo could not be updated',
                'data' => []
            ], 400);
        }
    }

    // function to delete user logo
    public function deleteLogo(Request $request)
    {
        // Storage::delete($request->userID . '.jpg');
        Storage::disk('public')->delete($request->userID . '.jpg');
        User::find($request->userID)->update([
            'pictureUrl' => null
        ]);
        $user = User::find($request->userID);
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
            'message' => 'Logo has been removed successfully',
            'data' => $user
        ], 200);
    }

    // function to reset password
    public function resetPassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }
        $tempPassword = Str::random(8);
        $user = User::where('email', $request->email)->first();

        if ($user == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Email does not exist',
                'data' => []
            ], 400);
        }
        $user->update([
            'password' => Hash::make($tempPassword)
        ]);
        $data = $user;
        $data->tempPassword = $tempPassword;
        event(new ResetPassword($data));
        return response()->json([
            'status' => 200,
            'message' => 'Password reset mail has been sent',
            'data' => $data
        ], 200);
    }

    // function to update user password
    public function changePassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $user = User::find($request->userID);

        // Check if password is correct
        if (!Hash::check($request->oldPassword, $user->password)) {
            // The passwords don't match...
            return response()->json([
                'status' => 400,
                'message' => 'Old password is incorrect',
                'data' => []
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->newPassword)
        ]);

        $user->totalTobs = Job::where('userId', $request->userID)->count();
        $user->pendingJobs = Job::where('userId', $request->userID)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'canceled')
            ->count();
        $user->completedJobs = Job::where('userId', $request->userID)
            ->where('status', 'completed')
            ->count();
        $user->canceledJobs =  Job::where('userId', $request->userID)
            ->where('status', 'canceled')
            ->count();
        return response()->json([
            'status' => 200,
            'message' => 'User password has been updated',
            'data' => $user
        ], 200);
    }

    // Function to generate API token
    public function generateAPI($id, $deviceId)
    {
        $token = Str::random(60);
        $note = [
            'apiToken' => $token,
            'userId' => $id,
            'deviceId' => $deviceId
        ];
        $encrypted = Crypt::encrypt($note);

        $check = Login::where('userId', $id)->where('deviceId', $deviceId)->first();
        if ($check == "") {
            $newLogin = new Login;
            $newLogin->userId = $id;
            $newLogin->apiToken = $token;
            $newLogin->deviceId = $deviceId;
            $newLogin->save();

            return $encrypted;
        } else {
            $check->update([
                'apiToken' => $token
            ]);

            return $encrypted;
        }
    }
}
