<?php

namespace Modules\Portal\Http\Livewire\Datatables;

use Illuminate\Support\Facades\Auth;
use Modules\Portal\DataTables\PartnershipHistoryDatatables;
use Livewire\Component;



class PartnershipHistoryDatatable extends Component
{

    public function render(PartnershipHistoryDatatables $partnershipHistoryDatatables)
    {
        $data['trash'] = (isset($_GET['trash']) ? $_GET['trash'] : 0);
        $data['id'] = Auth::user()->id;

        return $partnershipHistoryDatatables->render('portal::livewire.datatables.partnership-history-datatable', $data);
    }
}
