@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center bg-gray-100 px-6 py-4 border-b">
            <h3 class="text-xl font-semibold text-gray-700"><i class="fas fa-tasks"></i> Task List</h3>
            <div class="ml-auto flex space-x-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center" onclick="openTaskModal()">
                    <i class="fas fa-plus mr-2"></i> Add Task
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center" id="completedTask">
                    <i class="fas fa-plus mr-2"></i> Completed Task
                </button>
            </div>
        </div>

        <div class="p-4">
            <div class="mb-4 flex space-x-4">
                <input type="text" id="filterTitle" placeholder="Filter by Title" class="px-3 py-2 border rounded w-1/3">
                <select id="filterPriority" class="px-3 py-2 border rounded w-1/3">
                    <option value="">Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
                <select id="filterStatus" class="px-3 py-2 border rounded w-1/3">
                    <option value="">Select Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded" onclick="filterTasks()">Filter</button>
                <button id="resetFilters" class="bg-blue-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Reset </button>

            </div>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-center">
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Priority</th>
                        <th class="p-3 border">Due Date</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="taskTable" class="text-gray-700 text-center">
                    <tr id="noTasksRow" class="border">
                        <td colspan="5" class="p-3 text-gray-500">No tasks found</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <x-pagination></x-pagination>

    </div>
</div>

<div id="taskModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center border-b pb-3">
            <h5 class="text-lg font-semibold" id="modalTitle">Add Task</h5>
            <button class="text-gray-500 hover:text-gray-700" onclick="closeTaskModal()">&times;</button>
        </div>
        <div class="mt-4">
            <form id="taskForm">
                <input type="hidden" id="task_id">
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Title</label>
                    <input type="text" placeholder="Enter title of task" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" id="title" required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Description</label>
                    <textarea placeholder="Enter description of task" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" id="description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Priority</label>
                    <select class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" id="priority">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Due Date</label>
                    <input type="date" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" id="due_date" required>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                    <i class="fas fa-save"></i> Save Task
                </button>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
    function tableActionData(task) {
        return `<tr class="border">
            <td class="p-3 border">${task.title}</td>
            <td class="p-3 border"><span class="px-2 py-1 text-white rounded ${task.priority == 'High' ? 'bg-red-500' : task.priority == 'Medium' ? 'bg-yellow-500' : 'bg-green-500'}">${task.priority}</span></td>
            <td class="p-3 border">${task.due_date}</td>
            <td class="p-3 border"><span class="px-2 py-1 text-white rounded ${task.status == 'Completed' ? 'bg-green-500' : 'bg-gray-500'}">${task.status}</span></td>
            <td class="p-3 border flex justify-center space-x-2">
                <!-- Edit Button -->
            <button class="bg-yellow-500 text-white px-3 py-1 rounded flex items-center space-x-1" onclick="editTask(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                </svg>
            </button>

            <!-- Delete Button -->
            <button class="bg-red-500 text-white px-3 py-1 rounded flex items-center space-x-1" onclick="deleteTask(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-2 14H7L5 6m5 4v6m4-6v6M10 2l4 0" />
                </svg>
            </button>

            <!-- Mark as Completed Button -->
                ${task.status !== 'Completed' ? `
            <button class="bg-green-500 text-white px-3 py-1 rounded flex items-center space-x-1" onclick="markAsCompleted(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                
            </button>
            ` : ''}
            </td>
        </tr>`;
    }

    function noData() {
        return `<tr class="border"><td colspan="5" class="p-3 text-gray-500">No tasks found</td></tr>`;
    }

    function fetchTasks(page = 1) {
        showLoader();
        $.get(`/api/tasks?page=${page}`, function(response) {
            $('#taskTable').empty();
            if (response.data.length === 0) {
                $('#taskTable').html(noData());
            } else {
                response.data.forEach(task => {
                    $('#taskTable').append(tableActionData(task));
                });
            }
            generatePagination(response);
            hideLoader();
        });
    }

    function openTaskModal() {
        $('#task_id').val('');
        $('#modalTitle').text('Add Task');
        $('#taskForm')[0].reset();
        $('#taskModal').removeClass('hidden').addClass('flex');
    }

    function closeTaskModal() {
        $('#taskModal').addClass('hidden');
    }

    function editTask(id) {
        showLoader();
        $.get('/api/tasks/' + id, function(task) {
            $('#task_id').val(task.id);
            $('#modalTitle').text('Edit Task');
            $('#title').val(task.title);
            $('#description').val(task.description);
            $('#priority').val(task.priority);
            $('#due_date').val(task.due_date);
            $('#taskModal').removeClass('hidden').addClass('flex');
            hideLoader();
        });
    }

    $('#taskForm').submit(function(e) {
        e.preventDefault();
        showLoader();

        let id = $('#task_id').val();
        let url = id ? `/api/tasks/${id}` : '/api/tasks';
        let type = id ? 'PUT' : 'POST';

        // Clear previous error messages
        $('.error-message').remove();
        $('#formError').addClass('hidden').text('');

        $.ajax({
            url: url,
            type: type,
            data: {
                title: $('#title').val(),
                description: $('#description').val(),
                priority: $('#priority').val(),
                due_date: $('#due_date').val()
            },
            success: function() {
                closeTaskModal();
                fetchTasks();
            },
            error: function(xhr) {
                hideLoader();
                if (xhr.status === 422) { // Laravel validation error
                    let errors = xhr.responseJSON.errors;
                    $('#formError').removeClass('hidden').text('Please fix the errors below.');

                    $.each(errors, function(key, messages) {
                        $(`#${key}`).after(`<span class="error-message text-red-500 text-sm">${messages[0]}</span>`);
                    });
                } else {
                    $('#formError').removeClass('hidden').text('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                hideLoader();
            }
        });
    });

    function markAsCompleted(id) {
        showLoader();
        $.ajax({
            url: `/api/tasks/${id}/complete`,
            type: 'PATCH',
            success: function(response) {
                alert(response.message);
                filterTasks(); // refresh the list
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Something went wrong');
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function deleteTask(id) {
        if (confirm("Are you sure you want to delete this task?")) {
            showLoader();
            $.ajax({
                url: `/api/tasks/${id}`,
                type: 'DELETE',
                success: function() {
                    fetchTasks();
                    showToast(response.message, 'success');

                },
                error: function() {
                    showToast("Failed to delete task. Please try again.", 'error');
                },
                complete: function() {
                    hideLoader();

                }
            });
        }
    }

    function filterTasks(filterStatus = null) {
        let title = $('#filterTitle').val();
        let priority = $('#filterPriority').val();
        let status = filterStatus ?? $('#filterStatus').val();

        showLoader();

        $.ajax({
            url: '/api/tasks',
            type: 'GET',
            data: {
                title: title,
                priority: priority,
                status: status
            },
            success: function(response) {
                $('#taskTable').empty();

                if (response.data.length === 0) {
                    $('#taskTable').html(noData());
                } else {
                    response.data.forEach(task => {
                        $('#taskTable').append(tableActionData(task));
                    });
                }
            },
            error: function(xhr) {
                console.error("Error fetching tasks:", xhr);
            },
            complete: function() {
                hideLoader();
            }
        });
    }



    // Reset filters
    $('#resetFilters').click(function() {
        window.location.reload();
    });

    $('#completedTask').click(function() {
        filterTasks('Completed');
        $('#filterStatus').val('Completed');
    });



    $(document).ready(fetchTasks);
</script>
@endpush
@endSection