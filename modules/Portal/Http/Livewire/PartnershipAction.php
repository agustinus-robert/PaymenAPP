<?php

namespace Modules\Portal\Http\Livewire;


use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
//use \App\Notifications\GlobalsNotify;
use \App\Mail\MailablePay;
use Modules\Account\Models\User;
use Modules\Admin\Models\Partnership;
use Illuminate\Support\Facades\Auth;
use DB;

class PartnershipAction extends Component
{
	protected $listeners = [
	    'confirmed'
	];

	public function mount(){

	}

	public function submission(){
		$cek = Partnership::where('user_id', Auth::user()->id)->latest('id')->first();
		if(isset($cek->id) && isset($cek->status) && $cek->status == 2 || isset($cek->id) && isset($cek->status) && $cek->status == 3){
			$this->alert('question', 'Apakah anda ingin mengajukan lagi untuk menjadi partnership?', [
			'position' => 'center',
		    'showConfirmButton' => true,
		    'showCancelButton' => true,
		    'confirmButtonText' => 'Ya',
		    'onConfirmed' => 'confirmed'
		]);
		} else {
			$this->alert('question', 'Apakah anda ingin mengajukan diri menjadi partnership?', [
				'position' => 'center',
			    'showConfirmButton' => true,
			    'showCancelButton' => true,
			    'confirmButtonText' => 'Ya',
			    'onConfirmed' => 'confirmed'
			]);
		}
	}

	public function confirmed()
	{
	    $partner = new Partnership();
		$partner->user_id = Auth::user()->id;
		$partner->status = 1;
		$partner->save();

		$this->alert('info', 'Status Partnership sedang pada masa pengajuan', [
 		   'position' => 'center'
		]);

		$this->mount();
	}

	public function render(){
		$data['partnership_status'] = Partnership::where('user_id', Auth::user()->id)->latest('id')->first();
		return view('portal::livewire.partnership', $data);
	}
}
