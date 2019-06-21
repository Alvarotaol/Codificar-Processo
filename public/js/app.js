$(document).ready(function() {

$('#gastos').click(function(e) {
    e.preventDefault();
    $.ajax({
        method: 'GET',
        url: 'api/gastos'
    }).done(function(data){
        mostraGastos(data);
    })
});

$('#redes').click(function(e) {
    e.preventDefault();
});

function mostraGastos(gastos) {
    const meses = ['', "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    div = $('#content');
    div.html('<p>2017</p>');
    for (let i = 1; i <= 12; i++) {
        const mes = gastos[i];
        div.append("<h3>"+meses[i]+"</h3>");
        lista = "<ol class='lista-mes'>";
        for (let j = 0; j < mes.length; j++) {
            const deputado = mes[j];
            lista += "<li>"+
                        "<span>"+deputado['nome']+"/"+deputado['partido']+"</span>"+
                        "<span>"+deputado['gasto']+"</span>"+
                     "</li>";
        }
        div.append(lista+"</ol>");
    }
}

});