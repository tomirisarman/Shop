@foreach($subcategories as $subcategory)
    <ul>
        <li style="cursor: pointer" onclick="$('#{{$subcategory->id}}').toggle()">{{$subcategory->name}}</li>
        @if(count($subcategory->products))
            <ul type="none" id="{{$subcategory->id}}">
                @foreach($subcategory->products as $prod)
                    <li>{{$prod->name}} - {{$prod->description}} - {{$prod->price}} тг.</li>
                    @if(isset($prod->picture))
                    <img src="{{asset('storage/'.$prod->picture)}}" alt="" width="100px"><br>
                    @endif
{{--                    <form action="{{route('addToCart')}}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="prod_id" value="{{$prod->id}}">
                               <input class="btn btn-primary" type="submit" value="В корзину">
--}}
                    @if(session()->has('cart') && array_key_exists($prod->id, session()->get('cart')))
                        <a href="{{route('removeFromCart', $prod->id)}}">Удалить из корзины</a>
                    @endif
                        <a href="{{route('addToCart', $prod->id)}}">В корзину</a>
                @endforeach
            </ul>
        @endif
        @if(count($subcategory->children))
            @include('subCategoryList',['subcategories' => $subcategory->children])
        @endif
    </ul>
@endforeach
