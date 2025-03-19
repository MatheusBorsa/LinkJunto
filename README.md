# API linkjunto

Esta API foi desenvolvida em **Laravel** e funciona como uma solução semelhante ao **Linktree**, permitindo que usuários criem uma página única com links para seus perfis em diversas plataformas. A API oferece funcionalidades para gerenciar perfis, adicionar links personalizados e acessar estatísticas básicas de cliques.

---

## Funcionalidades Principais

- **Criação de Perfis**: Os usuários podem criar perfis personalizados com nome, descrição e foto.
- **Gerenciamento de Links**: Adição, edição e remoção de links para redes sociais, sites pessoais, portfólios, etc.
- **Autenticação Segura**: Sistema de autenticação para proteger os dados dos usuários.

---

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para desenvolvimento rápido e seguro.
- **PostgreSQL**: Banco de dados para armazenamento de perfis e links.
- **Docker**: Docker utilizado para meu banco de dados.

---

## Como Usar

A API pode ser integrada a um front-end (web ou mobile) para criar páginas de links personalizadas. É ideal para influencers, profissionais e empresas que desejam centralizar seus links em um único lugar. Para rodar a API localmente, siga os passos abaixo:

---

### Pré-requisitos

1. **PHP**: Instale o PHP (versão 8.0 ou superior) e adicione-o ao **PATH** do Windows.

2. **Composer**: Baixe e instale o [Composer](https://getcomposer.org/), gerenciador de dependências do PHP.
   - Siga as instruções do site oficial para instalação.

3. **Docker Desktop**: Instale o [Docker Desktop](https://www.docker.com/products/docker-desktop) para rodar os containers do banco de dados e outras dependências.
   - Baixe e instale o Docker Desktop.
   - Certifique-se de que o Docker está rodando antes de executar os comandos.

---

### Passo a Passo

1. **Clonar o Repositório**:
   Abra o terminal e execute o comando abaixo para clonar o repositório:
   ```bash
   git clone https://github.com/MatheusBorsa/LinkJunto.git

2. **Configurar .env**:
    Copie o arquivo .env.example 

    Crie um novo arquivo na raiz do projeto chamado .env

    Cole o que foi copiado dentro deste novo arquivo
    
    Tenha certeza que esta parte do arquivo esteja assim
    ```
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=pgsql
    DB_USERNAME=pgsql
    DB_PASSWORD=pgsql
    ```
3. **Instalar as dependências do Composer**
    ```bash
    composer install
    ```
4. **Gerar a Chave da Aplicação**
    ```bash
    php artisan key:generate
    ```
5. **Execute as migrations**
    ```bash
    php artisan migrate
    ```
6. **Subir o Container com Docker**
    ```bash
    docker-compose up -d
    ```
7. **Inicialize o servidor**
    ```bash
    php artisan serve
    ```
