<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with('roles')->get();
        
        $this->info('Liste des utilisateurs et leurs rôles :');
        $this->newLine();
        
        $users->each(function ($user) {
            $this->line("<fg=green>{$user->name}</> ({$user->email})");
            $this->line("Rôles: " . $user->roles->pluck('name')->implode(', '));
            $this->newLine();
        });
        
        return Command::SUCCESS;
    }
}
