# Açaí da Suíça - Sistema de Pedidos Online

## 📖 Sobre o Projeto

Este é o repositório oficial do sistema web para o **Açaí da Suíça**. O projeto consiste em um site institucional com cardápio dinâmico, sistema de cadastro e login de usuários, e uma plataforma de gerenciamento de pedidos.

O sistema permite que clientes montem seus açaís, finalizem pedidos que são salvos no banco de dados e enviados via WhatsApp, além de gerenciarem seus dados e histórico de compras. O projeto também inclui um painel administrativo para gerenciamento de ingredientes do cardápio e visualização de todos os pedidos realizados pelos clientes.

---

## 🚀 Tecnologias Utilizadas

-   **Backend:** PHP 8+
-   **Frontend:** HTML5, CSS3, JavaScript (ES6)
-   **Banco de Dados:** MySQL / MariaDB
-   **Servidor Local:** XAMPP ou Laragon
-   **Gerenciador de Dependências:** Composer
-   **Gerenciador de Migrations:** Phinx

---

## ⚙️ Pré-requisitos

Antes de começar, certifique-se de que você tem as seguintes ferramentas instaladas em sua máquina:

1.  **Servidor Local:**
    * [**XAMPP**](https://www.apachefriends.org/index.html) ou
    * [**Laragon**](https://laragon.org/download/)

2.  **Git:** [Git SCM](https://git-scm.com/downloads) para controle de versão.

3.  **Composer:** [Composer](https://getcomposer.org/download/) para gerenciar as dependências do PHP.
    * *Durante a instalação, ele pedirá o caminho para o arquivo `php.exe`. Aponte para a pasta do seu servidor local:*
    * **Para XAMPP:** `C:\xampp\php\php.exe`
    * **Para Laragon:** `C:\laragon\bin\php\[versao-do-php]\php.exe`

---

## 🛠️ Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento local.

### 1. Clonar o Repositório

Abra o terminal e navegue até a pasta raiz do seu servidor web (`htdocs` para XAMPP, `www` para Laragon). Em seguida, clone o projeto para uma pasta chamada `public`.

> **Importante:** Se o seu projeto já está na pasta correta, pule este passo e apenas navegue até ela no terminal.

```bash
# Para usuários XAMPP
cd C:\xampp\htdocs

# Para usuários Laragon
cd C:\laragon\www

Agora, clone o repositório:

Bash (Terminal)
git clone [URL_DO_SEU_REPOSITORIO_GIT] public

2. Acessar a Pasta do Projeto
Todos os comandos a seguir devem ser executados de dentro da pasta public.

Bash (Terminal)

# Para usuários XAMPP
cd C:\xampp\htdocs\public

# Para usuários Laragon
cd C:\laragon\www\public

O seu terminal deve indicar que você está neste diretório.

3. Configurar o Banco de Dados
O banco de dados é gerenciado pelo Phinx, então você não precisa importar nenhum arquivo .sql manualmente.

a. Crie o Banco de Dados:

Abra seu gerenciador de banco de dados (phpMyAdmin) e crie um novo banco de dados vazio chamado acai.

SQL:
CREATE DATABASE acai CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

b. Verifique a Conexão:

Abra o arquivo phinx.php na raiz do projeto e garanta que as credenciais na seção development correspondem às do seu ambiente local (geralmente root e senha em branco).

PHP

// phinx.php
'development' => [
    'adapter' => 'mysql',
    'host'    => 'localhost',
    'name'    => 'acai',      // Nome do banco de dados
    'user'    => 'root',     // Usuário do banco
    'pass'    => '',          // Senha do banco
    'port'    => '3306',
    'charset' => 'utf8',
]

4. Instalar as Dependências
Com o Composer instalado e o terminal na pasta public, execute:

Bash (Terminal):
composer install

Este comando irá ler o arquivo composer.json e instalará todas as dependências necessárias (como o Phinx) na pasta vendor/.

5. Executar as Migrations
Agora, vamos criar a estrutura do banco de dados. O Phinx fará isso automaticamente. Ainda no terminal, execute:

Bash (Terminal):
vendor/bin/phinx migrate

Este comando irá ler os arquivos na pasta db/migrations e criará todas as tabelas e colunas necessárias no seu banco de dados acai.

6. Iniciar o Projeto
Com tudo configurado, basta acessar o endereço correspondente no seu navegador:

http://localhost/public/

O site deverá estar funcionando corretamente.

🗃️ Estrutura do Banco de Dados com Phinx
As alterações na estrutura do banco de dados são gerenciadas como código PHP através do Phinx.

Local dos Arquivos: db/migrations/

Para aplicar novas alterações (de outros desenvolvedores):

Bash (Terminal):
vendor/bin/phinx migrate

Para criar uma nova alteração:

Bash (Terminal):
vendor/bin/phinx create NomeDaAlteracaoEmPascalCase

Para desfazer a última alteração:

Bash (Terminal):
vendor/bin/phinx rollback