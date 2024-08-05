<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(public BookService $bookService)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get all book user
        $books = $this->bookService->getAllBook($request->user()->id);

        return new BookResource(true, "List Data Buku!", $books);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        // create book
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'user_id' => $request->user()->id
        ]);

        return new BookResource(true, 'Buku Berhasil ditambahkan!', $book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        // find book by id
        $book = $this->bookService->getBookById($request->user()->id, $id);

        // cek buku jika tidak ada
        if (!$book) return $this->bookService->checkBook($book);

        return new BookResource(true, "Buku ditemukan!", $book);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        // find book by id
        $book = $this->bookService->getBookById($request->user()->id, $id);

        // cek buku jika tidak ada
        if (!$book) return $this->bookService->checkBook($book);

        // update buku
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price
        ]);

        // return book
        return new BookResource(true, 'Buku Berhasil diupdate!', $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // find book by id
        $book = $this->bookService->getBookById($request->user()->id, $id);

        // cek buku jika tidak ada
        if (!$book) return $this->bookService->checkBook($book);

        $book->delete();

        return new BookResource(true, "Buku Berhasil Dihapus!", null);
    }
}
