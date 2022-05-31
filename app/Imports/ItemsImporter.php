<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Element;
use App\Models\Item;
use App\Models\Status;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ItemsImporter implements ToModel ,WithHeadingRow ,SkipsOnError
{
    use Importable ,SkipsErrors ;
    private $elements;
    private $userId;
    public function __construct()
    {
        $this->userId = auth()->id();
        $this->elements = Element::select('id','name','code')->get();
    }
    public function model(array $row)
    {
       // dd($collection);

//            Validator::make($row, [
//               // '*.name' => 'required',
//                'quantity' => 'required',
//                'cost' => 'required',
//                'element_code' => 'required',
//
//                'description' => 'nullable',
//                'unit' => 'nullable',
//                'bill_code' => 'nullable',
//
//            ])->validate();

            if (!isset($row['quantity']) || !isset($row['cost']) || !isset($row['element_code']) ){
                dd('empty');
                return null ;
            }
                $element = $this->elements->where('code' ,  trim($row['element_code']) )->first();

            if (!isset($element)) {
               // dd($this->elements->get());
                dd($row['element_code']);
                return null ;
            }
                return Item::create([
                    'name' => $element->name,
                    'quantity' => $row['quantity'],
                    'description' => $row['description'],
                    'unit' => $row['unit'] ?? 'kg',
                    'price' => $row['cost'],
                    'bill_code' => 0,
                    'element_id' => $element->id,
                    'type' => 'material',
                    'user_id' => $this->userId,
                    'inventory_id' => 2,
                ]);



    }
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
        toastr()->error('something went wrong please try again later','oops');
       // throw($e);
    }
}
