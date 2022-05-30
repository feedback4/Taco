<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Status;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class VendorsImporter implements ToModel ,WithValidation ,WithUpserts
{
    public function uniqueBy()
    {
        return 'phone';
    }

    public function model(array $row): Vendor
    {

//        if (!isset($row['name'])) {
//            return null;
//        }


        return new Vendor([
            'name'       => $row['name'],
            'phone'      => $row['phone'],
            'email'      => $row['email'],
            'address'    => $row['address'],
            'active'     => true,
            'vat'        => $row['vat']
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'phone' => ['required','unique:vendors'],
            'email' => ['nullable','email'],
            'address' => ['required','string'],
        ];
    }


    public function customValidationMessages()
    {
        return [
            'phone.unique' => 'Correo ya esta en uso.',
        ];
    }

}
