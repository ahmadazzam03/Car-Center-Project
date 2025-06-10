<x-admin-app title="Inbox Page" >
    <!-- MAIN CONTAINER  -->
    <div class="main-container">
        <!-- TITLE  -->
        <div class="title">
            <p>
            <a href="{{route('admin.dashboard')}}"><span>Dashboard</span></a>
            <i class="bx bx-right-arrow-alt"></i>
            Car Center
            </p>
            <select class="sort-dropdown my-large" style="float:right">
                <option value="">Order By</option>
                <option value="created_at">Newest At the top</option>
                <option value="-created_at">Oldest At the top</option>
                <option value="user_name">user Name Asc</option>
                <option value="-user_name">user Name Desc</option>
                <option value="subject">Subject Asc</option>
                <option value="-subject">Subject Desc</option>
                <option value="message">Message Asc</option>
                <option value="-message">Message Desc</option>
                
            </select>
            <h3>Admin Inbox </h3>
        </div>
        <div class="email-list">
            @forelse($inboxes as $inbox)
            <div class="email-item unread">
                <i class='bx bx-envelope'></i>
                <div class="email-content">
                    <h3>{{$inbox->name}}</h3>
                    <h3>{{$inbox->email}}</h3>
                    <p>{{$inbox->subject}}</p>
                    <p>{{$inbox->message}}</p>
                </div>
                <span class="email-time">{{$inbox->created_at}}</span>
                <div class="email-actions">
                    <i class='bx bx-reply star-icon'></i>
                    {{-- <i class='bx bx-trash'></i> --}}
                    {{-- <i class='bx bx-star'></i> --}}
                </div>
            </div>
            @empty
            <div colspan="5" class="text-center p-large">
                You don't have any Inbox yet. 
            </div>
            @endforelse
        </div>
    </div>
    <div class="backdrop-filter"></div>
</x-admin-app>