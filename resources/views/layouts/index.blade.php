@extends('layouts.master')
@section('title')
Home
@endsection

@section('add-script')
@parent

<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400" rel="stylesheet">

<!-- Animate.css -->
<link rel="stylesheet" href="{{asset('template/education/css/animate.css')}}">
<!-- Icomoon Icon Fonts-->
<link rel="stylesheet" href="{{asset('template/education/css/icomoon.css')}}">
<!-- Bootstrap  -->
<link rel="stylesheet" href="{{asset('template/education/css/bootstrap.css')}} ">

<!-- Magnific Popup -->
<link rel="stylesheet" href="{{asset('template/education/css/magnific-popup.css')}} ">

<!-- Owl Carousel  -->
<link rel="stylesheet" href="{{asset('template/education/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('template/education/css/owl.theme.default.min.css')}}">

<!-- Flexslider  -->
<link rel="stylesheet" href="{{asset('template/education/css/flexslider.css')}}">

<!-- Pricing -->
<link rel="stylesheet" href="{{asset('template/education/css/pricing.css')}}">

<!-- Theme style  -->
<link rel="stylesheet" href="{{asset('template/education/css/style.css')}}">

<!-- Modernizr JS -->
<script src="{{asset('template/education/js/modernizr-2.6.2.min.js')}}"></script>
<!-- FOR IE9 below -->
<!--[if lt IE 9]>
<script src="js/respond.min.js"></script>
<![endif]-->
<!-- jQuery -->
<script src="{{asset('template/education/js/jquery.min.js')}}"></script>
<!-- jQuery Easing -->
<script src="{{asset('template/education/js/jquery.easing.1.3.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('template/education/js/bootstrap.min.js')}}"></script>
<!-- Waypoints -->
<script src="{{asset('template/education/js/jquery.waypoints.min.js')}}"></script>
<!-- Stellar Parallax -->
<script src="{{asset('template/education/js/jquery.stellar.min.js')}}"></script>
<!-- Carousel -->
<script src="{{asset('template/education/js/owl.carousel.min.js')}}"></script>
<!-- Flexslider -->
<script src="{{asset('template/education/js/jquery.flexslider-min.js')}}"></script>
<!-- countTo -->
<script src="{{asset('template/education/js/jquery.countTo.js')}}"></script>
<!-- Magnific Popup -->
<script src="{{asset('template/education/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('template/education/js/magnific-popup-options.js')}}"></script>
<!-- Count Down -->
<script src="{{asset('template/education/js/simplyCountdown.js')}}"></script>
<!-- Main -->
<script src="{{asset('template/education/js/main.js')}}"></script>
<script>
    var d = new Date(new Date().getTime() + 1000 * 120 * 120 * 2000);

    // default example
    simplyCountdown('.simply-countdown-one', {
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate()
    });

    //jQuery example
    $('#simply-countdown-losange').simplyCountdown({
        year: d.getFullYear(),
        month: d.getMonth() + 1,
        day: d.getDate(),
        enableUtc: false
    });
</script>

@endsection



@section('content')
    <div class="fh5co-loader"></div>

    <div id="page">
        <nav class="fh5co-nav" role="navigation">
            <div class="top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-right">
                            <p class="site"></p>
                            <p class="num"></p>
                            <ul class="fh5co-social">
                                <li><a href=""><i class="icon-facebook2"></i></a></li>
                                <li><a href=""><i class="icon-twitter2"></i></a></li>
                                <li><a href=""><i class="icon-dribbble2"></i></a></li>
                                <li><a href=""><i class="icon-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @include('headers.default')
        </nav>

        <aside id="fh5co-hero">
            <div class="flexslider">
                <ul class="slides">
                    <li style="background-image: url({{asset('template/education/images/img_bg_1.jpg')}});">
                        <div class="overlay-gradient"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center slider-text">
                                    <div class="slider-text-inner">
                                        <h1>The Roots of Education are Bitter, But the Fruit is Sweet</h1>
                                        <p><a class="btn btn-primary btn-lg" href="{{url('/courses')}}">Start Learning Now!</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li style="background-image: url({{asset('template/education/images/img_bg_2.jpg')}} );">
                        <div class="overlay-gradient"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center slider-text">
                                    <div class="slider-text-inner">
                                        <h1>The Great Aim of Education is not Knowledge, But Action</h1>
                                        <p><a class="btn btn-primary btn-lg btn-learn" href="{{url('/courses')}}">Start Learning Now!</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li style="background-image: url({{asset('template/education/images/img_bg_3.jpg')}} );">
                        <div class="overlay-gradient"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center slider-text">
                                    <div class="slider-text-inner">
                                        <h1>We Help You to Learn New Things</h1>
                                        <p><a class="btn btn-primary btn-lg btn-learn" href="{{url('/courses')}}">Start Learning Now!</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>

        <div id="fh5co-course-categories">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
                        <h2>Course Categories</h2>
                        {{-- <p>Jenis-jenis kategori agenda Tclassroom</p> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
							<span class="icon">
                                <i class="icon-book"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 1</a></h3>
                                {{-- <p>Agenda mengenai materi semester 1</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-file"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 2</a></h3>
                                {{-- <p>Agenda mengenai materi semester 2</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-group"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 3</a></h3>
                                {{-- <p>Agenda mengenai materi semester 3</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-pencil"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 4</a></h3>
                                {{-- <p>Agenda mengenai materi semeter 4</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-user"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 5</a></h3>
                                {{-- <p>Agenda mengenai materi semester 5</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-home-outline"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 6</a></h3>
                                {{-- <p>Agenda mengenai materi semester 6</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-bubble3"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 7</a></h3>
                                {{-- <p>Agenda mengenai materi semester 7</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 text-center animate-box">
                        <div class="services">
                            <span class="icon">
                                <i class="icon-world"></i>
                            </span>
                            <div class="desc">
                                <h3><a href="">Semester 8</a></h3>
                                {{-- <p>Agenda mengenai materi semester 8</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <footer id="fh5co-footer" role="contentinfo" style="background-image: url({{asset('template/education/images/img_bg_4.jpg')}});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row row-pb-md">
                    <div class="col-md-2 fh5co-widget">
                    </div>
                    <div class="col-md-3 fh5co-widget text-center">
                            <h3>About Tclassroom</h3>
                            <p>Tclassroom merupakan sebuah platform E-Learning berbasis classroom yang dapat digunakan untuk berbagai macam kebutuhan pendidikan</p>
                        
                    </div>

                    <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
                    </div>

                    <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
                            <h3>Learning</h3>
                            <ul class="fh5co-footer-links">
                                <li><a href="">Course</a></li>
                            </ul>
                    </div>

                    <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
                    </div>
                </div>

                <div class="row copyright">
                    <div class="col-md-12 text-center">
                        <p>
                            <small class="block">&copy; 2019</small>
                            <small class="block">Designed by Tclassroom Team </small>
                        </p>
                    </div>
                </div>

            </div>
        </footer>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>


