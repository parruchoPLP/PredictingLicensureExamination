<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Profile extends Component
{
    public $src;
    public $alt;
    public $name;
    public $role;

    public function __construct($src, $alt = '', $name = '', $role = '')
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->name = $name;
        $this->role = $role;
    }

    public function render()
    {
        return view('components.profile');
    }
}
