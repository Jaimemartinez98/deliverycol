<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatuses;

class OrderStatusSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatuses::create(
            [
                'name' => 'Solicitada'
            ]);

            OrderStatuses::create(
            [
                'name' => 'En preparación'
            ]);

            OrderStatuses::create(
            [
                'name' => 'Esperando al domiciliario'
            ]);

            OrderStatuses::create(            
            [
                'name' => 'Enviada'
            ]);

            OrderStatuses::create(            
            [
                'name' => 'Entregada'
            ]);

            OrderStatuses::create(            
            [
                'name' => 'Cancelada'
            ]);
    }
}
