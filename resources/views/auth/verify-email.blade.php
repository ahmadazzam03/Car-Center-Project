<x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Please verify your email ',
                text: 'We have sent a verification link to your email address. Please check your inbox.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        });
    </script>

</x-app-layout>