<?php
namespace App\Traits;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;
/*
 * 200: OK. The standard success code.
 * 201: Object created (for store).
 * 204: No content. When an action was executed successfully, 
 *      but there is no content to return (invalidate token).
 * 206: Partial content. Useful when you have to return a paginated list of resources.
 * 400: Bad request. The standard option for requests that fail to pass validation.
 * 401: Unauthorized. The user needs to be authenticated.
 * 403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
 * 404: Not found. This will be returned automatically by Laravel when the resource is not found.
 * 500: Internal server error. Ideally you're not going to be explicitly returning this, 
 *      but if something unexpected breaks, this is what your user is going to receive.
 * 503: Service unavailable. Pretty self explanatory, but also another code that is not going 
 *      to be returned explicitly by the application.
 */

// API response: error or success
trait ApiResponse {
    
    /* $data: array|string
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success(string $msg=null, $data=null, int $code=200) {
        return response()->json([
            'status' => 'Success',
            'message' => $msg,
            'data' => $data
        ], $code);
    }
    
    protected function error(string $msg, int $code, $data=null) {
        return response()->json([
            'status' => 'Error',
            'message' => $msg,
            'data' => $data
        ], $code);
    }
    // api:
    protected function api_success($data, string $msg=null, int $code=200) {
        $data['status'] = 'Success';
        $data['message'] = $msg;
        return response()->json($data, $code);
    }
    // api: API with cURL: indentify user
    protected function api_user($request) {
        $userModel = Auth::user(); // try normal
        if (!$userModel) {
            $token = $request->bearerToken();
            $tokenModel = PersonalAccessToken::findToken($token);
            $userModel = User::where('id', $tokenModel->tokenable_id)->first();
        }
        return $userModel;
    }
}
