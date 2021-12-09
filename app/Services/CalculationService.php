<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Invoice;
use App\Models\Status;

class CalculationService {
//    public static function cal()
//    {
//        foreach (Bill::all() as $bill){
//          self::sum($bill);
//        }
//    }

    public static function calBill(Bill $bill)
    {
       self::sumBill($bill);
    }

    private static function sumBill($bill)
    {
        $totalAmount =  $bill->payments()->sum('amount');
        if ( $totalAmount == 0  ){
            $status_id = Status::where('type','bill')->where('name','unpaid')->first()->id;
            $bill->status_id =$status_id ;
            $bill->payments()->delete();
            $bill->save();
        }elseif($totalAmount == $bill->total){
            $status_id = Status::where('type','bill')->where('name','paid')->first()->id;
            $bill->status_id =$status_id ;
            $bill->save();
        }else{
            $status_id = Status::where('type','bill')->where('name','partial')->first()->id;
            $bill->status_id =$status_id ;
            $bill->save();
        }
    }

    public static function calInvoice(Invoice $invoice)
    {
        self::sumInvoice($invoice);
    }

    private static function sumInvoice($invoice)
    {
        $totalAmount =  $invoice->revenues()->sum('amount');
        if ( $totalAmount == 0  ){
            $status_id = Status::where('type','bill')->where('name','unpaid')->first()->id;
            $invoice->status_id = $status_id ;
            $invoice->revenues()->delete();
            $invoice->save();
        }elseif($totalAmount == $invoice->total){
            $status_id = Status::where('type','bill')->where('name','paid')->first()->id;
            $invoice->status_id =$status_id ;
            $invoice->save();
        }else{
            $status_id = Status::where('type','bill')->where('name','partial')->first()->id;
            $invoice->status_id =$status_id ;
            $invoice->save();
        }
    }
}
