<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>

<style>
    #loader {
        z-index: 9999;
        /* Ensure the loader is on top */
    }

    #taskModal {
        z-index: 10;
        /* Keep modal above other elements but below loader */
    }
</style>

<body class="relative">

    @include('layouts.header')
    <x-loader></x-loader>
    @yield('content')



    <script>
        // Fetch tasks on page load
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <!-- JavaScript Stack -->
    @stack('scripts')
</body>

</html>