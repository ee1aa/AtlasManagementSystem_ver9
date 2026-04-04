<x-sidebar>
    <div class="board_area w-100 border m-auto d-flex">
        <div class="post_view w-75 mt-5">
            <p class="w-75 m-auto">投稿一覧</p>
            @foreach ($posts as $post)
                <div class="post_area border w-75 m-auto p-3">
                    <p><span>{{ $post->user->over_name }}</span><span
                            class="ml-3">{{ $post->user->under_name }}</span>さん</p>
                    <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
                    <div class="post_bottom_area d-flex">
                        <div class="d-flex post_status">
                            <div class="mr-5">
                                @foreach ($post->subCategories as $subCategory)
                                    <p>{{ $subCategory->sub_category }}</p>
                                @endforeach
                            </div>
                            <div class="mr-5">
                                <i class="fa fa-comment"></i><span
                                    class="">{{ $post->post_comments_count }}</span>
                            </div>
                            <div>
                                @if (Auth::user()->is_Like($post->id))
                                    <p class="m-0"><i class="fas fa-heart un_like_btn"
                                            post_id="{{ $post->id }}"></i><span
                                            class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span></p>
                                @else
                                    <p class="m-0"><i class="fas fa-heart like_btn"
                                            post_id="{{ $post->id }}"></i><span
                                            class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="other_area w-25">
            <div class="m-4">
                <div class=""><a href="{{ route('post.input') }}"
                        class="btn btn_search_post searches mb-3">投稿</a>
                </div>
                <div class="d-inline-flex btn-group searches mb-3">
                    <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest"
                        class="input_keyword">
                    <input type="submit" value="検索" form="postSearchRequest" class="btn btn_search_post">
                </div>
                <div class="d-flex searches mb-3">
                    <input type="submit" name="like_posts" class="category_btn plum p-2" value="いいねした投稿"
                        form="postSearchRequest">
                    <input type="submit" name="my_posts" class="category_btn orange p-2" value="自分の投稿"
                        form="postSearchRequest">
                </div>
                <div class="mb-3">カテゴリー検索</div>
                <ul>
                    @foreach ($categories as $category)
                        <li data-toggle="collapse" data-target="#cat{{ $category->id }}" class="main_categories">
                            <span>{{ $category->main_category }}</span>
                            <span class="toggle"></span>
                        </li>
                        <li>
                            <div id="cat{{ $category->id }}" class="collapse">
                                @foreach ($category->subCategories as $sub)
                                    <input type="submit" name="category_word"
                                        class="btn btn-sm col text-left border-bottom" value="{{ $sub->sub_category }}"
                                        form="postSearchRequest" style="width: 80%">
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    </div>
</x-sidebar>
