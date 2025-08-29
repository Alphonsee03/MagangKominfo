<?php
// app/Helpers/InvoiceGenerator.php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceGenerator
{
    public static function generate(): string
    {
        $date = Carbon::now()->format('Ymd'); // 20250826
        $countToday = DB::table('transaksis')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $number = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
        return "INV-{$date}-{$number}";
    }
}
