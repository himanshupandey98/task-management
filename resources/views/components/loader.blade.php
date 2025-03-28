<div id="loader" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="w-16 h-16 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
</div>

@push('scripts')
<script>
    function showLoader() {
        $('#loader').removeClass('hidden');
    }

    function hideLoader() {
        $('#loader').addClass('hidden');
    }
</script>
@endpush