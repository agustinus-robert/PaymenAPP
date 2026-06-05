<?php

namespace Modules\Portal\Http\Livewire\Datatables;

use Illuminate\Support\Facades\Auth;
use Modules\Portal\DataTables\VolunteerDatatables;
use Livewire\Component;



class VolunteerDatatable extends Component
{

    public function render(VolunteerDatatables $volunteerDatatables)
    {
        $data['trash'] = (isset($_GET['trash']) ? $_GET['trash'] : 0);
        $data['id'] = Auth::user()->id;
        return $volunteerDatatables->render('portal::livewire.datatables.volunteer-datatable', $data);
    }
}
