@component('mail::message')
# Pedido Criado

Olá {{ $order->customer->nome }},

Seu pedido foi criado com sucesso! 

Aqui estão os detalhes do seu pedido:

@component('mail::table')
| Produto | Quantidade |
|---------|------------|
@foreach($order->products as $product)
| {{ $product->nome }} | {{ $product->pivot->quantity }} |
@endforeach
@endcomponent

Agradecemos a preferência!

{{ config('app.name') }}
@endcomponent
