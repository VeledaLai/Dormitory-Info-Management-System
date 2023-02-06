<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\AllPaymentSheet;
use App\Exports\Sheets\PaidPaymentSheet;
use App\Exports\Sheets\UnpaidPaymentSheet;

class PaymentExport implements WithMultipleSheets
{
    use Exportable;

    protected $status;

    public function __construct(String $status)
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        if($this->status == 'all'){
            $sheets[] = new AllPaymentSheet();
            $sheets[] = new PaidPaymentSheet();
            $sheets[] = new UnpaidPaymentSheet();
        }
        else if($this->status == 'pass')
            $sheets[] = new PaidPaymentSheet();
        else if($this->status == 'pending')
            $sheets[] = new UnpaidPaymentSheet();
        return $sheets;
    }
}
