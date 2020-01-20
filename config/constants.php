<?php

return [
    'NACIONAL' => 'nacional',
    'INTERNACIONAL' => 'internacional',
    'DATABASE' => 'database',
    
    'SERVICOS_NFSE' => [
    	'ENVIO' => 'envio'
    ],

    'UBERLANDIA_COD_MUNICIPIO' => 5403,
    'UBERLANDIA_COD_IBGE' => 3170206,
    'QUEBRA_LINHA' => PHP_EOL,
    'URL_STORAGE' => 'storage',

    'PERFIL_USUARIO' => [
        'ADMIN' => 0,
        'CANTINEIRO' => 1,
        'RESPONSAVEL' => 2,
        'DEPENDENTE' => 3
    ],

    'STATUS_PEDIDO' => [
        'ABERTO' => 'Aberto',
        'CANCELADO' => 'Cancelado',
        'REJEITADO' => 'Rejeitado',
        'CONFIRMADO' => 'Confirmado',
        'VENCIDO' => 'Vencido'
    ],

    'ORIGEM_PEDIDO' => [
        'APLICATIVO_DEPENDENTE' => 0,
        'APLICATIVO_RESPONSAVEL' => 1,
        'PORTAL_CANTINEIRO' => 2,
        'PORTAL_RESPONSAVEL' => 3
    ]
];