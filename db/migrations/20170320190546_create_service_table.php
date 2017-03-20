<?php

use Phinx\Migration\AbstractMigration;

class CreateServiceTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table("service");
        $table->addColumn("bar_id", "integer");
        $table->addColumn("product_id", "integer");
        $table->addColumn("volume", "integer", ["comment" => "en millilitres"]);
        $table->addColumn("price", "integer", ["comment" => "en centimes"]);
        $table->addForeignKey("bar_id", "bar", "id");
        $table->addForeignKey("product_id", "product", "id");
        $table->create();
    }
}
