<?php
use Phinx\Migration\AbstractMigration;

class Menciones extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('menciones');
        $table->addColumn('userId', 'integer', array('limit' => 11, 'default' => null, 'null' => true));
        $table->addColumn('estadoId', 'integer', array('limit' => 11, 'default' => null, 'null' => true));
        $table->addColumn('titulo', 'string', array('limit' => 100, 'default' => null, 'null' => true));
        $table->addColumn('link', 'string', array('limit' => 500, 'default' => null, 'null' => true));
        $table->addColumn('imagen', 'string', array('limit' => 100, 'default' => null, 'null' => true));
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
