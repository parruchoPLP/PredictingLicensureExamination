<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

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
        try {
            $user = new User();
            $user->name = 'Dean';
            $user->username = 'collegeDean';
            $user->password = Hash::make('0123');
            $user->save();
            $this->info('Default user created successfully.');
        } catch (QueryException $e) {
            // Check if the error is due to a duplicate entry
            if ($e->errorInfo[1] == 1062) {
                $this->info('Default user already exists.');
            } else {
                // If it's another type of error, rethrow it
                throw $e;
            }
        }
    }
}