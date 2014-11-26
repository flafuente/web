<?php

use Phinx\Migration\AbstractMigration;

class Locations extends AbstractMigration
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
        $table = $this->table('locations');
        $table->addColumn('langId', 'integer', array('limit' => 11, 'default' => 0, 'null' => true));
        $table->addColumn('item', 'string', array('limit' => 100));
        $table->addColumn('itemId', 'integer', array('limit' => 11));
        $table->addColumn('field', 'string', array('limit' => 100));
        $table->addColumn('location', 'text');
        $table->addColumn('dateInsert', 'datetime', array('default' => null, 'null' => true));
        $table->addColumn('dateUpdate', 'datetime', array('default' => null, 'null' => true));
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
