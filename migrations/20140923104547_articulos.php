<?php

use Phinx\Migration\AbstractMigration;

class Articulos extends AbstractMigration
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
        // Artículos
        $table = $this->table('articulos');
        $table->addColumn('nombre',         'string',   array('limit' => 50))
            ->addColumn('texto',            'text',     array('default' => null, 'null' => true))
            ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
            ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
