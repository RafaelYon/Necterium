{{extends=layouts.app}}

{{var=title:'Home'}}

{{section=content}}

<div class="container">
    <div class="row p-5">
        <div class="col-md-12">        
            <h1 class="text-orange"><?=config('app.name')?></h1>
            <p>
                Um framework <b>MVC</b> com <b>com zero dependencias</b>.
            </p>
        </div>
    </div>
</div>

{{endsection}}