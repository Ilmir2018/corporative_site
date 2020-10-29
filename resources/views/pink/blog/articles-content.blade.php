

<div id="content-blog" class="content group">
    @if($articles)
        @foreach($articles as $article)
            <div class="sticky hentry hentry-post blog-big group">
                <div class="thumbnail">
                    <h2 class="post-title"><a href="{{ route('article.show', ['alias' => $article->alias]) }}">{{ $article->title }}</a></h2>
                    <div class="image-wrap">
                        <img src="{{ asset(env('THEME')) }}/images/articles/{{ $article->img->max }}" alt="001" title="001" />
                    </div>
                    <p class="date">
                        <span class="month">{{ $article->created_at->format('M') }}</span>
                        <span class="day">{{ $article->created_at->format('D') }}</span>
                    </p>
                </div>
                <div class="meta group">
                    <p class="author"><span>by <a href="#" title="{{ $article->user->name }}" rel="author">{{ $article->user->name }}</a></span></p>
                    <p class="categories"><span>In: <a href="{{ route('articleCat', ['cat_alias' => $article->category->alias]) }}" title="{{ $article->category->title }}" rel="category tag">{{ $article->category->title }}</a></span></p>
                    <p class="comments"><span><a href="{{ route('article.show', ['alias', $article->alias]) }}#respond" title="Comment on Section shortcodes &amp; sticky posts!">{{ count($article->comments) ? count($article->comments) : '0' }} {{ \Illuminate\Support\Facades\Lang::choice('ru.comments', count($article->comments)) }}</a></span></p>
                </div>
                <div class="the-content group">
                    {!! $article->desc !!}
                    <p><a href="{{ route('article.show', ['alias' => $article->alias]) }}" class="btn   btn-beetle-bus-goes-jamba-juice-4 btn-more-link">{{ \Illuminate\Support\Facades\Lang::get('ru.read_more') }}</a></p>
                </div>
                <div class="clear"></div>
            </div>
        @endforeach

    <div class="general-pagination group">
        @if($articles->lastPage() > 1)
            @if($articles->currentPage() !== 1)
                <a href="{{ $articles->url($articles->currentPage() - 1) }}">&laquo;</a>
            @endif
                @for($i = 1; $i <= $articles->lastPage(); $i++)
                    @if($articles->currentPage() == $i)
                        <a class="selected disabled">{{ $i }}</a>
                    @else
                        <a href="{{ $articles->url($i) }}">{{$i}}</a>
                    @endif
                @endfor
                @if($articles->currentPage() !== $articles->lastPage())
                <a href="{{ $articles->url($articles->currentPage() + 1) }}">&raquo;</a>
                @endif
        @endif
    </div>
    @else
        {!! \Illuminate\Support\Facades\Lang::get('ru.articles_no') !!}
    @endif
</div>
