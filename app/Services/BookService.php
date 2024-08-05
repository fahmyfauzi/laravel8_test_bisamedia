<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getBookById($user_id, $id)
    {
        return Book::where('user_id', $user_id)->where('id', $id)->first();
    }

    public function getAllBook($user_id)
    {
        return Book::where('user_id', $user_id)->latest()->paginate(10);
    }

    public function checkBook($book)
    {
        return response()->json([
            'success' => false,
            'message' => 'Buku tidak ditemukan atau Anda tidak memiliki izin untuk memperbarui buku ini!'
        ], 404);
    }
}
