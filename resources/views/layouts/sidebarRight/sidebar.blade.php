<div class="sidebar">
    <div class="topics">
        <button data-bs-toggle="modal" data-bs-target="#createTopicModal"><i class="fa-solid fa-plus"></i>Start a New
            Topic</button>
    </div>
    <div class="suggestions">
        <h3>Suggestions</h3>
        <div class="suggestions-users">
            @foreach($suggestedUsers as $user)
            <div class="user">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/user.png') }}" alt="">
                <p class="font-color">{{ $user->name }}</p>

                <form action="{{ route('person', ['id' => $user->id]) }}" method="GET">
                    <button type="submit">Profile</button>
                </form>

            </div>
            @endforeach
        </div>
    </div>
</div>

@include('components.modals.home.createTopicHomeModal')