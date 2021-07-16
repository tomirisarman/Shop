@foreach($subcategories as $subcategory)
    <ul>
        <li>{{$subcategory->name}}</li>
        @if(count($subcategory->products))
            <ul type="none">
                @foreach($subcategory->products as $prod)
                    <li>{{$prod->name}} - {{$prod->description}} - {{$prod->price}} тг.</li>
{{--                    <form action="{{route('addToCart')}}" method="POST">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="prod_id" value="{{$prod->id}}">
                               <input class="btn btn-primary" type="submit" value="В корзину">
--}}
                    <a href="{{route('addToCart', $prod->id)}}">В корзину</a>

                    </form>
                @endforeach
            </ul>
        @endif
        @if(count($subcategory->children))
            @include('subCategoryList',['subcategories' => $subcategory->children])
        @endif
    </ul>
@endforeach
