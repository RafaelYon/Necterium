{{extends=layouts.app}}

{{var=title:'Registro'}}

{{section=content}}

<div class="container">
    <div class="row p-5">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <h3 class="card-header text-center">Registro</h3>
                <form method="POST" action="/register">
                    <?=inputCsrf()?>
                    <div class="card-body">
                        <div class="text-danger">
                            {{show-validation-errors}}
                        </div>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input class="form-control" type="text" id="name" name="name" maxlength="256" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" type="email" id="email" name="email" maxlength="254" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-warning">Limpar</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{endsection}}