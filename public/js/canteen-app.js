$(document).ready(function(){
    eventos();
});

function eventos() {
    $('#btnNovaCategoria').click(function () {
        $('#createCategoria').modal('show');
    });

    $('#selDependente').change(function (item) {

        let idAluno = item.currentTarget.value;

        window.location.href = "/dad/shopping/" + idAluno;
    })

    setMascaras();
}

function setMascaras() {
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }
    $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
    
    $(".cpf").mask("999.999.999-99");
    $('.cnpj').mask("99.999.999/9999-99");
    $('.nascimento').mask("99/99/9999");
    
    $('.fone-fixo').mask('(00) 0000-00009');
    $('.fone-fixo').blur(function(event) {
    if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
        $('.fone-fixo').mask('(00) 00000-0009');
    } else {
        $('.fone-fixo').mask('(00) 0000-00009');
    }
    });

    $('.celular').mask('(00) 0000-00009');
    $('.celular').blur(function(event) {
    if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
        $('.celular').mask('(00) 00000-0009');
    } else {
        $('.celular').mask('(00) 0000-00009');
    }
    });

    $('.money2').mask("#.##0,00", {reverse: true});
    $('.tributo').mask("#0,00", {reverse: true});
}

function cadastrarCategoria() {
    
    let categoria = $('#categoria').val();
    let post = { _token: document.getElementsByName('csrf-token')[0].content, categoria: categoria };

    $.post('/canteen/cardapio/categoria', post, function (categoria) {
        $('#selectCategoria').append('<option value="' + categoria.id + '" selected="selected">' + categoria.descricao + '</option>');
        $('#createCategoria').modal('hide');
    });
}

function abrirModalConfirmacao() {
    $('#dadosPedido').addClass('d-none');
    $('#numero').val('');
    $('#idPedido').val('');
    $('#btnConfirmar').attr('disabled', true);

    $('#confirmaPedido').modal('show');
    $('#numero').focus();
}

function buscarPedido() {
    $.get("/canteen/pedidos/buscar-pedido/" + $('#numero').val(), function (result, status) {
        if (result.erro) {
            toastr.warning(result.msgErro);
            return false;
        }

        $('#itens').empty();

        preencherDadosPedido(result.pedido, result.itens, result.dependente);
    });
}

function preencherDadosPedido(pedido, itens, aluno) {
    $('#title').text("Pedido #" + pedido.numero_pedido);
    $('#nome').text(aluno.nome + ' (' + aluno.serie + ')');
    $('#idPedido').val(pedido.id);
    $('#total').text("R$ " + pedido.total.toString());

    itens.forEach(item => {
        let badge = '<span class="badge badge-default badge-pill">'+ item.total +'</span>';
        $('#itens').append('<li class="list-group-item justify-content-between">' + item.quantidade + 'x ' + item.produto + badge + '</li>');
    });

    $('#dadosPedido').removeClass('d-none');
    $('#btnConfirmar').attr('disabled', false);
}

function confirmarPedido() {
    $.get("/canteen/pedidos/confirma-pedido/" + $('#idPedido').val(), function (result, status) {
        if (result.erro) {
            toastr.warning(result.msgErro);
            return false;
        }

        location.reload();
    });
}

function cancelarPedido() {
    
    let id = $('#pedidoSelecionado').val();

    $.get("/canteen/pedidos/cancelar/" + id, function (result, status) {
        if (result.erro) {
            toastr.warning(result.msgErro);
            return false;
        }

        location.reload();
    });
}

function estornarPedido() {
    
    let id = $('#pedidoSelecionado').val();

    $.get("/canteen/pedidos/estornar/" + id, function (result, status) {
        if (result.erro) {
            toastr.warning(result.msgErro);
            return false;
        }

        location.reload();
    });
}

function selectPedido(id) {
    $('#pedidoSelecionado').val(id);
}

function openModal(id, target) {
    
    switch (target) {
        case 'pedido':
            getDetalhesPedido(id);
            break;
    
        default:
            break;
    }
}

function getDetalhesPedido(idPedido) {
    
    $.get('/dad/childs/pedidos/' + idPedido, function (retorno) {
        
        $('#tabItens tbody tr').remove();
        $('#numero').val(retorno.pedido.numero_pedido);
        $('#data').val(retorno.dataPedido);
        $('#situacao').val(retorno.pedido.status);
        $('#dependente').val(retorno.dependente.nome);
        $('#serie').val(retorno.dependente.serie);

        retorno.itens.forEach((item, index) => {
            let row = '<tr>';
            row += '<td>' + item.quantidade + '</td>';
            row += '<td>' + item.produto + '</td>';
            row += '<td class="text-right">' + item.valorUnitario + '</td>';
            row += '<td class="text-right">' + item.total + '</td>';
            row += '</tr>';

            $('#tabItens tbody').append(row);

            $('#detalhePedido').modal('show');
        });
    })
}