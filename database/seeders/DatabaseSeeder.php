<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Demo Admin',
            'email'    => 'admin@stockflow.test',
            'password' => Hash::make('password'),
        ]);

        $categories = [
            'Bahan Kemasan & Packing' => [
                'desc' => 'Karton box, lakban, plastik bubble wrap, stiker fragile, dan tali pengikat.',
                'items' => [
                    [
                        'sku' => 'PKG-BOX-001',
                        'name' => 'Karton Box Corrugated Ukuran 30x20x15 cm',
                        'description' => 'Kardus packing standar double wall untuk proteksi pengiriman barang.',
                        'unit' => 'pcs',
                        'cost_price' => 4500,
                        'selling_price' => 7000,
                        'stock' => 350,
                        'min_stock' => 50,
                    ],
                    [
                        'sku' => 'PKG-TAPE-002',
                        'name' => 'Lakban Bening Daimaru 2 Inch 100 Meter',
                        'description' => 'Isolasi bening daya rekat tinggi untuk segel kardus pengiriman.',
                        'unit' => 'roll',
                        'cost_price' => 12500,
                        'selling_price' => 17000,
                        'stock' => 85,
                        'min_stock' => 20,
                    ],
                    [
                        'sku' => 'PKG-BUBBLE-003',
                        'name' => 'Bubble Wrap Roll Tebal 50m x 125cm',
                        'description' => 'Plastik gelembung tebal hitam untuk pengemasan barang sensitif.',
                        'unit' => 'roll',
                        'cost_price' => 140000,
                        'selling_price' => 185000,
                        'stock' => 4,
                        'min_stock' => 8,
                    ],
                    [
                        'sku' => 'PKG-STRAP-004',
                        'name' => 'Tali Strapping Band Plastik PP 15mm',
                        'description' => 'Tali pengikat peti dan box pengiriman kargo berat.',
                        'unit' => 'roll',
                        'cost_price' => 95000,
                        'selling_price' => 130000,
                        'stock' => 0,
                        'min_stock' => 5,
                    ],
                ]
            ],
            'Elektronik & Perangkat Kantor' => [
                'desc' => 'Perangkat keras komputer, printer, mouse, keyboard, kabel dan barcode scanner.',
                'items' => [
                    [
                        'sku' => 'ELC-SCAN-101',
                        'name' => 'Wireless 2D Barcode & QR Scanner USB',
                        'description' => 'Scanner barcode gudang dengan docking pengisi daya tanpa kabel.',
                        'unit' => 'unit',
                        'cost_price' => 380000,
                        'selling_price' => 550000,
                        'stock' => 12,
                        'min_stock' => 3,
                    ],
                    [
                        'sku' => 'ELC-PRN-102',
                        'name' => 'Thermal Shipping Label Printer 80mm',
                        'description' => 'Printer cetak label resi dan barcode tanpa tinta.',
                        'unit' => 'unit',
                        'cost_price' => 650000,
                        'selling_price' => 890000,
                        'stock' => 6,
                        'min_stock' => 2,
                    ],
                    [
                        'sku' => 'ELC-TON-103',
                        'name' => 'Cartridge Toner HP LaserJet 85A',
                        'description' => 'Toner hitam pekat untuk cetak invoice dan surat jalan harian.',
                        'unit' => 'pcs',
                        'cost_price' => 120000,
                        'selling_price' => 165000,
                        'stock' => 3,
                        'min_stock' => 5,
                    ],
                ]
            ],
            'Alat Tulis Kantor (ATK)' => [
                'desc' => 'Kertas HVS, pulpen, map arsip, binder clip, gunting, dan spidol.',
                'items' => [
                    [
                        'sku' => 'ATK-HVS-201',
                        'name' => 'Kertas HVS PaperOne A4 75 Gsm (Rim)',
                        'description' => 'Kertas cetak dokumen laporan dan surat jalan resmi.',
                        'unit' => 'box',
                        'cost_price' => 195000,
                        'selling_price' => 240000,
                        'stock' => 24,
                        'min_stock' => 10,
                    ],
                    [
                        'sku' => 'ATK-PEN-202',
                        'name' => 'Pulpen Gel Zebra Sarasa Clip 0.5 Black',
                        'description' => 'Pulpen tanda tangan dokumen resmi dan administrasi gudang.',
                        'unit' => 'box',
                        'cost_price' => 135000,
                        'selling_price' => 165000,
                        'stock' => 18,
                        'min_stock' => 5,
                    ],
                ]
            ],
            'Perlengkapan Keselamatan & Sanitasi' => [
                'desc' => 'Sarung tangan lateks, masker medis, hairnet, dan sabun sanitasi ruangan.',
                'items' => [
                    [
                        'sku' => 'SAF-GLV-301',
                        'name' => 'Nitrile Disposable Gloves Size M (Box isi 100)',
                        'description' => 'Sarung tangan higienis non-powder untuk penanganan produk.',
                        'unit' => 'box',
                        'cost_price' => 55000,
                        'selling_price' => 75000,
                        'stock' => 45,
                        'min_stock' => 15,
                    ],
                    [
                        'sku' => 'SAF-MSK-302',
                        'name' => 'Masker Medis 3-Ply Earloop Surgical (Box 50 pcs)',
                        'description' => 'Masker proteksi debu dan partikel steril standar pabrik.',
                        'unit' => 'box',
                        'cost_price' => 18000,
                        'selling_price' => 25000,
                        'stock' => 60,
                        'min_stock' => 20,
                    ],
                ]
            ],
        ];

        foreach ($categories as $catName => $catData) {
            $category = Category::create([
                'name'        => $catName,
                'slug'        => Str::slug($catName),
                'description' => $catData['desc'],
            ]);

            foreach ($catData['items'] as $itemData) {
                $stock = $itemData['stock'];
                $item = $category->items()->create($itemData);

                if ($stock > 0) {
                    StockMovement::create([
                        'item_id'          => $item->id,
                        'user_id'          => $user->id,
                        'type'             => 'in',
                        'quantity'         => $stock,
                        'reference_number' => 'INIT-STOCK-' . rand(100, 999),
                        'notes'            => 'Pencatatan saldo persediaan awal inventaris.',
                        'created_at'       => now()->subDays(rand(5, 20)),
                    ]);
                }
            }
        }

        $items = Item::where('stock', '>', 5)->take(3)->get();
        foreach ($items as $item) {
            $outQty = rand(2, 4);
            StockMovement::create([
                'item_id'          => $item->id,
                'user_id'          => $user->id,
                'type'             => 'out',
                'quantity'         => $outQty,
                'reference_number' => 'SJ-OUT-' . rand(1000, 9999),
                'notes'            => 'Pengeluaran rutin untuk kebutuhan operasional.',
                'created_at'       => now()->subHours(rand(1, 48)),
            ]);

            $inQty = rand(5, 10);
            StockMovement::create([
                'item_id'          => $item->id,
                'user_id'          => $user->id,
                'type'             => 'in',
                'quantity'         => $inQty,
                'reference_number' => 'PO-SUPP-' . rand(1000, 9999),
                'notes'            => 'Penerimaan restock barang dari supplier terdaftar.',
                'created_at'       => now()->subHours(rand(1, 24)),
            ]);
        }
    }
}
