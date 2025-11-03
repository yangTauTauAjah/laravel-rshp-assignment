<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerifyUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify-email {email : The email address of the user to verify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually verify a user\'s email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->hasVerifiedEmail()) {
            $this->info("User '{$email}' is already verified.");
            return 0;
        }
        
        $user->markEmailAsVerified();
        
        $this->info("Successfully verified email for user: {$user->nama} ({$email})");
        return 0;
    }
}
