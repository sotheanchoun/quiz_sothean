<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Book::with(['Author'])->get();
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
            'title'=>'min:3|max:15',
            'body'=>'nullable|min:1|max:100'
        ]);

        $book = new Book();
        $book->author_id = $request->author_id;
        $book->title = $request->title;
        $book->body = $request->body;
        $book->save();

        return response()->json(["message" => "Create Book"],201);
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
        return Book::with('Author')->findOrFail($id);
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
        $request->validate([
            'title'=>'min:3|max:15',
            'body'=>'nullable|min:1|max:100'
        ]);
        $book = Book::findOrFail($id);
        $book->author_id = $request->author_id;
        $book->title = $request->title;
        $book->body = $request->body;
        $book->save();

        return response()->json(["message" => "Update Book"]);
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
        $isDeleted = Book::destroy($id);
        if($isDeleted == 1){
            return response()->json(['message' => 'deleted'],200);
        }else{
            return response()->json(['message' => 'ID NOT FOUND'],404);
        }
    }
}