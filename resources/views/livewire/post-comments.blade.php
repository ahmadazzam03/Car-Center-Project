<div class="pt-10 mt-10 border-t border-gray-100 comments-box">
    <h2 class="mb-5 text-2xl font-semibold text-gray-900 my-large">Discussions</h2>
    @auth
    <form wire:submit.prevent="addComment">
        <textarea 
        wire:model="comment" class="my-large"
            cols="30" rows="10" required id="comment" style="resize:none">
        </textarea>
        <button type="submit" class="btn btn-primary ">
        Post Comment
        </button>
</form>
    @else
        <a wire:navigate 
        class="py-1 text-yellow-500 underline my-large" 
        href="{{ route('login') }}"> Login to Post Comments</a>
    @endauth
    {{-- Display Comment  --}}
    <div class="px-3 py-2 mt-5 user-comments">
        <h2 class="mb-5 text-xl font-semibold text-gray-900 my-large">Comment :</h2>
        @if ($comments->count() > 0)
        @foreach($comments as $comment)

        <div class="comment">
            <div class="user-avatar">
                <img src="{{$comment->user->profile_image ? asset('storage/' . $comment->user->profile_image) :  
                    asset('/img/avatar.png')}}"  
                class="avatar-img">
            </div>
            <div>
                <strong>{{$comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
                <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <hr>
        @endforeach
        @else
        <div class="text-center text-gray-500">
            <span> No Comments Posted</span>
        </div>
        @endif
    </div>

    <div class="my-2">
        {{ $comments->onEachSide(1)->links() }}
    </div>
</div>