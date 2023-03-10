<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Auth;

use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        try {
            $transaction            = new Transaction;
            $transaction->user_id   =   Auth::user()->id;
            $transaction->date      =   $request->date;
            $transaction->title     =   $request->title;
            $transaction->type      =   $request->type;
            $transaction->total     =   $request->total;
            $transaction->save();

            return response()->json(['messages' => 'Transaksi Berhasil Disimpan']);
        } catch (\Throwable $th) {
            return response()->json(['messages' => 'Transaksi Gagal Disimpan']);
        }
    }
}
