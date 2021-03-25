<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function passwords(){
    //     User::where("id", "=", 2)->update([
    //                 "password" => Hash::make("password")
    //             ]);
    //             return("updated");
    // }

    public function index(){
        return view('auth.profile');
    }
    // <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">${months[month_value]}</span></td>
    public function members(){
        $users = User::all();
        return view('members')->with("users", $users);
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            "image" => "image|max:2000|mimes:jpeg,png,jpg",
        ]);
        $inputs = $request->all();
        if ($request->file("image")) {
            $file = $request->file("image");
            $nameWithExt = $file->getClientOriginalName();
            $name = pathinfo($nameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $saveName = $name . "_" . time() . "." . $extension;
            $file->move("profiles", $saveName);
            $inputs["image"] = $saveName;

            try {
                if(Auth::user()->image !== "default.jpg"){
                    File::delete('profiles/' . Auth::user()->image);
                }
                User::where("id", "=", Auth::user()->id)->update([
                    "name" => $inputs["name"],
                    "email" => $inputs["email"],
                    "password" => Hash::make($inputs["password"]),
                    "image" => $saveName
                ]);
                return response()->json(["msg" => "Saved Successfully"]);
            } catch (QueryException $th) {
                throw $th;
            }
        } else {
            try {
                User::where("id", "=", Auth::user()->id)->update([
                    "name" => $inputs["name"],
                    "email" => $inputs["email"],
                    "password" => Hash::make($inputs["password"])
                ]);
                return response()->json(["msg" => "Saved Successfully"]);
            } catch (QueryException $th) {
                throw $th;
            }
        }
    }

    public function status(Request $request){
        
        $inputs=$request->all();
        try {
                User::where("id", "=", $inputs['id'])->update([
                    "status" => $inputs["action"]
                ]);
                return response()->json(["msg" => "Request Was Successfully"]);
            } catch (QueryException $th) {
                throw $th;
            }
    }
    // public function userstatus(Request $request){

    //     $inputs=$request->all();
    //     $user = User::findOrFail(Auth::user()->id);
        
    //     try {
    //         $userId = $user->User()->update([
    //                 "status" => "Activated"
    //             ])->id;
    //     }catch (QueryException $th) {
    //         throw $th;
    //     }
    // }
    public function resetPassword(Request $request){
        $inputs = $request->all();
        try {
            User::where("id", "=", $inputs['id'])->update([
                "password" => Hash::make("password")
            ]);
            return response()->json(["msg" => "Request Was Successfully"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
}
