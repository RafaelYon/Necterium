<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/app.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        {{yield=head}}

        <title><?=config('app.name')?> - {{yield=title}}</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg shadow-sm mb-2">
            <a class="navbar-brand text-orange" href="/"><?=config('app.name')?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbar" >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?=($request->getRequestUri() == '/') ? 'active' : ''?>">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (auth()::check()): ?>
                        <li class="nav-item">
                            <form method="POST" action="/logout">
                                <?=inputCsrf()?>
                                <button type="submit" class="btn nav-link">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                        <li class="nav-item <?=($request->getRequestUri() == '/register') ? 'active' : ''?>">
                            <a class="nav-link" href="/register">Registro</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        {{yield=content}}

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        {{yield=scripts}}
    </body>
</html>