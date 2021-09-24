<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Category;
use App\Opportunity;
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
           return redirect()->route('account.index');
        }
        else{
            $accounts=Accounts::all()->count();
            $opportunities=Opportunity::all()->count();


            return view('home.home')->with('accounts',$accounts)
                ->with('opportunities',$opportunities);

        }

    }
}
