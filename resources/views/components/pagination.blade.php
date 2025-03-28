<div id="pagination" class="flex justify-end m-4 space-x-2"></div>

@push('scripts')
<script>
    let currentPage = 1;

    function generatePagination(response) {
        let paginationHtml = '';
        if (response.last_page > 1) {
            paginationHtml += `<button class="px-4 py-2 mx-1 bg-gray-300 rounded ${response.current_page == 1 ? 'opacity-50 cursor-not-allowed' : ''}" onclick="fetchTasks(${response.current_page - 1})">Prev</button>`;

            for (let i = 1; i <= response.last_page; i++) {
                paginationHtml += `<button class="px-4 py-2 mx-1 ${response.current_page == i ? 'bg-blue-500 text-white' : 'bg-gray-300'} rounded" onclick="fetchTasks(${i})">${i}</button>`;
            }

            paginationHtml += `<button class="px-4 py-2 mx-1 bg-gray-300 rounded ${response.current_page == response.last_page ? 'opacity-50 cursor-not-allowed' : ''}" onclick="fetchTasks(${response.current_page + 1})">Next</button>`;
        }
        $('#pagination').html(paginationHtml);
    }
</script>
@endpush