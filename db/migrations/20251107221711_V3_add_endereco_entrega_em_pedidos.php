<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class V3AddEnderecoEntregaEmPedidos extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('pedidos'); 
        
        $table->addColumn('endereco_entrega', 'string', [
            'limit' => 512,
            'null' => true,
            'after' => 'valor_total'
        ])

        ->update(); 
    }

    public function down()
    {
        $table = $this->table('pedidos');
        
        $table->removeColumn('endereco_entrega')

        ->update();
    }
}
