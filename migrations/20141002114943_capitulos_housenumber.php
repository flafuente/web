<?php

use Phinx\Migration\AbstractMigration;

class CapitulosHousenumber extends AbstractMigration
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
        $table = $this->table('capitulos');
        $table->addColumn('entradaId',    'integer',  array('after' => 'estadoId', 'limit' => 11, 'default' => 0, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
