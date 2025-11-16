<?php
// Use a declaração 'use' correta no topo do seu arquivo
use Phinx\Migration\AbstractMigration;

class V2CreateResetDaSenha extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('password_resets', ['id' => true, 'primary_key' => ['id']]);

        $table->addColumn('email', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('token', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('expires_at', 'datetime', [
                'null' => false,
            ])
            ->addColumn('usado', 'boolean', [
                'default' => false,
                'null' => false,
            ]);

        $table->addIndex(['token']);

        $table->create();
    }
}