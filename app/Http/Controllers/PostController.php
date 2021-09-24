<?php

namespace App\Http\Controllers;
use App\Mail\NewPostMail;
use App\User;
use App\View;
use  Brian2694\Toastr\Facades\Toastr;
use App\Category;
use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function  posts_stats(){
        $posts = Posts::select(
            DB::raw('count(*) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->orderBY('created_at','ASC')
            ->groupBy('months')
            ->get();
        return  response()->json($posts);

    }

    public  function  views_stats(){
        $posts = Posts::select(
            DB::raw('sum(views) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->orderBY('created_at','ASC')
            ->groupBy('months')
            ->get();
        return  response()->json($posts);

    }


    public  function  stats(){

        return  view('opportunity.stats');
    }
    public  function  category(){


        $categories = DB::table('opportunity')
            ->join('categories', 'categories.id',
                '=', 'opportunity.account')
            ->select('categories.name', DB::raw('COUNT(*) AS total'))
            ->groupBy('categories.name')
            ->get();

        return  response()->json($categories);

    }
    public  function  reports(Request $request){

        if ($request->ajax()){
            if ($request->category){

                $data=DB::table('opportunity')
                    ->join('categories','opportunity.account','categories.id')
                    ->join('users','opportunity.user_id','users.id')
                    ->select('users.name as user_name',
                        'users.id as user_id','opportunity.title as title',
                        'opportunity.description as description',
                        'opportunity.user_id as user_id',
                        'opportunity.id as post_id',
                        'opportunity.comments',
                        'opportunity.views',
                        'opportunity.created_at as time',
                        'opportunity.id as post_id',
                        'categories.name as account',
                        'opportunity.asset as asset',
                        'opportunity.views as post_views',
                        'opportunity.created_at as created_at','opportunity.likes as likes',
                        'opportunity.downloads as downloads','opportunity.comments as comments')
                   ->where('opportunity.account','=',$request->category)
                   ->get();

            }
            else if ($request->start){
                $start = Carbon::parse($request->start);
                $end = Carbon::parse($request->end);
                $data=DB::table('opportunity')
                    ->join('categories','opportunity.account','categories.id')
                    ->join('users','opportunity.user_id','users.id')
                    ->select('users.name as user_name',
                        'users.id as user_id','opportunity.title as title',
                        'opportunity.description as description',
                        'opportunity.user_id as user_id',
                        'opportunity.id as post_id',
                        'opportunity.comments',
                        'opportunity.views',
                        'opportunity.created_at as time',
                        'opportunity.id as post_id',
                        'categories.name as account',
                        'opportunity.asset as asset',
                        'opportunity.views as post_views',
                        'opportunity.created_at as created_at','opportunity.likes as likes',
                        'opportunity.downloads as downloads','opportunity.comments as comments')
                    ->whereDate('created_at','>=',$start)
                    ->whereDate('created_at','<=',$end)
                    ->get();



            }
            else{
                $data=DB::table('opportunity')
                    ->join('categories','opportunity.account','categories.id')
                    ->join('users','opportunity.user_id','users.id')
                    ->select('users.name as user_name',
                        'users.id as user_id','opportunity.title as title',
                        'opportunity.description as description',
                        'opportunity.user_id as user_id',
                        'opportunity.id as post_id',
                        'opportunity.comments',
                        'opportunity.views',
                        'opportunity.created_at as time',
                        'opportunity.id as post_id',
                        'categories.name as account',
                        'opportunity.asset as asset',
                        'opportunity.views as post_views',
                        'opportunity.created_at as created_at','opportunity.likes as likes',
                        'opportunity.downloads as downloads','opportunity.comments as comments')->get();
            }

            return  datatables()->of($data)->make(true);
        }
        $categories=Category::all();

        return view('opportunity.reports',compact('categories'));

    }
    public function index()
    {
        $post_count=DB::table('opportunity')
            ->distinct()->count('id');
        $users=DB::table('opportunity')->distinct()->count('user_id');
        $views=DB::table('opportunity')->sum('views');
        $categories=Category::all();


        $posts=DB::table('opportunity')
           ->join('users','opportunity.user_id',
               '=','users.id')
            ->join('categories','opportunity.account','=','categories.id')

           ->select('users.name as user_name',
           'users.id as user_id','opportunity.title as title',
               'opportunity.description as description',
               'opportunity.user_id as user_id',
               'opportunity.id as post_id',
               'opportunity.id as post_id',
               'categories.name as account',
               'opportunity.asset as asset',
           'opportunity.views as post_views',
           'opportunity.created_at as created_at','opportunity.likes as likes',
               'opportunity.downloads as downloads','opportunity.comments as comments')
           ->orderBy('opportunity.created_at','desc')->get();

       return  view('opportunity.index',
           compact('posts'))
           ->with('users',$users)
           ->with('views',$views)->with('post_count',$post_count)
           ->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return  view('opportunity.create',compact('categories'));
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
            'account'=>'required'
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
                'account'=>$request->input('account')
            ]);

            if($post){
                $title=$request->input('title');
                $description=$request->input('description');
                $users=User::all();
                foreach ($users as $user){
                    Mail::to($user->email)->send(new NewPostMail($title,$description));
                }
                Toastr::success('Post Created successfully', 'title', ['options']);
                return redirect()->route('post.index');

            }
            else{
                Toastr::error('An error occurred please try again',
                    'title', ['options']);
                return redirect()->route('post.index');
            }





        }
        else{
            $post=Posts::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'user_id'=>Auth::id(),
                'account'=>$request->input('account')

            ]);
            if($post){
                $title=$request->input('title');
                $description=$request->input('description');
                $users=User::all();
                foreach ($users as $user){
                    Mail::to($user->email)->send(new NewPostMail($title,$description));
                }
                Toastr::success('Post Created successfully',
                    'Success', ['options']);
                return redirect()->route('post.index');

            }
            else{
                Toastr::error('An error occurred please try again',
                    'An error occured', ['options']);
                return redirect()->route('post.index');
            }

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
        $post=DB::table('opportunity')
            ->join('users','opportunity.user_id',
                '=','users.id')
            ->select('users.name as user_name',
                'users.id as user_id','opportunity.title as title',
                'opportunity.description as description',
                'opportunity.id as post_id',
                'opportunity.asset as asset',
                'opportunity.created_at as created_at','opportunity.likes as likes',
                'opportunity.downloads as downloads','opportunity.comments as comments')
            ->where('opportunity.id','=',$id)->first();
        $category=Posts::find($id)->category;
        View::create([
           'user_id'=>Auth::id(),
           'post_id'=>$id,
            'account'=>$category
        ]);

        return view('opportunity.show',compact('post'),compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=Category::all();
        $post=Posts::find($id);

        return  view('opportunity.edit',compact('post'),compact('categories'));
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
        $title=$request->input('title');
        $description=$request->input('description');
        $category=$request->input('account');
        $post=Posts::find($id);
        $post->category=$category;
        $post->title=$title;
        $post->description=$description;
        $post->save();
        Toastr::success('Post updated successfully','Success',['options']);
        return redirect()->route('post.index');


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
            Toastr::success('Post deleted successfully','Success',['options']);
            return redirect()->route('post.index');
        }
        //
    }
}
