<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Transaction;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $data['title']  =   'Home';

        if (request()->ajax()) {
            return datatables()->of(Transaction::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function($data) {
                    $button =   '<button type="button" id="' . $data->id . '" class="btnEdit btn btn-warning mr-1">Edit</button>';
                    $button .=   '<button type="button" id="' . $data->id . '" class="btnDelete btn btn-danger ml-1">Hapus</button>';

                    return $button;
                })->editColumn('type', function($transaction) {
                    return $transaction->type == TRUE ? '<label class="font-weight-bold text-success">Pemasukan</label>' : '<label class="font-weight-bold text-danger">Pengeluaran</label>';
                })->editColumn('date', function($transaction) {
                    return date('j M Y', strtotime($transaction->date));
                })->rawColumns(['action', 'type', 'date'])->addIndexColumn()->make(true);
        }
        return view('home', $data);
    }
}
