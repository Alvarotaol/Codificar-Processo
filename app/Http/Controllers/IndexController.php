<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiReader;

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
}
