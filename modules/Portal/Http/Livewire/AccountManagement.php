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
use Livewire\WithFileUploads;
use DB;

class AccountManagement extends Component
{
	use WithFileUploads;

	protected $listeners = [
	    'confirmed'
	];

	public $user = [];
	public $first_name;
	public $last_name;
	public $email;
	public $company;
	public $phone;
	public $site;
	public $address;
	public $photo;
	public $communication = [];

	public function mount(){
		$this->user = User::find(\Auth::user()->id);

		$this->first_name = ($this->user->getMeta('first_name') ? $this->user->getMeta('first_name') : '');
		$this->last_name = ($this->user->getMeta('last_name') ? $this->user->getMeta('last_name') : '');
		$this->email = ($this->user->email_address ? $this->user->email_address : '');
		$this->company = ($this->user->getMeta('company') ? $this->user->getMeta('company') : '');
		$this->phone = ($this->user->getMeta('phone') ? $this->user->getMeta('phone') : '');
		$this->site = ($this->user->getMeta('site') ? $this->user->getMeta('site') : '');
		$this->address = ($this->user->getMeta('address') ? $this->user->getMeta('address') : '');
		$this->photo = ($this->user->getMeta('photo') ? $this->user->getMeta('photo') : '');
		if(!empty($this->user->getMeta('roles'))){
			$role_explode = explode('|', $this->user->getMeta('roles'));
			foreach($role_explode as $key => $val){
				$this->communication[$val] = true;
			}
		}
	}

	public function submitForm(){
		$user = User::find(\Auth::user()->id);
		$roles = '';
		if(count($this->communication) > 0){
			foreach($this->communication as $key => $val){
				$roles .= $key.'|';
			}


			$roles = rtrim($roles, '|');
		}

		$location = 'image_posting/'.Auth::user()->id.'/'.uniqid();
		$user->setMeta('first_name', $this->first_name);
		$user->setMeta('last_name', $this->last_name);
		$user->setMeta('company', $this->company);
		$user->setMeta('phone', $this->phone);
		$user->setMeta('site', $this->site);
		$user->setMeta('address', $this->address);
		$user->setMeta('photo', !empty($this->photo->getFilename()) ? $location.'/'.$this->photo->getFilename() : '');
		$user->setMeta('roles', !empty($roles) ? $roles : '');

		// $arr = [
		// 	'first_name' => $this->first_name,
		//     'last_name' => $this->last_name,
		//     'company' => $this->company,
		//     'phone' => $this->phone,
		//     'site' => $this->site,
		//     'address' => $this->address,
		//     'photo' => !empty($this->photo) ? $location.'/'.$this->photo->getFilename() : '',
		//     'roles' => !empty($roles) ? $roles : ''
		// ];

		// dd($arr);
		// $user->setMeta([
		//     'first_name' => $this->first_name,
		//     'last_name' => $this->last_name,
		//     'company' => $this->company,
		//     'phone' => $this->phone,
		//     'site' => $this->site,
		//     'address' => $this->address,
		//     'photo' => !empty($this->photo) ? $location.'/'.$this->photo->getFilename() : '',
		//     'roles' => !empty($roles) ? $roles : ''
		// ]);

        if(!empty($this->photo)){
            $this->photo->storeAs($location, $this->photo->getFilename(), 'public');
        }

		$user->save();

		$this->flash('success', 'Data berhasil disimpan', [
	        'position' => 'center',
	        'timer' => 3000
         ], request()->header('Referer'));

		//$user->setMeta('first_name', $this->first_name);

	}

	public function render(){
		return view('portal::livewire.account-management');
	}
}
