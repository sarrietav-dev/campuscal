<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin
                            {name? : The name of the admin user}
                            {email? : The email of the admin user}
                            {password? : The password of the admin user}';

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
            $name = text('Enter the name of the admin user');
        }

        $email = $this->argument('email');
        if (!$email) {
            $email = text('Enter the email of the admin user');
        }

        $password = $this->argument('password');
        if (!$password) {
            $password = password('Enter the password of the admin user');
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully');
    }
}
