<?php

namespace App\Imports;

use App\Models\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class VendorsImporter implements ToModel ,WithValidation
{

    use Importable;


    public function model(array $row)
    {
        return new Vendor([
            'name'     => $row['name'],
            'phone'     => $row['phone'],
            'email'     => $row['email'],
            'address'     => $row['address'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'phone' => ['required|unique:vendors'],
            'email' => ['nullable|email'],
            'address' => ['required|string'],
        ];
    }

}
