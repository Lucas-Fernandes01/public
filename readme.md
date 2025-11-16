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
-   **Gerenciador de Banco de Dados:** Phinx (para Migrations e Seeders)

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

Bash

git clone [URL_DO_SEU_REPOSITORIO_GIT] public
2. Acessar a Pasta do Projeto
Todos os comandos a seguir devem ser executados de dentro da pasta public.

Bash

# Para usuários XAMPP
cd C:\xampp\htdocs\public

# Para usuários Laragon
cd C:\laragon\www\public
O seu terminal deve indicar que você está neste diretório.

3. Configurar o Banco de Dados
a. Crie o Banco de Dados Vazio:

Abra seu gerenciador de banco de dados (phpMyAdmin) e crie um novo banco de dados vazio chamado acai.

SQL

CREATE DATABASE acai CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
b. Verifique a Conexão no phinx.php:

Abra o arquivo phinx.php e garanta que as credenciais na seção development correspondem às do seu ambiente local (geralmente root e senha em branco).

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
4. Instalar as Dependências do Projeto
Com o Composer instalado e o terminal na pasta public, execute:

Bash

composer install
Este comando irá ler o arquivo composer.json e instalará todas as dependências necessárias (como o Phinx) na pasta vendor/.

5. Construir a Estrutura do Banco (Migrations)
Agora, vamos criar as tabelas e colunas. O Phinx fará isso automaticamente. Ainda no terminal, execute:

Bash

vendor/bin/phinx migrate
Este comando irá ler a pasta db/migrations e construir o "esqueleto" do seu banco de dados acai.

6. Popular o Banco com Dados Iniciais (Seeders)
Com a estrutura pronta, vamos inserir os dados iniciais, como os usuários padrão e a lista de ingredientes.

Bash

vendor/bin/phinx seed:run
Este comando executa os arquivos da pasta db/seeds para popular as tabelas.

7. Iniciar o Projeto
Com tudo configurado, basta acessar o endereço correspondente no seu navegador:

http://localhost/public/

O site deverá estar funcionando corretamente com os dados iniciais carregados.