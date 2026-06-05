<?php

namespace Modules\Portal\Http\Livewire\Statistic;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Modules\Poz\Models\Purchase;
use Modules\Poz\Models\Sale;
use Modules\Poz\Models\ReturnGoods;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class Overview extends Component
{
    public $start_date = '', $end_date = '', $selectedRange = '';
    public $purchase = 0, $sale = 0, $retur = 0, $revenue = 0;

    public function mount(Request $req)
    {
        $now = Carbon::now();
        $this->start_date = $now->copy()->startOfWeek()->format('Y-m-d');
        $this->end_date = $now->copy()->endOfWeek()->format('Y-m-d');

        $this->purchase = Purchase::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->sale = Sale::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->retur = ReturnGoods::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->revenue = ($this->sale - $this->purchase);
    }

    public function dateRange()
    {
        $now = Carbon::now();

        switch ($this->selectedRange) {
            case 'currentWeek':
                $this->start_date = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->end_date = $now->copy()->endOfWeek()->format('Y-m-d');
                break;

            case 'beforeWeek':
                $this->start_date = $now->copy()->subWeek()->startOfWeek()->format('Y-m-d');
                $this->end_date = $now->copy()->subWeek()->endOfWeek()->format('Y-m-d');
                break;

            case 'currentMonth':
                $this->start_date = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->end_date = $now->copy()->endOfMonth()->format('Y-m-d');
                break;

            case 'beforeMonth':
                $this->start_date = $now->copy()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->end_date = $now->copy()->subMonth()->endOfMonth()->format('Y-m-d');
                break;

            default:
                $this->start_date = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->end_date = $now->copy()->endOfWeek()->format('Y-m-d');
        }

        $this->purchase = Purchase::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->sale = Sale::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->retur = ReturnGoods::whereBetween('created_at', [$this->start_date, $this->end_date])->sum('grand_total');
        $this->revenue = ($this->sale - $this->purchase);
    }

    public function render()
    {
        return view('portal::livewire.statistic.overview');
    }
}
