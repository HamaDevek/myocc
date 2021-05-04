<!DOCTYPE html>
<html lang="en">

<head>
    @include('settings.layout.head')
</head>

<body>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @include('settings.layout.head',['title' => $title])
</head>

<body>
    @include('settings.layout.navbar')
    <div class="container-fluid  " style="height: 90vh;">
        <div class="row " style="height: 90vh;">
            @include('settings.layout.sidebar')
            <div class="col-sm-8 col-lg-9 col-xl-10 pt-3  " style="height: 90vh;overflow-y: scroll;">

                <div class="card" style="border:0px ">
                    @yield('title')
                    <div class="card-body">

                        @yield('content')
                        
                    </div>
                </div>
            </div>
            <div style="height:300px">
            </div>
        </div>


    </div>
    @include('settings.layout.script')
</body>

</html>