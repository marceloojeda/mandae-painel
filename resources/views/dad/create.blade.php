<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iCantina</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="../css/register.css" rel="stylesheet" id="bootstrap-css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
    <form action="/dad" method="POST">
        @csrf
        <div class="container register">
            <div class="row">
                <div class="col-md-3 register-left">
                    <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                    <h3>Bem vindo</h3>
                    <p>Tenha total <b>controle financeiro</b> com os lanches escolares do seu filho!</p>
                    <input type="submit" name="" value="Login"/><br/>
                </div>
                <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3  class="register-heading">Cadastro do responsável</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="text" class="form-control" name="nome" placeholder="Nome completo *" value="{{ old('nome') }}" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="{{ old('telefone') }}" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email *" value="{{ old('email') }}" />
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="idEstabelecimento">
                                    <option class="hidden"  selected disabled>Escola do dependente</option>
                                    @foreach ($estabelecimentos as $cantina)
                                        <option value="{{ $cantina->id }}">{{ $cantina->escola }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="senha" placeholder="Senha *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="senha_confirmation" placeholder="Confirme a senha *" value="" />
                            </div>
                            <input type="submit" class="btnRegister"  value="Register"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</body>
</html>
