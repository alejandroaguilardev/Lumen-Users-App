<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 

    public function index(Request $request){

        if($request->isJson()){
            $users = User::all();
            return response()->json($users, 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function store(Request $request){

        if($request->isJson()){

            $data =$request->json()->all();

            $data = User::create([
               'name' => $data['name'],
               'username' => $data['username'],
               'email' => $data['email'],
               'api_token' => Str::random(60),
               'password' => Hash::make($data['password']),
           ]);

            return response()->json([$data], 201);
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);

    }

    public function getToken(Request $request){

        if($request->isJson()){
            try{
                $data = $request->json()->all();

                $user = User::where('username', $data['username'])->first();
                if($user && Hash::check($data['password'], $user->password)){
                    return response()->json($user, 200);
                }else{
                    return response()->json(['error' => 'No Content'], 406);
                }

            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'No Content'], 406);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }

}
