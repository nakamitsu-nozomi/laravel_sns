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
}
