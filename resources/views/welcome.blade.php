<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bistro 8</title>
    <link rel="icon" href="{{asset('img/Picture1.png')}}" type="image/icon type">
        <meta name="keyword" content="Italian Restaurant, Italian Food"/>
    <meta name="description" content="Taste of Italian" />
      <meta name="author" content="Marco Polo Sanchez">
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js','resources/css/app.css'])

</head>

<body>
    @include('partials.header')

    <section>
        <div id="carouselResto" class="carousel slide carousel-fade">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselResto" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselResto" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselResto" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('img/carousel-1.jpg')}}" class="d-block w-100 carousel-image" alt="Bistro 8 Carousel 1">
                    <div class="carousel-caption">
                        <img class="img-fluid carousel-logo-main" src="{{asset('img/logo.png')}}" alt="Bistro8 Logo">
                        <h1 class="text-center mt-3"><span class="title-font title-size">Bistro 8</span></h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('img/carousel-2.jpg')}}" class="d-block w-100 carousel-image" alt="Bistro 8 Carousel 2">
                
                </div>
                <div class="carousel-item">
                    <img src="{{asset('img/carousel-3.jpg')}}" class="d-block w-100 carousel-image" alt="Bistro 8 Carousel 3">
                   
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselResto" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselResto" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- About Section -->

    <section id="about" class="py-5 animation">
        <div class="container">
            <h2 class="text-center">About Us</h2>

            <div class="row">
                <div class="col-md-6 text-center"><img class="img-fluid" src="{{asset('img/logo-with-background.png')}}" alt="Bistro8 Logo">
                    <h3>Open Hours</h3>
                    <p>MONDAY &dash; SUNDAY</p>
                    <p>11 AM &dash; 11 PM</p>
                </div>

                <div class="col-md-6 ">
                    <h3 class="text-center"><b>Welcome to Bistro 8 Italian Restaurant!</b></h3>
                    <p>Located in the bustling heart of Angeles City Pampanga, Bistro 8 offers a unique dining experience that seamlessly blends the rich traditions of Italian cuisine with the delicate flavors of Japanese fare. Since opening in April 2023, we have been dedicated to bringing the best of both worlds to our guests.
                        <br><br>
                    <h4><b>Atmosphere&colon;</b></h4> Bistro 8 boasts a refined yet cozy ambiance, perfect for any occasion. Whether you&CloseCurlyQuote;re planning a romantic dinner, a family celebration, or a casual meal with friends, our elegant decor and warm lighting create the ideal setting for a memorable dining experience.
                    <br><br>
                    <h4> <b>Cuisine&colon;</b></h4> Our menu features a wide range of Italian classics and Japanese specialties. From brick-oven baked pizzas and freshly made pastas to sushi rolls and tempura, each dish is prepared with the finest ingredients to ensure authenticity and quality. Highlights include our signature Margherita pizza, creamy Risotto ai Funghi, delicate Nigiri sushi, and savory Ramen bowls.
                    <br><br>
                    <h4> <b>Drinks&colon;</b></h4> Complement your meal with a selection from our extensive wine list, featuring both local and Italian wines. We also offer a variety of handcrafted cocktails, premium sake, and refreshing beverages to enhance your dining experience.
                    <br><br>
                    <h4><b>Service&colon;</b></h4> At Bistro 8, we pride ourselves on providing exceptional service. Our friendly and knowledgeable staff are here to ensure that your dining experience is nothing short of perfect. Whether you&CloseCurlyQuote;re a regular guest or visiting for the first time, we strive to make you feel welcome and valued.
                    <br><br>
                    Join us at Bistro 8 Italian Restaurant, where every meal is a celebration of culinary artistry from Italy and Japan. Buon appetito and Itadakimasu!
                    </p>

                </div>
            </div>

        </div>

    </section>
    <section id="contact" class="py-5 bg-dirty-white animation">
        <div class="container">
            <h2 class="text-center">Contact Us</h2>
            <p class="text-center">Get in touch with us for reservations and inquiries.</p>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="ratio ratio-16x9 ">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15403.2948955934!2d120.5940844!3d15.1680225!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396ed8e078be665%3A0xba4ee6522c8a3f6f!2sBistro%208%20Italian%20Restaurant!5e0!3m2!1sen!2sph!4v1723106826551!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
                <div class="col-md-6 ">
                    <form action="{{route('bistro.inquire')}}" method="post" id="inquireForm">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="inquire" class="form-label">Inquire &sol; Reservation</label>
                            <textarea class="form-control" name="inquire" id="inquire" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mt-2 float-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section id="menu" class="py-5 container animation">
        <h2 class="text-center"> Get in Touch</h2>
        <div class="row text-center">

            <div class="col-md-4">
                <h3>Give us a call:</h3>
                <p><i class="bi bi-telephone-fill"></i>0969&dash;576&dash;5886</p>
            </div>
            <div class="col-md-4">
                <h3>Send us an Email:</h3>
                <p><i class="bi bi-envelope-fill"></i>info@b8-italian.com</p>
            </div>
            <div class="col-md-4">
                <h3>Visit us on Facebook:</h3>
                <p><a href='https://www.facebook.com/profile.php?id=100095718094315'>Facebook.com/Bistro8</a></p>
            </div>
        </div>
    </section>


  @include('partials.footer')

    <script type="module">
        $(document).ready(function() {
            let prevScroll = $(window).scrollTop();
            $(window).on('scroll', function() {
                let currentScroll = $(window).scrollTop();
                if (prevScroll > currentScroll) {
                    $('.fixed-top').css('top', '0');
                } else {
                    $('.fixed-top').css('top', '-57px');
                }
                prevScroll = currentScroll;
            });
        });

        const $animation = $('.animation');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('scroll-animation')
                } else {
                    entry.target.classList.remove('scroll-animation')
                }

            })
        }, {
            threshold: 0.3
        });
        //
        $animation.each(function() {
            observer.observe(this);
        });
        $('#inquireForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want send an Inquire?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {

                if (result.isConfirmed) {
                    Swal.fire({

                        icon: 'info',
                        title: 'Sending',
                        text: "Processing.....",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }

                    })
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {

                            if (data.code == 0) {
                                $.each(data.error, function(prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val[0]);
                                });
                            } else if (data.code == 1) {
                                $(form)[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully!',
                                    text: data.msg,
                                    timer: 3500
                                })
                            } else if (data.code == 2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'info!',
                                    text: data.msg,
                                    timer: 3500
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oopss..',
                                    text: data.msg,
                                    timer: 3500
                                });
                            }
                        }
                    })



                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        })
    </script>
</body>

</html>