<?php

use Phinx\Seed\AbstractSeed;

class BarSeeder extends AbstractSeed
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
        $this->execute("DELETE FROM bar; ALTER TABLE bar AUTO_INCREMENT = 1");
        
        $table = $this->table("bar");
        
        $data = [
            ["name" => "Café du Belvédère"],
            ["name" => "Brasserie du Commerce"],
            ["name" => "Café Populaire"],
            ["name" => "Café de la Presse"]];
        
        $table->insert($data);
        $table->save();
    }
}
