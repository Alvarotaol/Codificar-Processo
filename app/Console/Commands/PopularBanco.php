<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiReader;

class PopularBanco extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular {--d|deputado} {--r|rede} {--i|verba} {--C|cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popula o banco de dados com os dados da API da almg';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Se nenhuma opção foi selecionada, executa tudo
        if(!$this->option('deputado') and !$this->option('rede') and !$this->option('verba')) {
            $this->deputados();
            $this->redes();
            $this->verbas();
        } else {
            if($this->option('deputado')) {
                $this->deputados();
            }
            if($this->option('rede')) {
                $this->redes();
            }
            if($this->option('verba')) {
                $this->verbas();
            }
        }
    }

    private function deputados() {
        ApiReader::getDeputados();
        $this->comment("Tabela de deputados populada.");
    }

    private function redes() {
        ApiReader::getRedes();
        $this->comment("Tabela de redes sociais populada.");
    }

    private function verbas() {
        if($this->option('cache')) {
            ApiReader::getCacheVerbas();
            $this->comment("Tabela de verbas indenizatórias populada pelo cache");
        } else {
            ApiReader::getVerbas();
            $this->comment("Tabela de verbas indenizatórias populada. Como estava o café?");
        }
    }
}