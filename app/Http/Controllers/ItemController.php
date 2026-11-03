<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            if ($status === 'low_stock') {
                $query->whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0);
            } elseif ($status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            } elseif ($status === 'in_stock') {
                $query->whereColumn('stock', '>', 'min_stock');
            }
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $nextSku = 'STK-' . strtoupper(Str::random(6));

        return view('items.create', compact('categories', 'nextSku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'sku'           => 'required|string|max:50|unique:items,sku',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'unit'          => 'required|string|max:20',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($validated);

        if ($item->stock > 0) {
            $item->stockMovements()->create([
                'user_id'          => auth()->id(),
                'type'             => 'in',
                'quantity'         => $item->stock,
                'reference_number' => 'INITIAL-STOCK',
                'notes'            => 'Pencatatan persediaan awal saat pendaftaran item.',
            ]);
        }

        return redirect()->route('items.index')->with('success', "Item {$item->name} berhasil ditambahkan ke dalam sistem.");
    }

    public function show(Item $item)
    {
        $item->load(['category', 'stockMovements.user']);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'sku'           => 'required|string|max:50|unique:items,sku,' . $item->id,
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'unit'          => 'required|string|max:20',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock'     => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('items.show', $item)->with('success', "Data spesifikasi {$item->name} berhasil diperbarui.");
    }

    public function destroy(Item $item)
    {
        $name = $item->name;
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return redirect()->route('items.index')->with('success', "Item {$name} telah dihapus dari basis data.");
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'stockflow_inventory_' . date('Y-m-d_His') . '.csv';
        $items = Item::with('category')->orderBy('name')->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['ID', 'SKU', 'Nama Barang', 'Kategori', 'Satuan', 'Harga Beli (Rp)', 'Harga Jual (Rp)', 'Stok', 'Batas Minimum', 'Status Stok']);

            foreach ($items as $item) {
                $status = 'Normal';
                if ($item->stock <= 0) {
                    $status = 'Habis';
                } elseif ($item->stock <= $item->min_stock) {
                    $status = 'Menipis';
                }

                fputcsv($handle, [
                    $item->id,
                    $item->sku,
                    $item->name,
                    $item->category ? $item->category->name : '-',
                    $item->unit,
                    number_format($item->cost_price, 0, ',', '.'),
                    number_format($item->selling_price, 0, ',', '.'),
                    $item->stock,
                    $item->min_stock,
                    $status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
