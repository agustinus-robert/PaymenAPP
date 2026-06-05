<?php
 
namespace App\Models\Casts\UserAgent;
 
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
 
class UserAgentCast implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get($model, $key, $value, $attributes)
    {
        $agent = new Handler();
        $agent->setUserAgent($value);
        
        return (object) [
            'is_mobile' => $agent->isMobile(),
            'is_tablet' => $agent->isTablet(),
            'is_desktop' => $agent->isDesktop(),
            'languages' => $agent->languages(),
            'platform' => $agent->platform(),
            'platform_version' => ($platform_version = $agent->version($agent->platform())),
            'browser' => $agent->browser(),
            'browser_version' => ($browser_version = $agent->version($agent->browser())),
            'full_name' => implode(' ', array_filter([$agent->platform(), $platform_version, $agent->browser(), $browser_version]))
        ];
    }
 
    /**
     * Prepare the given value for storage.
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}