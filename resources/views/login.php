{{extends=layouts.app}}

{{var=title:'Login'}}

{{section=content}}

<div class="container">
    <div class="row p-5">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <h3 class="card-header text-center">Login</h3>
                <form method="POST" action="/login">
                    <?=inputCsrf()?>
                    <div class="card-body">
                        <div class="text-danger">
                            {{show-validation-errors}}
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" type="email" id="email" name="email" maxlength="254" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" type="password" id="password" name="password" minlength="8" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a class="btn btn-primary" href="/register">Criar registro</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{endsection}}