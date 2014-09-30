<?php

use Phinx\Migration\AbstractMigration;

class UsersUbicacion extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('comunidadId',    'integer',  array('after' => 'ubicacion', 'limit' => 11, 'default' => 0, 'null' => true))
            ->addColumn('long',             'text',     array('after' => 'comunidadId', 'null' => true))
            ->addColumn('lat',              'text',     array('after' => 'long', 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
