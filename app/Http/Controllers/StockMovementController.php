<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['item.category', 'user']);

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($itemId = $request->input('item_id')) {
            $query->where('item_id', $itemId);
        }

        $movements = $query->latest()->paginate(15)->withQueryString();
        $items = Item::orderBy('name')->get();

        return view('movements.index', compact('movements', 'items'));
    }

    public function create(Request $request)
    {
        $items = Item::orderBy('name')->get();
        $selectedItemId = $request->input('item_id');

        return view('movements.create', compact('items', 'selectedItemId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'          => 'required|exists:items,id',
            'type'             => 'required|in:in,out',
            'quantity'         => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['type'] === 'out' && $item->stock < $validated['quantity']) {
            throw ValidationException::withMessages([
                'quantity' => "Stok tidak mencukupi! Stok saat ini untuk {$item->name} hanya tersisa {$item->stock} {$item->unit}.",
            ]);
        }

        DB::transaction(function () use ($validated, $item) {
            StockMovement::create([
                'item_id'          => $item->id,
                'user_id'          => auth()->id(),
                'type'             => $validated['type'],
                'quantity'         => $validated['quantity'],
                'reference_number' => $validated['reference_number'],
                'notes'            => $validated['notes'],
            ]);

            if ($validated['type'] === 'in') {
                $item->increment('stock', $validated['quantity']);
            } else {
                $item->decrement('stock', $validated['quantity']);
            }
        });

        $typeLabel = $validated['type'] === 'in' ? 'Masuk' : 'Keluar';
        return redirect()->route('movements.index')->with('success', "Transaksi barang {$typeLabel} sebanyak {$validated['quantity']} {$item->unit} berhasil dicatat!");
    }
}
