<?php

use Phinx\Seed\AbstractSeed;

class InitialDataSeeder extends AbstractSeed
{
    public function run(): void
    {
        // Desabilita a verificação de chaves estrangeiras
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        // 1. Limpa as tabelas na ordem correta (filhas primeiro)
        $this->table('pedido_itens')->truncate();
        $this->table('pedidos')->truncate();
        $this->table('enderecos')->truncate();
        $this->table('ingredientes')->truncate();
        $this->table('cadastro_usuarios')->truncate();

        // 2. Populando a tabela de usuários
        $usersTable = $this->table('cadastro_usuarios');
        $usersData = [
            [
                'id'    => 1,
                'nome'  => 'Cliente 1',
                'email' => 'cliente@cliente.com',
                'senha' => '$2y$10$Sw.MwlspmbdrlSffPovE9.JUXAx6DZZpyjoen9oXXSC6TnqsZ2GRq',
                'tipo_usuario' => 'cliente',
                'endereco' => 'Rua Cliente', 'bairro' => 'Cliente', 'numero' => '1', 'referencia' => 'Cliente', 'foto' => null
            ],
            [
                'id'    => 2,
                'nome'  => 'Teste 1',
                'email' => 'teste@teste.com',
                'senha' => '$2y$10$IE9Ov.c45.SLm2FPQT56n.ifp9fm5fHEU3hCEsR/nMVBiWiT/SUxi',
                'tipo_usuario' => 'admin',
                'endereco' => 'Teste', 'bairro' => 'Teste', 'numero' => '1', 'referencia' => 'Teste', 'foto' => null
            ]
        ];
        $usersTable->insert($usersData)->saveData();

        // 3. Populando a tabela de ingredientes
        $ingredientsTable = $this->table('ingredientes');
        $ingredientsData = [
            ['id' => 1, 'nome' => '300 ml', 'preco' => 15.00, 'tipo' => 'tamanho_copo', 'em_estoque' => 1],
            ['id' => 2, 'nome' => '400 ml', 'preco' => 18.00, 'tipo' => 'tamanho_copo', 'em_estoque' => 1],
            ['id' => 3, 'nome' => '500 ml', 'preco' => 21.00, 'tipo' => 'tamanho_copo', 'em_estoque' => 1],
            ['id' => 4, 'nome' => '500 ml', 'preco' => 22.00, 'tipo' => 'tamanho_marmita', 'em_estoque' => 1],
            ['id' => 5, 'nome' => '770 ml', 'preco' => 35.00, 'tipo' => 'tamanho_marmita', 'em_estoque' => 1],
            ['id' => 6, 'nome' => 'Paçoca', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 7, 'nome' => 'Leite em pó', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 8, 'nome' => 'Confete', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 9, 'nome' => 'Granola', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 10, 'nome' => 'Granulado', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 11, 'nome' => 'Banana', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 12, 'nome' => 'Chocoball', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 13, 'nome' => 'Gotas de chocolate', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 14, 'nome' => 'Mel', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 15, 'nome' => 'Leite condensado', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 16, 'nome' => 'Amendoim torrado', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 17, 'nome' => 'Cobertura de morango', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 18, 'nome' => 'Cobertura de chocolate', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 19, 'nome' => 'Cobertura de uva', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 20, 'nome' => 'Cobertura de caramelo', 'preco' => 0.00, 'tipo' => 'complemento_gratis', 'em_estoque' => 1],
            ['id' => 21, 'nome' => 'Bis', 'preco' => 2.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 22, 'nome' => 'Ovomaltine', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 23, 'nome' => 'Sucrilhos', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 24, 'nome' => 'Morango', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 25, 'nome' => 'Uva', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 26, 'nome' => 'Manga', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 27, 'nome' => 'Creme de ninho', 'preco' => 3.50, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 28, 'nome' => 'Creme de avelã', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 29, 'nome' => 'Creme de morango', 'preco' => 4.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 30, 'nome' => 'Creme de amendoim', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 31, 'nome' => 'Creme de bombom', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1],
            ['id' => 32, 'nome' => 'Jujuba', 'preco' => 3.00, 'tipo' => 'adicional_pago', 'em_estoque' => 1]
        ];
        $ingredientsTable->insert($ingredientsData)->saveData();

        // Reabilita a verificação de chaves estrangeiras
        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }
}