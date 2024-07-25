<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUser extends Command
{
    protected $signature = 'user:create-default';
    protected $description = 'Create a default user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $user = new User();
        $user->name = 'Dean';
        $user->username = 'collegeDean';
        $user->password = Hash::make('0123');
        $user->save();
        $this->info('Default user created successfully.');
    }
}