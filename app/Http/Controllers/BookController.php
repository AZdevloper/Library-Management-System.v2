<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books =  Book::with('category', 'user',)->latest()->get();
        return  new BookCollection($books);


    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $image_name);
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'collection' => $request->collection,
            'isbn' => $request->isbn,
            'image' => $image_name,
            'pagesNumber' => $request->pagesNumber,
            'emplacement' => $request->emplacement,
            'user_id' => 1,// Auth::user()->id
            'category_id' => $request->category_id,
            'status_id' => $request->status_id,
        ]);
        
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $book =  Book::with('category', 'status')->where('id', $book->id)->get();
        return  new BookCollection($book);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
