<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Crud;

class crudController extends Controller
{
    public function create(Request $request){
        if(Auth::check()){
            $data = new Crud();
            $data->user_id = Auth::id();
            $data->name = $request->input('name');
            $data->description = $request->input('description');

            $data->save();
            return response()->json(["message" => "data insterted successfully", $data],201);

        }else{
            return response()->json(["message" => "Please Logging"]);

        }
    }

    public function get(){
        if(Auth::check()){
            $data = Crud::where('user_id',Auth::id())->get();
            return response()->json(["message" => "data fetched", $data],201);
        }
    }
}
