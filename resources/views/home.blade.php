@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                        @if($orders = Auth::user()->orders)
                            @foreach($orders as $order)
                                <h3 class="alert-success">Order number - {{$order->id}}</h3>
                                @foreach($order->items as $item)
                                    <p><b>{{$item->product->name}}</b></p>
                                    <p>Кол-во: {{$item->quantity}}</p>
                                @endforeach
                                <hr>
                            @endforeach
                        @else
                            Здесь будут ваши заказы
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
