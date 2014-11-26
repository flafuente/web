<?php
use Phinx\Migration\AbstractMigration;

class VideoFecha extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('videos');
        $table->addColumn('fecha', 'date', array('after' => 'texto', 'default' => null, 'null' => true));
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
