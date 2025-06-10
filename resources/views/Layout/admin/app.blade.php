{{-- To define a variable in this file that get it from another file  --}}
@props(['title'=>'','bodyClass'=> null,])
<x-admin-base :$title :$bodyClass>
    <x-layouts.admin.header/>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @session('warning')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ session('warning') }}',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endsession
        {{$slot}}
</x-admin-base>