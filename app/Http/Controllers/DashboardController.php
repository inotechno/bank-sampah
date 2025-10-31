<?php

namespace App\Http\Controllers;

use App\Models\WasteType;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalWasteTypes' => WasteType::count(),
            'activeWasteTypes' => WasteType::where('is_active', true)->count(),
            'averagePrice' => WasteType::avg('price_per_kg'),
        ]);
    }
}

