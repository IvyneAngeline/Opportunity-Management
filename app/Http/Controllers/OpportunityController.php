<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Opportunity;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $opportunities=DB::table('opportunities')
        ->join('accounts','accounts.id','=',
            'opportunities.account_id')
        ->select('opportunities.name','opportunities.created_at','opportunities.stage as stage',
            'opportunities.amount as amount','accounts.name as account_name','accounts.address')
        ->get();

        return  view('opportunity.index')->with('opportunities',$opportunities);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts=Accounts::all();
        return  view('opportunity.create')
            ->with('accounts',$accounts);
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
            'amount'=>'required',
            'stage'=>'required',
            'account_id'=>'required'
        ]);
        $name=$request->input('name');
        $amount=$request->input('amount');
        $stage=$request->input('stage');
        $user_id=Auth::id();
        $account_id=$request->input('account_id');

        $opportunity=Opportunity::create([
            'name'=>$name,
            'amount'=>$amount,
            'stage'=>$stage,
            'user_id'=>$user_id,
            'account_id'=>$account_id
        ]);

        if ($opportunity){
            Toastr::success('Opportunity Created successfully', 'title', ['options']);
            return redirect()->route('opportunity.index');
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
        //
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
