@extends('layouts.header')

@section('content')
<body>
<div class="landing">
    <div class="sidebar">
        <div class="sidebar-menu">
            <h2>Menu</h2>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-solid fa-circle-question"></i>Questions</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-compass"></i>Explore Topics</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-solid fa-tag"></i>Tags</p>
        </div>
        <div class="sidebar-personalnav">
            <h2>Personal Navigator</h2>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-circle-question"></i>My Questions</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-comments"></i>My Answers</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
        </div>
        <div class="sidebar-premium">

        </div>
    </div>
    <div class="center">
        <div class="filters">
            <div class="filters-new filter">
                <p><i class="fa-regular fa-clock"></i>New</p>
            </div>
            <div class="filters-trending filter ">
                <p><i class="fa-solid fa-turn-up"></i>Trending</p>
            </div>
            <div class="filters-category filter">
                <p><i class="fa-solid fa-sliders"></i>Category</p>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-content">
                    <div class="votes">
                        <i class="fa-solid fa-chevron-up"></i>
                        <span class="vote-count">45</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div> 
                    <div class="question">
                        <h3 class="question-title">Which of sci-fi’s favourite technologies would you like to see become a reality?</h3>
                        <p id="question-date">09:00 pm</p>
                        <p class="question-view">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus earum praesentium minus quae hic a? Sequi molestias dignissimos rem? Dolorem cum id fugiat, quas doloremque suscipit ipsa blanditiis voluptates sed!</p>
                    </div>
                    
                </div>
                <div class="views">
                    <p><i class="fa-regular fa-eye"></i>30</p>
                    <p><i class="fa-regular fa-comment"></i>20</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div class="topics">
            <button><i class="fa-solid fa-plus"></i>Start a New Topic</button>
        </div>
        <div class="suggestions">
            <h3>Suggestions</h3>
            <div class="suggestions-users">
                <div class="user">
                    <img src="" alt="">
                    <p>Nome</p>
                    <button><i class="fa-solid fa-plus"></i>Follow</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection