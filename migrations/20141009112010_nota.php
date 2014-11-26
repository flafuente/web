<?php
use Phinx\Migration\AbstractMigration;

class Nota extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('notas');
        $table->addColumn('userId', 'integer', array('limit' => 11, 'default' => null, 'null' => true));
        $table->addColumn('estadoId', 'integer', array('limit' => 11, 'default' => null, 'null' => true));
        $table->addColumn('titulo', 'string', array('limit' => 100, 'default' => null, 'null' => true));
        $table->addColumn('imagen', 'string', array('limit' => 100, 'default' => null, 'null' => true));
        $table->addColumn('archivo', 'string', array('limit' => 100, 'default' => null, 'null' => true));
        $table->addColumn('descripcion', 'text', array('default' => null, 'null' => true));
        $table->addColumn('nota', 'text', array('default' => null, 'null' => true));
        $table->addColumn('fecha', 'date', array('default' => null, 'null' => true));
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
