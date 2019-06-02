<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="octicons/build.css">
        <link rel="stylesheet" href="css/app.css">

        {{yield=head}}

        <title><?=config('app.name')?> - {{yield=title}}</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg mb-2">
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbar" >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item m-1">
                        <a class="btn" 
                        href="https://github.com/RafaelYon/Necterium/archive/master.zip">
                            <img class="icon" src="octicons/svg/cloud-download.svg"> Download
                        </a>
                    </li>
                    <li class="nav-item m-1">
                        <a class="btn" href="https://github.com/RafaelYon/Necterium">
                            <img class="icon" src="octicons/svg/star.svg"> Star
                        </a>
                    </li>
                    <li class="nav-item m-1">
                        <a class="btn" href="https://github.com/RafaelYon/Necterium/issues">
                            <img class="icon" src="octicons/svg/issue-opened.svg"> Issue
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        {{yield=content}}

        <div class="container footer">
            <div class="row">
                <div class="col">
                    <p class="text-muted">
                        <a class="text-dark" href="https://github.com/RafaelYon/Necterium">
                            <strong>RafaelYon/Necterium</strong>
                        </a> 
                        is licensed under the 
                        <a href="https://github.com/RafaelYon/Necterium/blob/master/LICENSE">MIT License</a>.
                    </p>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        {{yield=scripts}}
    </body>
</html>