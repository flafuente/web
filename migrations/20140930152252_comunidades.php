<?php

use Phinx\Migration\AbstractMigration;

class Comunidades extends AbstractMigration
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
        $table = $this->table('comunidades');
        $table->addColumn('codigo',    'string',  array('after' => 'nombre', 'limit' => 50, 'default' => null, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
