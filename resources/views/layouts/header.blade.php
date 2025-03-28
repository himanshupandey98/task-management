<div class="flex justify-end items-center mt-3 mr-3">
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</div>

@push('scripts')
<script>
    function logoutUser() {
        $.ajax({
            url: "{{ route('logout') }}",
            type: "POST",
            success: function(response) {
                window.location.href = "{{ route('login') }}"; // Redirect to login after logout
            },
            error: function(xhr) {
                console.error("Logout failed", xhr);
            }
        });
    }
</script>
@endpush