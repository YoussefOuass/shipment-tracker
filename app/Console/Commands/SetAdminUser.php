<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SetAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-admin {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a user as admin by updating the is_admin column';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("User with ID {$userId} has been set as an admin.");
        return 0;
    }
}
