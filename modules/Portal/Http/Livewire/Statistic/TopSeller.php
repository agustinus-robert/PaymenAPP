<?php

namespace Modules\Portal\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Poz\Models\Purchase;
use Modules\Poz\Models\Sale;
use Modules\Poz\Models\ReturnGoods;
use Modules\Poz\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class TopSeller extends Component
{
    private $start_date, $end_date, $selectedTop = '';
    private $stockIn = 0, $stockOut = 0;
    public $chartLabels = [];
    public $chartStockIn = [];
    public $chartStockOut = [];

    public function mount(Request $req) {}

    public function selectedRangeTopSeller()
    {
        $now = Carbon::now();

        if ($this->selectedTop === 'currentWeek') {
            $this->start_date = $now->copy()->startOfWeek()->format('Y-m-d');
            $this->end_date = $now->copy()->endOfWeek()->format('Y-m-d');
        } elseif ($this->selectedTop === 'beforeWeek') {
            $this->start_date = $now->copy()->subWeek()->startOfWeek()->format('Y-m-d');
            $this->end_date = $now->copy()->subWeek()->endOfWeek()->format('Y-m-d');
        } elseif ($this->selectedTop === 'currentMonth') {
            $this->start_date = $now->copy()->startOfMonth()->format('Y-m-d');
            $this->end_date = $now->copy()->endOfMonth()->format('Y-m-d');
        } elseif ($this->selectedTop === 'beforeMonth') {
            $this->start_date = $now->copy()->subMonth()->startOfMonth()->format('Y-m-d');
            $this->end_date = $now->copy()->subMonth()->endOfMonth()->format('Y-m-d');
        } else {
            return;
        }

        $this->stockIn = Purchase::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->with('purchaseItems')
            ->get()
            ->pluck('purchaseItems')
            ->flatten()
            ->sum('qty');

        $this->stockOut = Sale::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->with('saleItems')
            ->get()
            ->pluck('saleItems')
            ->flatten()
            ->sum('qty');

        $products = Product::with(['purchaseItems.purchase', 'saleItems.sale'])->get();

        $productData = [];

        foreach ($products as $product) {
            $in = $product->purchaseItems
                ->filter(fn($item) => $item->purchase && $item->purchase->created_at->between($this->start_date, $this->end_date))
                ->sum('qty');

            $out = $product->saleItems
                ->filter(fn($item) => $item->sale && $item->sale->created_at->between($this->start_date, $this->end_date))
                ->sum('qty');

            if ($in > 0 || $out > 0) {
                $productData[] = [
                    'name' => $product->name,
                    'in' => $in,
                    'out' => $out,
                ];
            }
        }

        $top = collect($productData)
            ->sortByDesc('out')
            ->take(10)
            ->values();

        $this->chartLabels = $top->pluck('name')->toArray();
        $this->chartStockIn = $top->pluck('in')->toArray();
        $this->chartStockOut = $top->pluck('out')->toArray();
    }


    public function render()
    {
        return view('portal::livewire.statistic.topseller');
    }
}
