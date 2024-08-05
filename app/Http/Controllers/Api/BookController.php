<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::where('user_id', $request->user()->id)->latest()->paginate(10);

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
        $book = Book::where('user_id', $request->user()->id)->where('id', $id)->first();
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
        // cari buku user yang login
        $book = Book::where('user_id', $request->user()->id)->where('id', $id)->first();

        // cek buku jika tidak ada
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan atau Anda tidak memiliki izin untuk memperbarui buku ini!'
            ], 404);
        }

        // update buku
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price
        ]);

        // return book
        return new BookResource(true, 'Buku Berhasil ditambahkan!', $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $book = Book::where('user_id', $request->user()->id)->where('id', $id)->first();
        // cek buku jika tidak ada
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan atau Anda tidak memiliki izin untuk hapus buku ini!'
            ], 404);
        }

        $book->delete();

        return new BookResource(true, "Buku Berhasil Dihapus!", null);
    }
}
