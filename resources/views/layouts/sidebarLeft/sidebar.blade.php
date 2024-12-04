<div class="sidebar">

    <div class="sidebar-categories-tags">
        <div class="categories-section">
            <h2><i class="fa-regular fa-folder icon"></i>CATEGORIES</h2>
            @if($categories->isNotEmpty())
            <ul>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('show', $category->id) }}">
                        {{ $category->title }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p>No categories available.</p>
            @endif
        </div>

        <div class="tags-section">
            <h2><i class="fa-solid fa-tag icon"></i>POPULAR TAGS</h2>
            @if($tags->isNotEmpty())
            <div class="tags">
                @foreach($tags as $tag)
                <a href="{{ route('listTagById', $tag->id) }}" class="tag-item">
                    {{ $tag->title }}
                </a>
                @endforeach
            </div>
            @else
            <p>No tags available.</p>
            @endif
        </div>
    </div>
    <div class="sidebar-menu">
        <h2>MENU</h2>
        <a href="{{ route('question') }}">
            <p class="menu-item"><i class="fa-regular fa-circle-question"></i>My Questions</p>
        </a>
    </div>
</div>