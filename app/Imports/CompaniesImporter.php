<?php

namespace App\Imports;


use App\Models\Company;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CompaniesImporter implements ToModel ,WithHeadingRow ,WithBatchInserts ,WithCustomChunkSize  ,SkipsOnError
{
    // use SkipsFailures ;
    use Importable ;
    public function model(array $row)
    {

       //   dd($row);
        if (isset($row['name'])){
            return new Company([
                'name' => $row['name'],
                'address' =>$row['address'],
                'state' => $row['state'],
                'active'     => true,
            ]);
        }else{
            return null ;
        }



    }
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.

        toastError('something went wrong please try again later','oops');
        throw($e);
    }
    public function chunkSize(): int
    {
        return 5000;
    }
    public function batchSize(): int
    {
        return 1000;
    }


//    public function rules(): array
//    {
//
////        $validate =  ->validate($row, [
////
////            //  's' => 'required',
////        ])->validate();
//
//        return [
//            'name' => ['required','unique:companies'],
//            'address' => 'nullable',
//            'state' => 'nullable',
//            // Can also use callback validation rules
////            '0' => function($attribute, $value, $onFailure) {
////                if ($value !== 'Patrick Brouwers') {
////                    $onFailure('Name is not Patrick Brouwers');
////                }
////            }
//        ];
//    }
}
