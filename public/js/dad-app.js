var responsavel = JSON.parse($('#objResponsavel')[0].defaultValue);
const dataAtual = new Date();

$(document).ready(function () {
    eventos();
});

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

function setTipoBairro(bairro){
    if(bairro.includes("Bairro")){
        $('#tipoBairro').val("Bairro");
        return;
    }
    if(bairro.includes("Bosque")){
        $('#tipoBairro').val("Bosque");
        return;
    }
    if(bairro.includes("Chácara")){
        $('#tipoBairro').val("Chácara");
        return;
    }
    if(bairro.includes("Conjunto")){
        $('#tipoBairro').val("Conjunto");
        return;
    }
    if(bairro.includes("Desmembramento")){
        $('#tipoBairro').val("Desmembramento");
        return;
    }
    if(bairro.includes("Distrito")){
        $('#tipoBairro').val("Distrito");
        return;
    }
    if(bairro.includes("Favela")){
        $('#tipoBairro').val("Favela");
        return;
    }
    if(bairro.includes("Fazenda")){
        $('#tipoBairro').val("Fazenda");
        return;
    }

    if(bairro.includes("Gleba")){
        $('#tipoBairro').val("Gleba");
        return;
    }
    if(bairro.includes("Horto")){
        $('#tipoBairro').val("Horto");
        return;
    }
    if(bairro.includes("Jardim")){
        $('#tipoBairro').val("Jardim");
        return;
    }
    if(bairro.includes("Loteamento")){
        $('#tipoBairro').val("Loteamento");
        return;
    }
    if(bairro.includes("Núcleo")){
        $('#tipoBairro').val("Núcleo");
        return;
    }
    if(bairro.includes("Parque")){
        $('#tipoBairro').val("Parque");
        return;
    }
    if(bairro.includes("Residencial")){
        $('#tipoBairro').val("Residencial");
        return;
    }
    if(bairro.includes("Sítio")){
        $('#tipoBairro').val("Sítio");
        return;
    }
    if(bairro.includes("Tropical")){
        $('#tipoBairro').val("Tropical");
        return;
    }
    if(bairro.includes("Vila")){
        $('#bairro').val("Vila");
        return;
    }
    if(bairro.includes("Zona")){
        $('#tipoBairro').val("Zona");
        return;
    }

    $('#tipoBairro').val("Bairro");
}

function setTipoLogradouro(logradouro){
    
    if(logradouro.includes("Avenida")){
        $('#tipoLogradouro').val('Avenida');
        return; 
    }
    if(logradouro.includes("Rua")){
        $('#tipoLogradouro').val('Rua');
        return; 
    }
    if(logradouro.includes("Rodovia")){
        $('#tipoLogradouro').val("Rodovia");
        return; 
    }
    if(logradouro.includes("Ruela")){
        $('#tipoLogradouro').val("Ruela");
        return; 
    }
    if(logradouro.includes("Rio")){
        $('#tipoLogradouro').val("Rio");
        return; 
    }
    if(logradouro.includes("Sítio")){
        $('#tipoLogradouro').val("Sítio");
        return; 
    }
    if(logradouro.includes("Sup Quadra")){
        $('#tipoLogradouro').val("Sup Quadra");
        return; 
    }
    if(logradouro.includes("Travessa")){
        $('#tipoLogradouro').val("Travessa");
        return; 
    }
    if(logradouro.includes("Vale")){
        $('#tipoLogradouro').val("Vale");
        return; 
    }
    if(logradouro.includes("Via")){
        $('#tipoLogradouro').val("Via");
        return; 
    }
    if(logradouro.includes("Viaduto")){
        $('#tipoLogradouro').val("Viaduto");
        return; 
    }
    if(logradouro.includes("Viela")){
        $('#tipoLogradouro').val("Viela");
        return; 
    }
    if(logradouro.includes("Vila")){
        $('#tipoLogradouro').val("Vila");
        return; 
    }
    if(logradouro.includes("Vargem")){
        $('#tipoLogradouro').val("Vargem");
        return; 
    }
    
    $('#tipoLogradouro').val('Rua');
}

function comprar(valor) {

    if (!responsavel.asaas_customer_id) {
        this.createCustomerAsaas();
    }
    console.log(valor + ' em creditos.');
}

function getSaldo() {

    idDependente = $('#compra-selDependente').val();

    axios.get('/dad/conta/' + idDependente)
        .then(function (response) {
            $('#saldo').text('R$ ' + response.data.saldo.toFixed(2).replace('.',',') );
        });
}

function createCustomerAsaas() {

    
    let dados = {
        "name": this.responsavel.nome,
        "cpfCnpj": this.responsavel.cpf,
        "email": this.responsavel.email,
        "phone": !this.responsavel.telefone ? '' : this.responsavel.telefone,
        "mobilePhone": !this.responsavel.celular ? '' : this.responsavel.celular,
        "addressNumber": this.responsavel.numero,
        "complement": this.responsavel.complemento,
        "postalCode": this.responsavel.cep,
        "externalReference": this.responsavel.id
    };

    axios.post($('#ASAAS_URL').val() + '/api/v3/customers', dados,
        {
            headers: {
                "Content-Type": "application/json",
                "access_token": $('#ASAAS_TOKEN').val()
            }
        })
        .then(function (response) {
            console.log(response);
        });
}

function criarCobranca(customer, value, produto) {
    let dados = {
        "customer": customer,
        "billingType": "UNDEFINED",
        "value": value,
        "dueDate": addDays(this.dataAtual, 3),
        "description": produto,
        "externalReference": produto,
        "postalService": false
    };

    axios.post($('#ASAAS_URL').val() + '/api/v3/payments', dados,
        {
            headers: {
                "Content-Type": "application/json",
                "access_token": $('#ASAAS_TOKEN').val()
            }
        })
        .then(function (response) {
            this.criarCobranca(response.data);
        });
}

function criarCobranca(asaasResponse) {

    axios.post('/dad/sale', asaasResponse)
        .then(function (response) {
            window.open(asaasResponse.invoiceUrl, "_blank");
        });
}