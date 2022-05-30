<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Company;
use App\Models\Status;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientsImporter implements ToModel ,WithHeadingRow ,WithBatchInserts ,WithCustomChunkSize ,WithValidation ,SkipsOnError
{
   // use SkipsFailures ;
    private $statuses;
    private $companies;
    public function __construct()
    {
        $this->statuses = Status::where('type','client')->select('id','name');
        $this->companies = Company::select('id','name');
    }


    public function model(array $row)
    {

        $company = $this->companies->where('name',$row['company_name'])->first() ?? Company::create(['name' => $row['company_name']]);
        // dd($company);
        $status = $this->statuses->where('name',$row['status'])->first();
        //  dd($status->id);
        return new Client([
            'name' => $row['name'],
            'phone' =>$row['phone'],
            'type' =>$row['type'],
            'status_id' => $status->id,
            'company_id' => $company->id,
            'location' =>$row['location'],
            'vat' =>$row['vat'],
            'code' => $row['code'],
            'payment' =>$row['payment'],
        ]);


    }
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
        dd($e);
          toastr()->error('something went wrong please try again later','oops');
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


    public function rules(): array
    {

//        $validate =  ->validate($row, [
//
//            //  's' => 'required',
//        ])->validate();

        return [
            'name' => 'required',
            'phone' => ['required','unique:clients'],
            'status' => 'required',
            'company_name' => 'required',
            'code' => ['nullable','unique:clients'],

            // Can also use callback validation rules
//            '0' => function($attribute, $value, $onFailure) {
//                if ($value !== 'Patrick Brouwers') {
//                    $onFailure('Name is not Patrick Brouwers');
//                }
//            }
        ];
    }
}
