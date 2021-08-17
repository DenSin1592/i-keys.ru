@include('admin.shared.popup_associated_products._associated_products_block', [
    'fieldGroup' => 'related_products',
    'associatedProducts' => $associatedRelatedProducts,
    'disableSorting' => true,
    'product' => $product,
])