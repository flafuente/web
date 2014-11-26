<?php

use Phinx\Migration\AbstractMigration;

class OrdenProgramas extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('programas');
        $table->addColumn('order', 'integer', array('after' => 'id', 'limit' => 11, 'default' => 0, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
