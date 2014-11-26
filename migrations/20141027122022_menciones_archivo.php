<?php
use Phinx\Migration\AbstractMigration;

class MencionesArchivo extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('menciones');
        $table->addColumn('archivo', 'string', array('after' => 'link', 'limit' => 100, 'default' => null, 'null' => true));
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
