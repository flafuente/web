<?php
use Phinx\Migration\AbstractMigration;

class MencionesDescripcion extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('menciones');
        $table->addColumn('descripcion', 'text', array('after' => 'titulo', 'default' => null, 'null' => true));
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
