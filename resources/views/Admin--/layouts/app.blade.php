<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @include('admin.includes.head')

</head>

<body>

    @include('admin.includes.header')

    <div class="row w-100">
        @include('admin.includes.sidebar')

        <!-- <main class="main-content flex-grow-1 p-4"> -->
        <main class="col-10 mt-3">
            @yield('content')
        </main>
    </div>

    @include('admin.includes.footer')

</body>

</html>