<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalCategories = Category::count();
        $totalStockQty = Item::sum('stock');
        
        $totalAssetValue = Item::all()->sum(function ($item) {
            return $item->stock * (float) $item->cost_price;
        });

        $lowStockItems = Item::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->where('stock', '>', 0)
            ->get();

        $outOfStockItems = Item::with('category')
            ->where('stock', '<=', 0)
            ->get();

        $recentMovements = StockMovement::with(['item', 'user'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard', compact(
            'totalItems',
            'totalCategories',
            'totalStockQty',
            'totalAssetValue',
            'lowStockItems',
            'outOfStockItems',
            'recentMovements'
        ));
    }
}
