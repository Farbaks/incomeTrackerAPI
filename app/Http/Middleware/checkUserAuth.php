<?php

namespace App\Http\Middleware;

use App\Models\Login;
use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class checkUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $encrypted = $request->bearerToken();

        if(!$encrypted){
            return response()->json([
                'status' => 'error',
                'error' => [
                    'message' => 'No token sent in request'
                ]
            ], 400);
        }
        try {
            $token = decrypt($encrypted);
        } 
        catch (DecryptException $e) {
            
            return response()->json([
                'status' => 400,
                'message' => 'Not authorized to view this',
                'data' => []
            ], 400);
        }

        $count = Login::where('userId', $token['userId'])
                ->where('apiToken', $token['apiToken'])
                ->count();

        if($count != 1) {
            return response()->json([
                'status' => 400,
                'message' => 'Not authorized to carry out this action',
                'data' => []
            ], 400);
        }
        $request->userID = $token['userId'];
        $request->deviceID = $token['deviceId'];

        return $next($request);
    }
}
