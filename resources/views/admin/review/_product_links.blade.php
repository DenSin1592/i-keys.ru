<div id="product_links" {!! !isset($product) ? 'style="display: none"' : '' !!}>

    <a data-edit-link
       href="{!! isset($product) ? route('cc.products.edit', [$product->category->id, $product->id]) : '' !!}"
       target="_blank"
       title="Редактировать товар"
       class="glyphicon glyphicon-share">
    </a>

    <a data-site-link
{{--       href="{!! (isset($product) && $product->publish && $product->category->in_tree_publish) ? \UrlBuilder::buildProductUrl($product) : '#' !!}"--}}
       href="{!! (isset($product) && $product->publish && $product->category->in_tree_publish) ? '/' : '#' !!}"
       @if (!(isset($product) && $product->publish && $product->category->in_tree_publish))
       style="display: none"
       @endif
       target="_blank"
       title="Смотреть на сайте"
       class="glyphicon glyphicon-share-alt">
    </a>
</div>
