<?php

namespace stekel\LaravelUserUtils\Laravel\Console;

use Illuminate\Console\Command;

class ResetPasswords extends Command {
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stekel:userutils:resetpasswords
                            {password : The password to set for all users.}
                            ';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all user passwords to the given password (for testing purposes).';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        if (function_exists('app') && ! app()->environment('local')) {
            
            $this->error('Only run this on a development environment!');
            return;
        }
        
        $userModel = config('auth.providers.users.model');
        
        $bar = $this->output->createProgressBar($userModel::count());
        
        $userModel::chunk(200, function($users) use($bar) {
            $users->each(function($user) use($bar) {
                $user->update([
                    'password' => bcrypt($this->argument('password')),
                ]);
                
                $bar->advance();
            });
        });
        
        $bar->finish();
        
        $this->info('');
        
        $this->info('Done.');
    }
}
