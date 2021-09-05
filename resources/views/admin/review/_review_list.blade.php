<ul class="element-list @if (empty($lvl)) scrollable-container @endif">
    @foreach ($reviewList as $review)
        <li data-element-id="{{ $review->id }}">
            <div class="element-container">
                <div class="id">
                    {{ $review->id }}
                </div>

                <div class="score">
                    <div class="rating-box">
                        <div class="rating" data-raty='{{ json_encode(
                            [
                                'score' => $review->score,
                                'readOnly' => true,
                            ]
                        ) }}'>
                        </div>
                    </div>
                </div>

                <div class="name">
                    <a href="{{ route('cc.reviews.edit', $review->id) }}">{{ $review->name }}</a>
                </div>

                <div class="content">
                    {{\Str::words(strip_tags($review->content), 15, '...')}}
                </div>

                <div class="review_date">
                    {{{ date('d.m.Y H:i', strtotime( $review->review_date )) }}}
                </div>

                <div class="publish">
                    @include('admin.shared._list_flag', [
                       'element' => $review,
                       'action' => route('cc.reviews.toggle-attribute', [$review->id, 'publish']),
                       'attribute' => 'publish'
                       ])
                </div>

                <div class="control">
                    @include('admin.review._control_block', ['review' => $review])
                </div>

            </div>
        </li>
    @endforeach
</ul>
