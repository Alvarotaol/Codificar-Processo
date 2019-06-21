<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deputado;
use App\Models\Rede;
use App\Models\Verba;

class IndexController extends Controller
{
    /*
     * Retorna a página inicial onde será possível solicitar e exibir as informações
     */
    public function index()
    {
        return view('index', ['deputados' => Deputado::all(), 'redes' => Rede::all()]);
    }

    public function coletarDados()
    {
        //Url com os deputados da legislatura de 2017
        $_urlDeputados = 'http://dadosabertos.almg.gov.br/ws/legislaturas/pesquisa_deputados?leg=18';
        //Url dos contatos dos deputados, incluindo suas redes sociais
        $_urlRedes = 'http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica';
        //Base da url para recuperar as verbas indenizatórias de cada deputado.
        $_urlVerbas = 'http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/deputados/';
        //Ano para as verbas indenizatórias
        $_ano = '2017';

        /* //Os deputados são agrupados por situação.
        //Mas só considero a primeira situação (em exercício)
        $xmlDeputados = simplexml_load_file($_urlDeputados);
        //Guarda todos os deputados no banco
        foreach ($xmlDeputados->resultadoPesquisaDeputado[0]->lista->deputado as $xmlDeputado) {
            Deputado::create([
                'id' => $xmlDeputado->id,
                'nome' => $xmlDeputado->nome,
                'partido' => $xmlDeputado->partido
            ]);
        } */

        $deputados = Deputado::all();
        /*
         * 
         */
        //Guarda as verbas indenizatórias de cada deputado
        foreach ($deputados as $deputado) {
            //Repete para cada mês
            for ($mes=1; $mes <= 12; $mes++) { 
                $xmlVerbas = simplexml_load_file($_urlVerbas.$deputado->id.'/'.$_ano.'/'.$mes);
                foreach($xmlVerbas->resumoVerba as $xmlVerba) {
                    Verba::create([
                        'valor' => str_replace(',', '.', $xmlVerba->valor),
                        'mes' => $mes,
                        'deputado_id' => $deputado->id
                    ]);
                }
            }
            break;
        }
        

        /*
         * As informações de contato só está disponíveis para a legislatura atual (2019-2023),
         * mas o problema pede as verbas para o ano de 2017, na legislatura anterior.
         * Por isso as redes sociais não estão relacionadas diretamente com os deputados no banco.
         */
        /* $xmlRedes = simplexml_load_file($_urlRedes);
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
        } */

        return $this->index();
    }
}
