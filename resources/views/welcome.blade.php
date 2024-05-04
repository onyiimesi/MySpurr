<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MySpurr</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    </head>
    <body class="antialiased">
        <!-- Add a button to trigger Google signup -->
        {{-- <button id="google-signup-button">Sign up with Google</button> --}}

        {{-- <div class="flex items-center justify-end mt-4">
            <a class="btn" href="{{ url('/auth/google') }}" style="background: #9e49ff; color: #ffffff; padding: 10px; width: 200px; text-align: center; display: block; border-radius:3px;">
                Login with Google
            </a>
        </div> --}}

        <div>
            <h3>We are live.....</h3>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#google-signup-button').click(function () {
                    window.location.href = '/api/auth/google'; // Replace with the correct API endpoint
                });
            });
        </script>

    </body>
</html>
