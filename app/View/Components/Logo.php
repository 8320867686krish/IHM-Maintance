<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Logo extends Component
{
    /**
     * Create a new component instance.
     */
   public $logo1;
    public function __construct()
    {
        $user = Auth()->user();
        $currentUserRoleLevel = $user->roles->first()->level;
        if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $logo = "uploads/hazmatCompany/" . $user->hazmatCompany->logo;
        }
        if ($currentUserRoleLevel == 5) {
            $logo = "uploads/clientcompany/"/$user->clientCompany->client_image;
        }
        if ($currentUserRoleLevel == 6) {
            $logo = 'uploads/clientcompany/' . $user->shipClient->client->client_image;
        }else{
            $logo = 'assets/images/logo.png';
        }
        $this->logo1 = $logo;
      
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.logo', ['logo1' => $this->logo1]);

    }
}
