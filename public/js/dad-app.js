var responsavel;
const dataAtual = new Date();

$(document).ready(function () {

    if ($('#objResponsavel').length > 0) {

        this.responsavel = JSON.parse($('#objResponsavel')[0].defaultValue);
    }
});

function drawChart_google_user_count() {
    var json = {
        "Task": "Hours per Day",
        "Work": 8,
        "Friends": 2,
        "Eat": 2,
        "TV": 2,
        "Gym": 2,
        "Sleep": 3
    };

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(json);
    var options = {
        height: 300,
        chartArea: {width: '98%', height: '80%'},
        hAxis:  {showTextEvery: 7, textStyle: {fontSize: '10'}},
        legend: {position: 'top', textStyle: {color: 'blue', fontSize: 12}},
        lineWidth: 4,
        pointShape: 'circle',
        pointSize: 6,
        vAxis: {textPosition: 'in', gridlines: {count: 3}, minorGridlines: {count: 2}, textStyle: {fontSize: 12}},
    };
    // Instantiate and draw our chart, passing in some options.
    //do not forget to check ur div ID
    var chart = new google.visualization.AreaChart(document.getElementById('chart_div_google_user_count'));
    chart.draw(data, options);
}

function preenche_endereco(dados = null) {
    
    if (!dados || dados.erro) {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        // $("#ibge").val("");
        alert("CEP não encontrado.");

        return false;
    }

    //Atualiza os campos com os valores da consulta.
    $("#rua").val(dados.logradouro);
    $("#bairro").val(dados.bairro);
    $("#cidade").val(dados.localidade + '/' + dados.uf);
    $("#uf").val(dados.uf);
    // $("#ibge").val(dados.ibge);

    // setTipoLogradouro(dados.logradouro);
    // setTipoBairro(dados.bairro);

    $("#numero").focus();
}

function buscaCep(){
    //Nova variável "cep" somente com dígitos.
    let cep = $('#txtCep').val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#uf").val("...");
            $("#ibge").val("...");

            //Consulta o webservice viacep.com.br/
            axios.get("https://viacep.com.br/ws/"+ cep +"/json")
                .then(function (response) {
                    preenche_endereco(response.data);
                });
        } else {
            //cep é inválido.
            preenche_endereco();
            alert("Formato de CEP inválido.");
        }
    } else {
        //cep sem valor, limpa formulário.
        preenche_endereco();
    }
}

function getSaldo() {

    let idDependente = $('#compra-selDependente').val();

    axios.get('/dad/conta/' + idDependente)
        .then(function (response) {
            $('#saldo').text('R$ ' + response.data.saldo.toFixed(2).replace('.', ','));
        });
}

function comprar(valor, taxa) {

    event.preventDefault();

    let idDependente = $('#compra-selDependente').val();

    window.location.href = '/sale/checkout?valor=' + valor + '&dependente=' + idDependente;

}

function confirmaCompra(formaPagto) {

    let dados = {
        "valor": $('#valor').val(),
        "taxa": $('#taxa').val(),
        "idDependente": $('#idDependente').val(),
        "formaPagto": formaPagto
    };

    axios.post('/sale/confirm', dados)
        .then(function (response) {

            let retorno = response.data;
            if (retorno.erro) {

                alert(retorno.mensagem);

                return false;
            }

            if (formaPagto == 'boleto') {
                window.open(retorno.object.bankSlipUrl, "_blank");
            } else {
                window.open(retorno.object.invoiceUrl, "_blank");
            }

            $('#pos-confirmacao').removeClass('d-none');
            $('#form-confirmacao').addClass('d-none');
        });
}