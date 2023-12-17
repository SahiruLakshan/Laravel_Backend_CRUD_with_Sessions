<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class testController extends Controller
{
    public function test(){
        
        $data = User::all();

        

        if($data=='[]'){
            return response()->json(["message"=>"There are no users"], 500);
        }

        return response()->json($data, 200);

    }

    public function add(Request $request){

        try {
            $validated = $request->validate([
                'name' => 'required|unique:users|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);

            $data = new User();
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));

            $data->save();
            return response()->json(["message" => "data insterted successfully", $data],201);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function getbyid($id){
        try {
            $data = User::find($id);
            
            if(!$data){
                return response()->json(["message" => "Not found"],404);
            }
            return response()->json(["message" => "data fetched", $data],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){

        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->put('user', $user);
            return response()->json(["message" => "Login success"],200);
        }
        
        return response()->json(["message" => "User credentials not valid",$credentials],500);

    }

    public function destroy(Request $request)
    { 
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return response()->json(["message" => "Logout success"],200);
     }
}
