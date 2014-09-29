<?php

use Phinx\Migration\AbstractMigration;

class GoogleAuth extends AbstractMigration
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
        $table->addColumn('tfaStatus', 'integer', array('after' => 'password', 'limit' => 11, 'default' => 0, 'null' => true))
            ->addColumn('tfaSecret', 'string', array('after' => 'tfaStatus', 'limit' => 150, 'default' => null, 'null' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
