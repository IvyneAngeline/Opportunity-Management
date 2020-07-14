<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Posts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{

    public  function  comments_stats(){
        $comments = Comments::select(
            DB::raw('count(*) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )
            ->orderBY('created_at','ASC')
            ->groupBy('months')
            ->get();
        return  response()->json($comments);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
         'post_id'=>'required',
            'comment'=>'required'
        ]);

        $create=Comments::create([
            'user_id'=>Auth::id(),
            'post_id'=>$request->input('post_id'),
            'comment'=>$request->input('comment')
        ]);
        if ($create){
            Posts::find($request->input('post_id'))->increment('comments');

            return redirect()->
            route('post.show',$request->
            input('post_id'))->withStatus(__('Comment shared
            successfully.'));
        }
        else{

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
