<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CheckUserRole extends Command
{
    protected $signature = 'user:role {email?}';
    protected $description = 'Check if a user is an admin or regular user';

    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            $user = \App\Models\User::where('email', $email)->first();
            if (!$user) {
                $this->error("User with email {$email} not found.");
                return 1;
            }
        } else {
            if (!Auth::check()) {
                $this->error("No user is currently logged in.");
                return 1;
            }
            $user = Auth::user();
        }

        $role = $user->is_admin ? 'Admin' : 'Regular User';
        $this->info("User: {$user->name} ({$user->email})");
        $this->info("Role: {$role}");

        return 0;
    }
} 