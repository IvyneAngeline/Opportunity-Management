<?php

namespace App\Http\Controllers;

use App\Category;
use App\Posts;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public  function  analysis(){
        $stats = DB::table('opportunity')
            ->join('categories', 'categories.id',
                '=', 'opportunity.account')
            ->select('categories.name',DB::raw('DATE(opportunity.created_at) as date'), DB::raw('COUNT(*) AS total'))
            ->groupBy('categories.name','date')
            ->orderBy('date', 'ASC')
            ->get();
        ;

        return  response()->json($stats);
    }
    public function index()
    {
        $categories=Category::all();
        return  view('account.index',compact('categories'));
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
        $request->validate([
            'account'=>'required'
        ]);

        $create=Category::create([

            'name'=>$request->input('account'),
        ]);

        if ($create){

            Toastr::success('Category created successfull','Success',['options']);

            return redirect()->route('account.index');

        }
        else{
            Toastr::error('An error occured','Error',['options']);

            return redirect()->route('account.index')
                ->withStatus(__('An error occurred.'));

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

        $users=DB::table('opportunity')->distinct()->count('user_id');

        $posts=Posts::where('account','=',$id)->get();

        $views=Posts::where('account','=',$id)->get()->sum('views');

        $category=Category::find($id);
        return  view('account.show',
            compact('category'),
            compact('users'))->with('opportunity',$posts)->with('views',$views);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category=Category::find($id);

        return  view('account.edit',compact('category'));
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
        $update=Category::find($id);

        $update->name=$request->input('account');

        $update->save();
        Toastr::success('Category updated successfully','Success',['options']);
        return redirect()->route('account.index');

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
