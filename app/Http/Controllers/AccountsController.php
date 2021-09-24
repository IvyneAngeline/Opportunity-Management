<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Opportunity;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts=Accounts::all();

        return  view('account.index')->with('accounts',$accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'name'=>'required',
            'address'=>'required'
        ]);

        $name=$request->input('name');
        $address=$request->input('address');

        $account=Accounts::create([
            'name'=>$name,
            'address'=>$address,
            'user_id'=>Auth::user()->id
        ]);
        if ($account){
            Toastr::success('Account Created successfully', 'title', ['options']);
            return redirect()->route('account.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opportunities=DB::table('opportunities')
            ->join('accounts','accounts.id','=',
                'opportunities.account_id')
            ->select('opportunities.name','accounts.id','opportunities.created_at','opportunities.stage as stage',
                'opportunities.amount as amount','accounts.name as account_name',
                'accounts.address')
            ->where('accounts.id','=',$id)
            ->get();
        return  view('account.show')
            ->with('opportunities',$opportunities);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
