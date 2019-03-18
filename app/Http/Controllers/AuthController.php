<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup','getUsers','updateUser']]);
    }

    public function getUsers(){
        return new UserResource(User::all());
    }

    /** 
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        //$credentials = request(['email', 'password']);

        $email = $request->input('email');
        $password = $request->input('password');
        
        if (! $token = auth()->attempt(['email' => $email, 'password' => $password, 'habilitado' => 1])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(SignupRequest $request){
        User::create($request->all());
        return $this->login($request);
    }

    public function updateUser(Request $request,$id){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'rol' => 'required',
            'password_enabled'=>'required'
         ]);
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password_enabled){
            $user->password = $request->password;
        }
        $user->rol = $request->rol;
        $user->habilitado = $request->habilitado;
        $user->save();

        //return response($user)->setStatusCode(Response::HTTP_ACCEPTED);
        return response()->json($user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
