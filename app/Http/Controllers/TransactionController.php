<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        //$latest_transactions = Transaction::latest()->paginate(5);
        //return view('dashboard',compact('latest_transactions'));

        if(request()->ajax()){
            if(!empty($request->from_date)){
                $data = DB::table('transactions')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->get();
            } else {
                $data = DB::table('transactions')->get();
            }
            return datatables()->of($data)->make(true);
        }
        return view('dashboard');

    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_number' => 'required',
            'meter_number' => 'required',
            'receipt_number' => 'required',
            'account_type' => 'required',
            'amount' => 'required',
            'payment_date_time' => 'required',
            'status' => 'required'
        ]);

        try {
                Transaction::create([
                    "customer_number" => $request->customer_number,
                    "meter_number" => $request->meter_number,
                    "receipt_number" => $request->receipt_number,
                    "account_type" => $request->account_type,
                    "amount" => $request->amount,
                    "payment_date_time" => $request->payment_date_time,
                    "status" => 1,
                ]);
                $data = [
                    "payment_date_time" => $request->payment_date_time,
                    "receipt_number" => $request->receipt_number,
                    "meter_number" => $request->meter_number,
                    "customer_number" => $request->customer_number,
                    "account_type" => $request->account_type,
                    "amount" => $request->amount,
                    "status" => $request->status
                ];
                return "Request Successful";

        } catch (\Exception $exception) {
            if (env('APP_ENV') == "local") {
                throw  $exception;
            } else {
                return $this->error("An Error Occurred In Transaction Try Again", 401);
            }
        }
    }

    public function update(Request $request, $receipt_number)
    {
        //$transaction = Transaction::find($receipt_number);
        $transaction = Transaction::all()->where("receipt_number",$receipt_number)->first();
        $transaction->update($request->all());
        //$transaction->save();
        return $transaction;
    }
}
