@foreach ($products as $product)
    <li class="product-list-element" data-associated-products="product-element"
        data-product-id="{{ $product->id }}">
        <span class="product-control glyphicon glyphicon-minus text-danger"
              data-associated-products="remove"></span>

            <span style="display: none;" class="product-sorting glyphicon glyphicon-resize-vertical"
                  data-associated-products="sortable-handler"></span>

        <span data-associated-products="current-product-name">
            {!! $product->name_with_code_1c !!}
        </span>
    </li>
@endforeach
