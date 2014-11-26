<?php

use Phinx\Migration\AbstractMigration;

class Slides extends AbstractMigration
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
        // Slides
        $table = $this->table('slides');
        $table->addColumn('visible',        'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
            ->addColumn('order',            'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
            ->addColumn('nombre',           'string',   array('limit' => 50))
            ->addColumn('imagen',           'string',   array('limit' => 512, 'default' => null, 'null' => true))
            ->addColumn('url',              'string',   array('limit' => 512, 'default' => null, 'null' => true))
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
