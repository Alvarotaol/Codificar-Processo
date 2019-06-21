<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/app.css">

    <title>Página Inicial</title>
</head>
<body>
    <section>
        <header>
            <h1>Dados da assembleia legislativa de Minas Gerais</h1>
        </header>
        <aside>
            <ul>
                <li><a href="{{route('coletar')}}">Coletar dados</a></li>
                <li><a href="">Gastos</a></li>
                <li><a href="">Redes sociais</a></li>
            </ul>
        </aside>
        <div class="content">
            Escolha uma opção ao lado
        </div>
        <footer>Desenvolvido por Álvaro Tavares para o processo de seleção da Codificar</footer>
    </section>

    <div>
    <p>Deputados</p>
    <select>
        @foreach($deputados as $deputado)
        <option>
            {{$deputado->nome}} - {{$deputado->id}}
        </option>
        @endforeach
    </select>
    <select>
        @foreach($redes as $rede)
        <option>
            {{$rede->nome}}
        </option>
        @endforeach
    </select>
    </div>
</body>
</html>