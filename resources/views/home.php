{{extends=layouts.app}}

{{var=title:'Home'}}

{{section=content}}

<div class="container">
    <div class="row p-5">
        <div class="col-md-12">
            <table id="phones" class="table table-striped">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Criado em</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#phones').DataTable( {
            "ajax": {
                "url": "api/phone",
                "type": "GET",
            },
            "columns": [
                { "data": "number" },
                { "data": "created_at" }
            ]
        } );
    } );
</script>

{{endsection}}