<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Deputado;

class CidadaoDeOlhoController extends Controller
{
    public function maioresGastosPorMes()
    {
        $deputados = Deputado::with('verbas')->get();

        $meses = [null, [], [], [], [], [], [], [], [], [], [], [], []];
        $top = [];
        
        //Para cada mês, soma os valores de indenizações e associa ao deputado, 
        foreach ($deputados as $deputado) {
            foreach ($deputado->verbas as $verba) {
                if(isset($meses[$verba->mes][$deputado->id])) {
                    $meses[$verba->mes][$deputado->id] += $verba->valor;
                } else {
                    $meses[$verba->mes][$deputado->id] = $verba->valor;
                }
            }
        }

        for ($mes=1; $mes <= 12; $mes++) {
            //Ordena os gastos do mês
            arsort($meses[$mes]);
            $top[$mes] = [];
            //Seleciona os 5 maiores
            $i = 0;
            foreach($meses[$mes] as $id => $gasto) {
                $deputado = $deputados->find($id);
                $top[$mes][$i] = [
                    'nome' => $deputado->nome,
                    'partido' => $deputado->partido,
                    'gasto' => number_format($gasto, 2, ',', '.')
                ];

                $i++;
                //Interrompe o laço quando atinge 5
                if($i == 5) break;
            }
        }
        return $top;
    }
}
