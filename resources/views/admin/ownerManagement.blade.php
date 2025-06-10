<x-admin-app title="Owner Management" >
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
            <option value="user_name">User Name Asc</option>
            <option value="-user_name">User Name Desc</option>
            <option value="created_at">Created At Asc</option>
            <option value="-created_at">Created At Desc</option>
            <option value="phone">Phone Asc</option>
            <option value="-phone">Phone Desc</option>
          </select>
          <h3>Owner Managment</h3>
    
          <div class="table-responsive">
              <table>
                  <thead>
                      <tr>
                        <th>Owner ID</th>
                        <th>User Role</th>
                        <th>Owner Image</th>
                        <th>Owner Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Delete</th>
                      </tr>
                  </thead>
                    <tbody id="userTable">
                      @forelse($users as $user)
                      <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>
                          <img
                            src="{{$user->profile_image ? asset('storage/' . $user->profile_image) :  
                            asset('/img/avatar.png')}}" 
                            style="display: flex;padding:8px;width:120px; border-radius: 12px;"/>
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->getCreateDate()}}</td>
                        <td>
                          <form 
                      id="delete-user-form-{{ $user->id }}"
                      action="{{route('admin.deleteUser',$user)}}"
                      method="POST"
                      class="inline-flex">
                      @csrf
                      @method('DELETE')
                      <button type="button"  
                      onclick="confirmDelete({{ $user->id }}) " 
                      class="reject-btn">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          style="width: 12px; margin-right: 5px"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                          />
                        </svg>
                        Delete
                      </button>
                    </form>
                    <script>
                      function confirmDelete(userId) {
                          Swal.fire({
                              title: "Are you sure?",
                              text: "You won't be able to revert this user!",
                              icon: "warning",
                              showCancelButton: true,
                              confirmButtonColor: "#3085d6",
                              cancelButtonColor: "#d33",
                              confirmButtonText: "Yes, delete it!"
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  document.getElementById('delete-user-form-' + userId).submit();
                              }
                          });
                      }
                  </script>
                        </td>
                        </tr>
                      @empty
                      <tr>
                        <td colspan="5" class="text-center p-large">
                          You don't have any owners yet. 
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
              </table>
          </div>
        </div>
        {{$users->onEachSide(1)->links()}}

      </div>
      <div class="backdrop-filter"></div>
    </x-admin-app>