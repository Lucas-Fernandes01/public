<?php

use Phinx\Migration\AbstractMigration;

class V1CreateInitialDatabaseSchema extends AbstractMigration
{
    public function up(): void
    {
        // Tabela: cadastro_usuarios
        $this->table('cadastro_usuarios', ['id' => false, 'primary_key' => ['id'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('nome', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('senha', 'string', ['limit' => 255])
            ->addColumn('tipo_usuario', 'enum', ['values' => ['cliente', 'admin'], 'default' => 'cliente'])
            ->addColumn('endereco', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('bairro', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('numero', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('referencia', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('foto', 'string', ['limit' => 255, 'null' => true])
            ->addIndex(['email'], ['unique' => true, 'name' => 'email'])
            ->create();

        // Tabela: enderecos
        $this->table('enderecos', ['id' => false, 'primary_key' => ['id'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('cep', 'string', ['limit' => 9])
            ->addColumn('bairro', 'string', ['limit' => 100])
            ->addColumn('endereco', 'string', ['limit' => 255])
            ->addColumn('numero', 'string', ['limit' => 20])
            ->addColumn('referencia', 'string', ['limit' => 255, 'null' => true])
            ->addForeignKey('usuario_id', 'cadastro_usuarios', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();

        // Tabela: ingredientes
        $this->table('ingredientes', ['id' => false, 'primary_key' => ['id'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('nome', 'string', ['limit' => 100])
            ->addColumn('preco', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0.00])
            ->addColumn('tipo', 'string', ['limit' => 50])
            ->addColumn('em_estoque', 'boolean', ['default' => true])
            ->create();

        // Tabela: pedidos
        $this->table('pedidos', ['id' => false, 'primary_key' => ['id'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('valor_total', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('tipo_entrega', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'Em preparação'])
            ->addColumn('data_pedido', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('usuario_id', 'cadastro_usuarios', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION']) // Mantendo como no seu dump
            ->create();

        // Tabela: pedido_itens
        $this->table('pedido_itens', ['id' => false, 'primary_key' => ['id'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('pedido_id', 'integer', ['signed' => false])
            ->addColumn('tipo', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('tamanho', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('complementos', 'text', ['null' => true])
            ->addColumn('adicionais', 'text', ['null' => true])
            ->addColumn('observacao', 'text', ['null' => true])
            ->addColumn('valor_item', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true])
            ->addForeignKey('pedido_id', 'pedidos', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION']) // Mantendo como no seu dump
            ->create();
    }

    public function down(): void
    {
        $this->table('pedido_itens')->drop()->save();
        $this->table('pedidos')->drop()->save();
        $this->table('ingredientes')->drop()->save();
        $this->table('enderecos')->drop()->save();
        $this->table('cadastro_usuarios')->drop()->save();
    }
}