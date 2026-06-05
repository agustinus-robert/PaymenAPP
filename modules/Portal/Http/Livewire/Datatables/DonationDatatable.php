<?php

namespace Modules\Portal\Http\Livewire\Datatables;
use Illuminate\Support\Facades\Auth;
use Modules\Portal\DataTables\DonationDatatables;
use Livewire\Component;



class DonationDatatable extends Component
{

    public function render(DonationDatatables $donationDatatables)
    {
        $data['trash'] = (isset($_GET['trash']) ? $_GET['trash'] : 0);
        $data['email'] = Auth::user()->email_address;
        
        return $donationDatatables->render('portal::livewire.datatables.donation-datatable', $data);
    }
}
