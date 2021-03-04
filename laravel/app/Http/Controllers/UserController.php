<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PhpParser\Node\Expr\Cast\String_;

class UserController extends Controller
{
    public function show(String $name)
    {
        $user = User::where("name", $name)->first();
        return view("users.show", ["user" => $user]);
    }
    // followメソッド
    public function follow(Request $request, String $name)
    {
        $user = User::where("name", $name)->first();
        if ($user->id === $request->user()->id) {
            return abort("404", 'Cannot follow yourself.');
        }
        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);
        return ["name" => $name];
    }
    // follow外すメソッド
    public function unfollow(Request $request, String $name)
    {
        $user = User::where("name", $name)->first();
        if ($user->id === $request->user()->id) {
            return abort("404", 'Cannot follow yourself.');
        }
        $request->user()->followings()->detach($user);
        return ["name" => $name];
    }
}
