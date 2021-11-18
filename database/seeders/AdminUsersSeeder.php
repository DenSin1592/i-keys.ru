<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (AdminUser::where('username', 'admin')->count() === 0) {
            $adminUser = new AdminUser([
                'username' => 'admin', 'password' => 'diol', 'active' => true, 'allowed_ips' => ['109.195.189.149']
            ]);
            $adminUser->super = true;
            $adminUser->save();
        }

        if (AdminUser::where('username', 'olya')->count() === 0) {
            $adminUser = new AdminUser([
                'username' => 'olya', 'password' => 'olya', 'active' => true, 'allowed_ips' => ['109.195.189.149']
            ]);
            $adminUser->super = true;
            $adminUser->save();
        }
    }
}
