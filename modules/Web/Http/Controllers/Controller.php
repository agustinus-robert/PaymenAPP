<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use Modules\Cms\Models\CmsLiveEditorsAccess;
use Illuminate\Support\Facades\Auth;
use Modules\Web\Traits\HasSectionsTraits;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class Controller extends AppController {
    use HasSectionsTraits;
    public $canEdit = false;

    public function __construct()
    {
        $theme = Setting::where('key', 'theme')->first();
        $themeName = $theme ? $theme->value : 'payment';

        view()->composer('web::' . $themeName . '.*', function ($view) {
            $view->with('canEdit', $this->canEdit);
            $view->with('pages', request()->path());
        });
    }
}
