<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\BorrowModel;
use App\Models\CategoryModel;
use App\Models\InventarisModel;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HttpResponseTrait;

    public function countInventaris(){
        $totalInventarisIsReady = InventarisModel::count();
        $inventarisTotal = InventarisModel::sum('stock');
        $borrowerCount = BorrowModel::count();
        $borrowTotal = BorrowModel::sum('quantity');

        return response()->json([
            'getAllInvetaris' => $totalInventarisIsReady ?? 0,
            'inventaris' => $inventarisTotal ?? 0,
            'borrower' => $borrowerCount ?? 0,
            'borrow' => $borrowTotal ?? 0,
        ]);
    }
}
