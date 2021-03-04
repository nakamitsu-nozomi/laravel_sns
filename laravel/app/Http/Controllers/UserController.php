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
        $articles = $user->articles->sortByDesc("created_at");
        return view("users.show", ["user" => $user, "articles" => $articles]);
    }
    public function likes(String $name)
    {
        $user = User::where("name", $name)->first();
        $articles = $user->likes->sortByDesc("created_at");
        return view("users.likes", ["user" => $user, "articles" => $articles]);
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
    // フォロー一覧を表示
    public function followings(string $name)
    {
        $user = User::where("name", $name)->first();
        $followings = $user->followings->sortByDesc("created_at");
        return view("users.followings", ["user" => $user, "followings" => $followings]);
    }

    // フォロワーー一覧を表示
    public function followers(string $name)
    {
        $user = User::where("name", $name)->first();
        $followers = $user->followers->sortByDesc("created_at");
        return view("users.followers", ["user" => $user, "followers" => $followers]);
    }
}
