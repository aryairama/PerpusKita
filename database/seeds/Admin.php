<?php

use Illuminate\Database\Seeder;
use \App\User;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new User();
        $administrator->name = "AdminPKK";
        $administrator->email = "adminpkk@perpus.com";
        $administrator->password = \Hash::make("adminpkk");
        $administrator->roles = "petugas";
        $administrator->address = "Gandusari, Trenggalek, Jawa Timur";
        $administrator->phone = "085334016482";
        $administrator->gender = "L";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
        $this->command->info("Email:adminpkk@perpus.com");
        $this->command->info("Password:adminpkk");
    }
}
