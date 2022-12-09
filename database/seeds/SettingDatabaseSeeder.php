<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add data to settings table
        Setting::setMany([
            'default_local'         =>'ar',
            'default_timezone'      =>'Africa/cairo',
            'review_enabled'        =>true,
            'auto_approve_review'   =>true,
            'supported_currencies'  =>['USD','SAR','LE'],
            'default_currency'      =>'USD',
            'store_email'           =>'abdallahabdelrahman@gmail.com',
            'search_engine'         =>'mysql',
            'local_shipping_cost'   =>0,
            'outer_shipping_cost'   =>0,
            'free_shipping_cost'    =>0,
            'translatable'          =>
            [
                'store_name'             =>'e-commerce Store',
                'free_shipping_label'    => 'Free Shipping',
                'local_shipping_label'   => 'Local Shipping',
                'outer_shipping_label'   => 'Outer Shipping',
            ],

        ]);
    }
}
