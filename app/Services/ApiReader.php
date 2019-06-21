<?php

namespace App\Services;

use Storage;
use App\Models\Deputado;
use App\Models\Rede;
use App\Models\Verba;


/*
 * Classe para recuperar os dados da api da almg e salvá-los no banco de dados
 */

class ApiReader  
{
    //Url com os deputados da legislatura de 2017
    const URL_DEPUTADOS = 'http://dadosabertos.almg.gov.br/ws/legislaturas/pesquisa_deputados?leg=18';
    //Url dos contatos dos deputados, incluindo suas redes sociais
    const URL_REDES = 'http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica';
    //Base da url para recuperar as verbas indenizatórias de cada deputado.
    const URL_VERBAS = 'http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/deputados/';
    //Ano para as verbas indenizatórias
    const ANO = '2017';
    //Nome do arquivo onde será armazenado o cache das verbas
    const CACHE_VERBAS = 'verbas.json';

    static function getDeputados()
    {
        //Os deputados são agrupados por situação.
        //Mas só considero a primeira situação (em exercício)
        $xmlDeputados = simplexml_load_file(self::URL_DEPUTADOS);
        //Guarda todos os deputados no banco
        foreach ($xmlDeputados->resultadoPesquisaDeputado[0]->lista->deputado as $xmlDeputado) {
            Deputado::create([
                'id' => $xmlDeputado->id,
                'nome' => $xmlDeputado->nome,
                'partido' => $xmlDeputado->partido
            ]);
        }
    }

    static function getRedes()
    {
        /*
         * As informações de contato só está disponíveis para a legislatura atual (2019-2023),
         * mas o problema pede as verbas para o ano de 2017, na legislatura anterior.
         * Por isso as redes sociais não estão relacionadas diretamente com os deputados no banco.
         */
        $xmlRedes = simplexml_load_file(self::URL_REDES);
        //Guarda as redes sociais e as associa com os deputados
        foreach($xmlRedes->contato as $xmlContato) {
            foreach ($xmlContato->redesSociais->redeSocialDeputado as $xmlRede) {
                Rede::create([
                    'rede_id' => $xmlRede->redeSocial->id,
                    'deputado_id' => $xmlContato->id,
                    'nome' => $xmlRede->redeSocial->nome,
                    'url' => $xmlRede->url
                ]);
            }
        }
    }


    static function getVerbas() {
        $deputados = Deputado::all();
        /*
         * A api só permite recuperar as verbas de um deputado em um mês específico
         * No total precisa fazer 77*12 requisições.
         * Isso demora.
         */
        //Guarda as verbas indenizatórias de cada deputado
        foreach ($deputados as $deputado) {
            //Repete para cada mês
            for ($mes=1; $mes <= 12; $mes++) { 
                $xmlVerbas = simplexml_load_file(self::URL_VERBAS.$deputado->id.'/'.self::ANO.'/'.$mes);
                foreach($xmlVerbas->resumoVerba as $xmlVerba) {
                    Verba::create([
                        'valor' => str_replace(',', '.', $xmlVerba->valor),
                        'mes' => $mes,
                        'deputado_id' => $deputado->id
                    ]);
                }
            }
        }
    }

    /*
     * Grava no banco de dados as verbas presentes no arquivo storage/app/verbas.json
     */
    static function getCacheVerbas() {
        $verbas = json_decode(Storage::get(self::CACHE_VERBAS), true);
        /*
         * A api só permite recuperar as verbas de um deputado em um mês específico
         * No total precisa fazer 77*12 requisições.
         * Isso demora.
         */
        //Guarda as verbas indenizatórias de cada deputado
        foreach ($verbas as $verba) {
            Verba::create($verba);
        }
    }

    /*
     * Salva os dados obtidos das verbas localmente para não ter que requisitá-la de novo.
     */
    static function cacheVerbas() {
        $verbas = Verba::all();
        Storage::put('verbas.json', $verbas->makeHidden('id')->toJson());
        return $verbas->toJson();
    }
}
