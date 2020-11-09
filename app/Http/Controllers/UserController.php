<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model,Request  $request)
    {
        if ($request->ajax()){
            if ($request->status){
                $data=User::where('account_type','=','user')
                    ->where('status','=',$request->status)
                    ->get();
            }
            else{
                $data=User::where('account_type','=','user')->get();
            }

            return  datatables()->of($data)->make(true);
        }
        $statuses=DB::table('users')
            ->select('users.status')
        ->groupBy('users.status')->get();

        return view('users.index', compact('statuses'));
    }
    public function admin(User $model)
    {
        $users=User::where('account_type','=','admin')->get();
        return view('users.admin', compact('users'));
    }
    public  function make_admin($id){
        $user=User::find($id);
        $user->account_type='admin';
        $user->save();
        Toastr::success('Admin Created successfully',
            'Success', ['options']);

        return redirect()->route('user.index');


    }

    public  function  suspend_Admin($id){
        $user=User::find($id);
        $user->account_type='user';
        $user->save();
        Toastr::success('Admin removed successfully',
            'Success', ['options']);

        return redirect()->route('user.index');
    }

    public  function suspend($id){
        $user=User::find($id);
        $user->status='inactive';
        $user->save();

        Toastr::success('Suspended successfully',
            'Success', ['options']);

        return redirect()->route('user.index');

    }
    public  function activate($id){
        $user=User::find($id);
        $user->status='active';
        $user->save();
        Toastr::success('Activated successfully',
            'Success', ['options']);
        return redirect()->route('user.index');

    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $hasPassword = $request->get('password') ? 1 : 0;
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
