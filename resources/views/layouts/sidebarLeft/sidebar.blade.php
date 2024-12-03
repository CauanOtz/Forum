<div class="sidebar">
        <div class="sidebar-menu">
            <h2>MENU</h2>
            <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('home') }}"><i class="fa-regular fa-compass"></i>Explore Topics</a>
            <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('showTags') }}" ><i class="fa-solid fa-tag"></i>Tags</a>
        </div>
        <div class="sidebar-personalnav">
            <h2>PERSONAL NAVIGATOR</h2>
                <a href="{{ route('question') }}">
                    <p class="menu-item"><i class="fa-regular fa-circle-question"></i>My Questions</p>
                </a>
                <!-- <a href="{{ route('answers') }}">
                    <p class="menu-item"><i class="fa-regular fa-comments"></i>My Answers</p>
                </a>
                <a href="{{ route('likes') }}">
                    <p class="menu-item"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
                </a>  Sem funcionamento (Em desenvolvimento) -->
        </div>
        <div class="sidebar-premium">

        </div>
    </div>