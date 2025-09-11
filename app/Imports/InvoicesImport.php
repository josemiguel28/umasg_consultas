<?php

namespace App\Imports;

use App\Models\CustomerInvoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoicesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CustomerInvoice([
            'route_code' => $row['ruta'],
            'customer_code' => $row['clave'],
            'owner_name' => $row['propietario'],
            'address' => $row['direccion'],
            'category' => $row['categoria'],
            'status' => $row['estado'],
            'has_meter' => false,
            'meter_code' => $row['medidor'],
            'month_billed' => $row['m3facturado'],
            'balance_water' => $row['saldoagua'],
            'balance_sewer' => $row['saldoalca'],
            'balance_other' => $row['saldootro'],
        ]);
    }


    public function headingRow(): int
    {
        return 3;
    }
}
