<?php

use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
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
        $this->execute("DELETE FROM product; ALTER TABLE product AUTO_INCREMENT = 1");
        
        $table = $this->table("product");
        
        $data = [
            ["name" => "Cardinal"],
            ["name" => "Calanda"],
            ["name" => "Calanda"],
            ["name" => "Feldschlösschen"],
            ["name" => "Brooklyn"],
            ["name" => "Grimbergen"],
            ["name" => "Guiness"],
            ["name" => "Magners"],
            ["name" => "Hoegaarden"],
            ["name" => "Leffe"],
            ["name" => "Kilkenny"]];
        
        $table->insert($data);
        $table->save();
    }
}
