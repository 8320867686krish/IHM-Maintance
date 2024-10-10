<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $name;
    public function __construct()
    {
        $user = Auth()->user();
        $username = $user->name;
        $name = substr($username, 0, 1);
        $this->name = $name[0];
    }
    public function render(): View
    {
        return view('layouts.guest',['name'=>$this->name]);
    }
}
