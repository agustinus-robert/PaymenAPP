<?php

namespace Modules\Portal\Http\Livewire;


use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
//use \App\Notifications\GlobalsNotify;
use \App\Mail\MailablePay;
use Modules\Account\Models\User;
use Modules\Admin\Models\Post;
use Modules\Portal\Models\Event;
use Livewire\WithPagination;
use DB;

class Volunteer extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';
	public $events = [];
	public $ajax = 0;

	public function mount(){
		foreach(Event::where(['deleted_at' => null, 'user_id' => \Auth::user()->id])->get() as $key => $val){
			$this->events[$val->post_id] = $val;
		}
	}



	public function render()
    {
    	$data = [
    		'event' => Post::select('post.id','post.menu_id','post.content','post.location','post.image')->leftJoin('post_has_category', function($join){
    			$join->on('post.id', '=', 'post_has_category.post_id');
    		})->where(['post.menu_id' => 1811038194284839, 'post_has_category.tags_id' => 1811731122059639,'post.deleted_at' => null])->paginate(3)
    	];

        return view('portal::livewire.volunteer', $data);
    }
}
