# Necterium
Necterium é um **framework MVC** escrito em PHP com o objetivo de possuir zero dependências. 

O Necterium **não foi projetado para se distribuido com um grande framework**, seu existencia é baseada em apenas a realização de um desafio proposto para mim.

## Recursos

### Sistema de rotas
O Sistema de rotas permite separa a aplicação em 2 camadas: **web** e **api**, cada qual é segmentada também pelo método de requisição desejado.

Uma rota é definida por um **Key-Value**, onde a **Key** é uma string a qual define qual caminho deve ser utilizado para acessar o **Value**, que é composto por uma *Controller* e um *Action* - método público de uma Controller que manipula uma requisição - que são separados por um `@` em um string. Exemplo:

`'/phone/{^(([1-9])([0-9]*))$}' => 'PhoneController@show'`

Também é possível definir valores variáveis em um rota utilizando a seguinte expressão: `{expressão_regex}`. Exemplo:

`/phone/{/phone/{^(([1-9])([0-9]*))$}}`

Esta rota aceitará apenas valores variváveis inteiros maiores que 0.

### Request
Esta classe possui o *URI* requisitado e o método utilizado para tal. Além dos parâmetros enviados na requisitação.

## Controller
Toda **Action** deve receber como parâmetro uma **Request**.

## Response
Uma classe para auxiliar na criação de respotas, sejam elas **Views**, ou *strings* simples.

Com uma response é possível definir com facilidade o código de respota, além de possuir uma forma conveniente de criar respotas *json*

## Eurikson - Template engine
Um template engine simples, criado com o propósito de não duplicar código em suas views.

O **Eurikson** permite que vocẽ extenda um layout por meio da substituição de áreas, de agora em diante chamdas de **Section**s, ou substituições de variáveis das views - chamadas de **var**s - além de código php tradicional e utilização de varáiveis passadas anteriormente pela **Controller**

Cada view é "compilada", assim o resultado final é um arquivo único de view, ou seja, não é utilizado require on include quando vocẽ extende uma layout.

Por questões de otimização é criado um cache da view em abientes de produção. Assim é importante ressaltar que, a cada nova atualização, após o projeto estar no abiente de produção, deve-se deletar todos arquivos de cache do projeto:

$ `cd cache`

$ `rm -rf *`

### Extendendo um layout
Para extender um layout é muito simples, apenas utlize o comando:

`{{extends=layoutfolder.layoutfile_withou_extension}}`

Lembrando que todas as vies devem possui a extenao **.php**

### Definindo uma *var*

`{{var=title:'Home'}}`

### Criando uma *Section*

```
{{section=content}}

<div class="container">
    <div class="row p-5">
        <div class="col-md-12 text-center">        
            <h1 class="text-orange"><?=config('app.name')?></h1>
            <p>
                Crie, edite e exclua seus contatos.
                <br>
                A ferramente de gerenciamento completo para seus contatos
            </p>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>

{{endsection}}
```

### Definindo local de substituição
Para deinir um lugar que deve ser substituido por uma **var** ou uma **Section**. Use:

`{{yield=section_or_var_name}}`

## Configurando
1. Permissões
   1. Permita que o apache consiga escrever no diretório de cache: $ `sudo chown www-data:www-data -R cache`