Codificar - Processo Seletivo

# Sobre o projeto
Este projeto se divide em três partes: 
* Um service chamado ApiReader que lê os dados disponíveis na api da almg e grava no banco.
Ele se encontra na pasta app/Services e é chamado através da linha de comando. Ver app/Console/Commands para detalhes.
* Uma api que envia os dados salvos na forma de rankings. Dos deputados que mais usam verbas indenizatórias e das redes sociais mais usadas. Ela está definida em app/Controllers/CidadaoDeOlhoController.php
* Uma página simples que lê os dados fornecidos pela api.
A view é retornada pelo IndexController, mas o código jQuery que faz as chamadas à api está em public/js/app.js

O projeto define 3 modelos: Deputado, Rede e Verba
Deputado se relaciona com Verba (um para muitos), mas Rede não tem relação. O motivo é que são solicitadas as verbas para o ano de 2017, na legislatura anterios, mas as redes sociais só são fornecidas para os deputados da legislatura atual (2019).

# Como Rodar
* Após clonar ou baixar do github executar
    composer install
para baixar as dependências do laravel.

* Crie um banco de dados mysql para armazenar os dados do projeto

* No arquivo .env, preencha DB_DATABASE, DB_USERNAME, DB_PASSWORD conforme os dados locais

* Execute o comando a seguir para criar a estrutura do banco
    php artisan migrate
    
* Para popular o banco com os dados da API, execute
    php artisan popular (demora cerca de 15 min)
    php artisan popular --cache (demora cerca de 3 min)
O primeiro comando demora mais pois realiza mais de 1000 consultas à API.
O segundo comando usa o arquivo storage/app/verbas.json que contém a maior parte dos dados para poupar tempo.

* Por fim, basta executar
    php artisan serve
Para que uma página que acessa e exibe as informações fique disponível em
        localhost:8000
