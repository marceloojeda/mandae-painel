<h3>Cliente: {{ sprintf("#%d %s", $solicitacao->responsavel->id, $solicitacao->responsavel->nome }}</h3>
<p>Valor credito: {{ $solicitacao->valor }}</p>
<p>Taxa: {{ $solicitacao->taxa }}</p>