<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bistro 8 - Menu</title>
    <link rel="icon" href="{{asset('img/Picture1.png')}}" type="image/icon type">
    <meta name="keyword" content="Italian Restaurant, Italian Food"/>
    <meta name="description" content="Taste of Italian" />
      <meta name="author" content="Marco Polo Sanchez">
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js','resources/css/app.css'])

</head>

<body>
    @include('partials.header')



    <!-- About Section -->

    <section class="container text-center mt-5" id="Menu">
        <div class="text-center">
            <h1 class="mt-5 pt-5">Our Menu</h1>
        </div>
        <div class="row" id="dataMenu">

        </div>
        <div class="auto-load text-center">
            <div class="spinner-border text-dark" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </section>


    <!-- Footer -->
   @include('partials.footer')

    <script type="module">
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        let allDataLoaded = false;
        infinteLoadMore(page);

        // $(window).scroll(function() {
        //     if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        //         page++;
        //         infinteLoadMore(page);
        //     }
        // });
        // if ($('html,body').bind('touchmove', function(e) {
        //         page++;
        //         infinteLoadMore(page);
        //     }));
    $(window).on('scroll touchmove',function() {
            if (!allDataLoaded && $(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });
        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "/menu?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();

                    }
                   
                })
                .done(function(response) {
                    if (response.length == 0) {
                        $('.auto-load').html("");
                        return;
                    }
                    $('.auto-load').hide();
                     if (response.length === 0) {
                allDataLoaded = true;
            } else {
                 $("#dataMenu").append(response);
            }
                 
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
</body>

</html>