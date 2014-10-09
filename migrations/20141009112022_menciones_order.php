<?php
use Phinx\Migration\AbstractMigration;

class MencionesOrder extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('menciones');
        $table->addColumn('order', 'integer', array('after' => 'userId', 'default' => 0, 'null' => true));
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
