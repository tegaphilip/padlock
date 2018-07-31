<?php

use Phinx\Migration\AbstractMigration;

class InecLgasMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        if (!$this->hasTable('states') || $this->hasTable('inec_lgas')) {
            return;
        }

        $this->table('inec_lgas')
            ->addColumn('name', 'string', ['length' => 100, 'null' => false, 'encoding' => 'utf8mb4'])
            ->addColumn('inec_id', 'integer', ['length' => 100, 'null' => false, 'comment' => 'id from inec db'])
            ->addColumn('state_id', 'integer', ['length' => 11])
            ->addForeignKey('state_id', 'states', ['id'], ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
