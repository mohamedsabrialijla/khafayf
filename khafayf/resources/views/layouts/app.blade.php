<!DOCTYPE html>
@include('layouts.head')   
<body>
    <div class="main-wrapper">
        <!--start_header-->
        @include('layouts.header')
        <!--End_header-->
        <div class="content-page">
            @yield("content")
        </div><!--content-page-->
        <!--start_footer-->
        @include('layouts.footer')
        <!--End_footer-->
    </div><!--main-wrapper--> 
    <script src="{{url('front_end/js/bootstrap.min.js')}}"></script>
    <script src="{{url('front_end/js/owl.carousel.min.js')}}" type="text/javascript"></script>
    <script src="{{url('front_end/js/moment.js')}}"></script>
    <script src="{{url('front_end/js/script.js')}}"></script>
    @yield('js')
</body>
</html> 