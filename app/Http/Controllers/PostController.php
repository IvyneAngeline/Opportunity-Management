<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $posts=DB::table('posts')
           ->join('users','posts.user_id',
               '=','users.id')->orderBy('posts.created_at','desc')->get();

       return  view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('posts.create');
    }

    public  function  download(){

        DB::table('posts')->increment('download');

        return redirect()->route('post.index');

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
            'title'=>'required',
            'description'=>'required',
            'category'=>'required'
        ]);

        if ($request->hasFile('file')){

            $image=$request->file('file');
            $image_name=rand().'.'.$image->getClientOriginalExtension();

            $image->move('images',$image_name);

            $post=Posts::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'asset'=>$image_name,
                'user_id'=>Auth::id(),
                'category'=>$request->input('category')
            ]);
            return redirect()->route('post.index')->withStatus(__('Post Created
            successfully.'));


        }
        else{
            $post=Posts::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'user_id'=>Auth::id(),
                'category'=>$request->input('category')

            ]);

            return redirect()->route('post.index')->withStatus(__('Post Created
            successfully.'));
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
        $post=Posts::find($id);
        return view('posts.show',compact('post'));
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
