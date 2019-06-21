Codificar - Processo Seletivo
##Como Rodar
    Após clonar ou baixar do github executar
        composer install
    para baixar as dependências do laravel.

    Crie um banco de dados mysql para armazenar os dados do projeto

    No arquivo .env, preencha DB_DATABASE, DB_USERNAME, DB_PASSWORD conforme os dados locais

    Execute o comando a seguir para criar a estrutura do banco
        php artisan migrate
    
    Para popular o banco com os dados da API, execute
        php artisan popular (demora cerca de 15 min)
        php artisan popular --cache (demora cerca de 3 min)
    O primeiro comando demora mais pois realiza mais de 1000 consultas à API.
    O segundo comando usa o arquivo storage/app/verbas.json que contém a maior parte dos dados para poupar tempo.
