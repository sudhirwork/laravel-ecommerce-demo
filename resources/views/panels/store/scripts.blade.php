<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset(mix('js/app.js')) }}"></script>
<script src="{{ asset(mix('js/pnotify.min.js')) }}"></script>

<script>
    function checkcart()
    {
        new PNotify({text: 'Cart is empty.', styling: 'fontawesome', icon: 'fa-solid fa-cart-shopping', animateSpeed: 'fast', closer: false, delay: '3000', type: 'info'});
    }

    function checkauth()
    {
        new PNotify({text: 'Please login first.', styling: 'fontawesome', icon: 'fa-solid fa-right-to-bracket', animateSpeed: 'fast', closer: false, delay: '3000', type: 'warning'});

        setTimeout(function () {
            window.location = "/home/login";
        }, 1500);
    }
</script>

@yield('script')


