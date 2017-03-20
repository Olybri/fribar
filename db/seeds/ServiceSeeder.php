<?php

use Phinx\Seed\AbstractSeed;

class ServiceSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->execute("DELETE FROM service; ALTER TABLE service AUTO_INCREMENT = 1");
        
        $table = $this->table("service");
        
        $data = [
            ["bar_id" => 1, "product_id" => 1, "volume" => 250, "price" => 390],
            ["bar_id" => 1, "product_id" => 1, "volume" => 500, "price" => 690],
            ["bar_id" => 1, "product_id" => 6, "volume" => 250, "price" => 500],
            ["bar_id" => 1, "product_id" => 6, "volume" => 500, "price" => 850],
            ["bar_id" => 1, "product_id" => 7, "volume" => 250, "price" => 500],
            ["bar_id" => 1, "product_id" => 7, "volume" => 500, "price" => 850],
            ["bar_id" => 1, "product_id" => 8, "volume" => 250, "price" => 500],
            ["bar_id" => 1, "product_id" => 8, "volume" => 500, "price" => 850],
            ["bar_id" => 1, "product_id" => 9, "volume" => 250, "price" => 480],
            ["bar_id" => 1, "product_id" => 9, "volume" => 500, "price" => 750],
            ["bar_id" => 1, "product_id" => 10, "volume" => 250, "price" => 500],
            ["bar_id" => 1, "product_id" => 10, "volume" => 500, "price" => 850],
            ["bar_id" => 1, "product_id" => 11, "volume" => 250, "price" => 500],
            ["bar_id" => 1, "product_id" => 11, "volume" => 500, "price" => 850],
            
            ["bar_id" => 2, "product_id" => 1, "volume" => 300, "price" => 350],
            ["bar_id" => 2, "product_id" => 1, "volume" => 500, "price" => 550],
            ["bar_id" => 2, "product_id" => 4, "volume" => 300, "price" => 450],
            ["bar_id" => 2, "product_id" => 4, "volume" => 500, "price" => 750],
            ["bar_id" => 2, "product_id" => 5, "volume" => 300, "price" => 500],
            ["bar_id" => 2, "product_id" => 5, "volume" => 500, "price" => 800],
            ["bar_id" => 2, "product_id" => 6, "volume" => 300, "price" => 500],
            ["bar_id" => 2, "product_id" => 6, "volume" => 500, "price" => 850],
            ["bar_id" => 2, "product_id" => 7, "volume" => 300, "price" => 500],
            ["bar_id" => 2, "product_id" => 7, "volume" => 500, "price" => 850],
            ["bar_id" => 2, "product_id" => 8, "volume" => 300, "price" => 500],
            ["bar_id" => 2, "product_id" => 8, "volume" => 500, "price" => 850]];
        
        $table->insert($data);
        $table->save();
    }
}
