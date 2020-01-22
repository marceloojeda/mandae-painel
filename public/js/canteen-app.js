$(document).ready(function(){
    eventos();
});

function eventos() {
    $('#btnNovaCategoria').click(function () {
        $('#createCategoria').modal('show');
    });

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