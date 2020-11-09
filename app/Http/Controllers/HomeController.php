<?php

namespace App\Http\Controllers;

use App\Category;
use App\Posts;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        if (Auth::user()->account_type=='user'){
        return redirect()->route('post.index');
        }
        else{
            $users=User::where('account_type','=','user')->count();
            $admin=User::where('account_type','=','admin')->count();
            $posts=Posts::all()->count();
            $categories=Category::all()->count();

            return view('home.home')->with('users',$users)->with('admin',$admin)
                ->with('posts',$posts)->with('categories',$categories);

        }
    }
}
