<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Auth;
use File;

use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        try {
            $invoice        =   $request->invoice;
            $invoice_name   =   NULL;

            if($invoice != NULL) {
                $path = 'uploads/invoices';
                $invoice_name =   $path . '/' . round(microtime(true) * 1000) . '.' . $invoice->getClientOriginalExtension();
                $invoice->move(public_path($path), $invoice_name);
            }

            $transaction            =   new Transaction;
            $transaction->user_id   =   Auth::user()->id;
            $transaction->date      =   $request->date;
            $transaction->title     =   ucwords(strtolower($request->title));
            $transaction->type      =   $request->type;
            $transaction->total     =   $request->total;
            $transaction->invoice   =   $invoice_name;
            $transaction->save();

            return response()->json(['messages' => 'Transaksi Berhasil Disimpan']);
        } catch (\Throwable $th) {
            return response()->json(['messages' => 'Transaksi Gagal Disimpan']);
        }
    }

    public function show($id)
    {
        $transaction    =   Transaction::findOrFail($id);

        return response()->json(['data' => $transaction]);
    }

    public function update(TransactionRequest $request)
    {
        try {
            $transaction    =   Transaction::findOrFail($request->transaction_id);
            $invoice_name   =   $transaction->invoice;

            $invoice        =   $request->invoice;

            if($invoice != NULL) {
                File::delete($invoice_name);

                $path = 'uploads/invoices';
                $invoice_name =   $path . '/' . round(microtime(true) * 1000) . '.' . $invoice->getClientOriginalExtension();
                $invoice->move(public_path($path), $invoice_name);
            }

            $data = array(
                'user_id'   =>  Auth::user()->id,
                'date'      =>  $request->date,
                'title'     =>  ucwords(strtolower($request->title)),
                'type'      =>  $request->type,
                'total'     =>  $request->total,
                'invoice'   =>  $invoice_name,
            );

            Transaction::findOrFail($request->transaction_id)->update($data);

            return response()->json(['messages' => 'Transaksi Berhasil Diupdate']);
        } catch (\Throwable $th) {
            return response()->json(['messages' => 'Transaksi Gagal Diupdate']);
        }
    }

    public function delete($id)
    {
        try {
            $transaction    =   Transaction::where('id', $id);
            $check          =   $transaction->first();

            if(!$check) {
                return response()->json(['messages' => 'Transaksi Tidak Ditemukan']);
            } else {
                $transaction->delete();
                return response()->json(['messages' => 'Transaksi Berhasil dihapus']);
            }
        } catch (\Throwable $th) {
            return response()->json(['messages' => 'Transaksi Gagal dihapus']);
        }
    }
}
