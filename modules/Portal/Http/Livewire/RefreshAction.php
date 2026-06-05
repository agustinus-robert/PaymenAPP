<?php
namespace Modules\Portal\Http\Livewire;
use Livewire\Component;
use Modules\Portal\Models\Event;
use Modules\Admin\Models\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RefreshAction extends Component
{

    public $events;
    public $even;
    public $content_end_date;

    public function mount($event_id, $status = ''){
        foreach(Event::where(['deleted_at' => null, 'user_id' => \Auth::user()->id])->get() as $key => $val){
            $this->events[$val->post_id] = $val;
        }

        $this->content_end_date = get_content_json(Post::where('id', $event_id)->get()->first());

        $this->even = $event_id;
        if(!empty($status)){
            unset($this->events[$event_id]);
        }
    }

   public function choose_event($id){
        $event_data = Event::where('post_id', $id)->get()->first();
        if(!isset($event_data->id)){
            $insert = new Event();
            $insert->post_id = $id;
            $insert->user_id = \Auth::user()->id;
            $insert->save();

            $this->alert('success', 'Event Ditambahkan', [
                'position' => 'center'
            ]);

            $this->mount($id);
        } else {
            $event_data = Event::find($event_data->id);
            $event_data->delete();


            $this->alert('error', 'Event Dibatalkan', [
                'position' => 'center'
            ]);


            $this->mount($id, 'del');
        }
    }

    public function render(){
        return view('portal::livewire.refresh-action');
    }
}
