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
    public function index()
    {
        $categories=Category::all();
        return  view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('category.create');
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
            'category'=>'required'
        ]);

        $create=Category::create([

            'name'=>$request->input('category'),
        ]);

        if ($create){

            Toastr::success('Category created successfull','Success',['options']);

            return redirect()->route('category.index');

        }
        else{
            Toastr::error('An error occured','Error',['options']);

            return redirect()->route('category.index')
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

        $users=DB::table('posts')->distinct()->count('user_id');

        $posts=Posts::where('category','=',$id)->get();

        $views=Posts::where('category','=',$id)->get()->sum('views');

        $category=Category::find($id);
        return  view('category.show',
            compact('category'),
            compact('users'))->with('posts',$posts)->with('views',$views);


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

        return  view('category.edit',compact('category'));
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

        $update->name=$request->input('category');

        $update->save();
        Toastr::success('Category updated successfully','Success',['options']);
        return redirect()->route('category.show',$id);

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
