<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VerifyAdminUser extends Command
{
    protected $signature = 'admin:verify {email?}';
    protected $description = 'Verify and fix admin user status';

    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('Enter the admin email address:');
        }

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            if ($this->confirm("User not found. Would you like to create a new admin user?")) {
                $name = $this->ask('Enter admin name:');
                $password = $this->secret('Enter admin password:');

                DB::beginTransaction();
                try {
                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'is_admin' => true
                    ]);
                    DB::commit();
                    $this->info('Admin user created successfully!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->error('Failed to create admin user: ' . $e->getMessage());
                    return 1;
                }
            } else {
                return 1;
            }
        } else {
            // User exists, check admin status
            if (!$user->is_admin) {
                if ($this->confirm("User found but not an admin. Would you like to make them an admin?")) {
                    $user->is_admin = true;
                    $user->save();
                    $this->info('User has been made an admin.');
                }
            } else {
                $this->info('User is already an admin.');
            }

            // Option to reset password
            if ($this->confirm('Would you like to reset the password?')) {
                $password = $this->secret('Enter new password:');
                $user->password = Hash::make($password);
                $user->save();
                $this->info('Password has been reset.');
            }
        }

        // Display user information
        $this->table(
            ['Name', 'Email', 'Admin Status'],
            [[
                $user->name,
                $user->email,
                $user->is_admin ? 'Yes' : 'No'
            ]]
        );

        return 0;
    }
} 