<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchText = $request->input('search', '');
        $todolist = DB::table('todolist')
            ->where('title','like', "%$searchText%")
            ->orWhere('content','like',"%$searchText%")
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json($todolist);
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
        $now = now();

        $result = DB::table('todolist')->insert([
            'title'=>$request->input('title'),
            'content'=>$request->input('content'),
            'created_at'=>$now,
            'updated_at'=>$now
        ]);

        if($result) {
            return response('sucess',200);
        }
        return response('failed',404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show(Todolist $todolist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function edit(Todolist $todolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $result = DB::table('todolist')
            ->where('id', $request->input('id'))
            ->update([
                'title'=>$request->input('title'), 
                'content'=>$request->input('content'),
                'updated_at'=>now()
            ]);

            if($result) {
                return response('success', 200);
            }
            
            return response('failed', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = DB::table('todolist')->where('id', $id)->delete();

        if($result) {
            return response('success', 200);
        }

        return response('failed', 404);
    }
}
