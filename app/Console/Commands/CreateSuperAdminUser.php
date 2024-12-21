<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateSuperAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-super-admin {name? : The name of the super admin user} {email? : The email of the super admin user} {password? : The password of the super admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (!$name) {
            $name = text('Enter the name of the super admin user');
        }

        $email = $this->argument('email');
        if (!$email) {
            $email = text('Enter the email of the super admin user');
        }

        $password = $this->argument('password');
        if (!$password) {
            $password = password('Enter the password of the super admin user');
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Super admin user created successfully');
    }
}
