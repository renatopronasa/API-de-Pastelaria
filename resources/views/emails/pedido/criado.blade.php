@component('mail::message')
# Pedido Criado

Olá {{ $pedido->cliente->nome }},

Seu pedido foi criado com sucesso! 

Aqui estão os detalhes do seu pedido:

@component('mail::table')
| Produto | Quantidade |
|---------|------------|
@foreach($pedido->produtos as $produto)
| {{ $produto->nome }} | {{ $produto->pivot->quantidade }} |
@endforeach
@endcomponent

Agradecemos a preferencia!

{{ config('app.name') }}
@endcomponent
