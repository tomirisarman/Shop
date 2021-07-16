@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if(!isset($cart))
                            Корзина пуста
                        @else
                            @foreach($cart as $id => $item)
                                <div data-id="{{$id}}">
                                    <b>{{$item['name']}}</b> <i>- {{$item['price']}} тг.</i>
                                    <p>Кол-во: {{$item['quantity']}}</p>
                                    <p>К оплате: {{$item['price']*$item['quantity']}}</p>
                                </div>
                                <hr>
                            @endforeach
                            <h4 style="text-align: right;">Общая сумма: {{$sum}}</h4>
                                <form method="post" action="{{route('order')}}">
                                    @csrf
                                    <label for="address">Куда доставить: </label>
                                    <input type="text" name="address">
                                    <input type="submit" class="btn btn-primary" value="Заказать">
                                </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


