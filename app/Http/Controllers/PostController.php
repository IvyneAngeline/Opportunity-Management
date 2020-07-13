<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comments;
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

    public  function  views_stats(){

    }

    public  function  stats(){
        $comments = DB::table('comments')
            ->select('comments.created_at as comment_days'
                , DB::raw('COUNT(*) AS total'))
            ->groupBy('comments.created_at')
            ->get();

        return  view('posts.stats')->with('comments',$comments);
    }
    public  function  category(){


        $categories = DB::table('posts')
            ->join('categories', 'categories.id',
                '=', 'posts.category')
            ->select('categories.name', DB::raw('COUNT(*) AS total'))
            ->groupBy('categories.name')
            ->get();

        return  response()->json($categories);

    }
    public function index()
    {
        $post_count=DB::table('posts')
            ->distinct()->count('id');
        $users=DB::table('posts')->distinct()->count('user_id');
        $views=DB::table('posts')->sum('views');


        $posts=DB::table('posts')
           ->join('users','posts.user_id',
               '=','users.id')

           ->select('users.name as user_name',
           'users.id as user_id','posts.title as title',
               'posts.description as description',
               'posts.user_id as user_id',
               'posts.id as post_id',
               'posts.id as post_id',
               'posts.category as category',
               'posts.asset as asset',
           'posts.views as post_views',
           'posts.created_at as created_at','posts.likes as likes',
               'posts.downloads as downloads','posts.comments as comments')
           ->orderBy('posts.created_at','desc')->get();

       return  view('posts.index',
           compact('posts'))
           ->with('users',$users)->with('views',$views)->with('post_count',$post_count);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return  view('posts.create',compact('categories'));
    }

    public  function  download($name){
        return response()->download(public_path('images/'.$name));
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
        $comments=DB::table('comments')
            ->join('users','comments.user_id','users.id')
        ->select('comments.id as comment_id','comments.post_id as comment_post_id'
        ,'comments.user_id as comments_user_id','comments.created_at as commented_at'
        ,'comments.comment as actual_comment','users.name as comment_name')
        ->where('post_id','=',$id)->get();
        Posts::find($id)->increment('views');
        $post=DB::table('posts')
            ->join('users','posts.user_id',
                '=','users.id')
            ->select('users.name as user_name',
                'users.id as user_id','posts.title as title',
                'posts.description as description',
                'posts.id as post_id',
                'posts.asset as asset',
                'posts.created_at as created_at','posts.likes as likes',
                'posts.downloads as downloads','posts.comments as comments')
            ->where('posts.id','=',$id)->first();

        return view('posts.show',compact('post'),compact('comments'));
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
        $delete=Posts::find($id);
        if ($delete->delete()) {
            return redirect()->route('post.index')->withStatus(__('Post deleted
            successfully.'));
        }
        //
    }
}
