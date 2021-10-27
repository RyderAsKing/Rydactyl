<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ env('APP_NAME') }}</title>
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    </head>

    <body>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 40 40" display="none" width="0" height="0">
            <symbol id="icon-967" viewBox="0 0 40 40">
                <path
                    d="M13,32.1c-0.5-0.5-1.1-0.7-1.9-0.7s-1.4,0.2-1.9,0.7c-0.5,0.5-0.7,1.1-0.7,1.9c0,0.7,0.2,1.4,0.7,1.9 c0.5,0.5,1.1,0.7,1.9,0.7s1.4-0.2,1.9-0.7c0.5-0.5,0.7-1.1,0.7-1.9S13.5,32.6,13,32.1z M31.2,32.1c-0.5-0.5-1-0.7-1.8-0.7 s-1.4,0.2-1.9,0.7c-0.5,0.5-0.7,1.1-0.7,1.9c0,0.7,0.2,1.4,0.7,1.9s1.1,0.7,1.9,0.7s1.4-0.2,1.9-0.7c0.5-0.5,0.7-1.1,0.7-1.9 S31.7,32.6,31.2,32.1z M34.2,9.8c-0.2-0.2-0.5-0.4-0.9-0.4H8.9c0-0.1,0-0.3-0.1-0.5c0-0.3-0.1-0.5-0.1-0.6c0-0.1-0.1-0.3-0.2-0.5 c0-0.2-0.1-0.4-0.2-0.5C8.1,7.1,8,7,7.8,6.9C7.6,6.8,7.4,6.8,7.2,6.8H2c-0.3,0-0.6,0.1-0.9,0.4C0.7,7.6,0.7,7.8,0.7,8.1 c0,0.3,0.1,0.6,0.4,0.9s0.5,0.4,0.9,0.4h4.2l3.5,17.8c0,0.1-0.1,0.3-0.3,0.6c-0.2,0.3-0.3,0.6-0.4,0.8c-0.1,0.2-0.2,0.4-0.3,0.7 c-0.1,0.3-0.2,0.5-0.2,0.6c0,0.3,0.1,0.6,0.4,0.9c0.2,0.2,0.5,0.4,0.9,0.4h20.9c0.3,0,0.6-0.1,0.9-0.4c0.2-0.2,0.4-0.5,0.4-0.9 c0-0.4-0.1-0.6-0.4-0.9c-0.2-0.2-0.5-0.4-0.9-0.4H12.1c0.3-0.6,0.5-1,0.5-1.4c0-0.1-0.1-0.6-0.3-1.5l21.3-2.5c0.3,0,0.6-0.2,0.8-0.4 c0.2-0.2,0.3-0.5,0.3-0.8V10.7C34.7,10.4,34.5,10.1,34.2,9.8z">
                </path>
            </symbol>
        </svg>
        <div id="wrapper">
            <div id="main">
                <div class="inner">
                    <div id="container06" class="container default full screen">
                        <div class="wrapper">
                            <div class="inner">
                                <h1 id="text24">{{ env('APP_NAME') }}</h1>
                                <p id="text18">Hosting was never so easy before. You can deploy your own new server with
                                    a few
                                    clicks!</p>
                                <ul id="buttons01" class="buttons">
                                    @auth
                                    <li><a href="{{ route('dashboard') }}" class="button n01"><span
                                                class="label">Dashboard</span></a></li>
                                    @endauth
                                    @guest
                                    <li><a href="{{ route('login') }}" class="button n01"><span class="label">Login
                                                Now <img style="height: 20px" src="{{ asset('images/discord.png') }}"
                                                    alt=""></span></a></li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="container12" class="container default full">
                        <div class="wrapper">
                            <div class="inner">
                                <h2 id="text39" class="style1">Features</h2>
                                <p id="text58" class="style6">And why would you choose us? Here's why
                            </div>
                        </div>
                    </div>
                    <div id="container07" class="container columns full">
                        <div class="wrapper">
                            <div class="inner">
                                <div>
                                    <h2 id="text57" class="style3">No hidden charges</h2>
                                    <p id="text58" class="style6">With {{ env('APP_NAME') }} you can host your server
                                        with no
                                        hidden charges.</p>
                                </div>
                                <div>
                                    <h2 id="text60" class="style3">High speed RAM</h2>
                                    <p id="text66" class="style6">We provide free 2 GB DDR4 fast memory for your free
                                        server.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="container14" class="container default full">
                        <div class="wrapper">
                            <div class="inner">
                                <h3 id="text25" class="style5">Wanna know more?</h3>
                                <h2 id="text17" class="style1">How it works</h2>
                                <p id="text22" class="style4">We display ads on our website which in turn gives us funds
                                    which
                                    are then used to fund this awesome project.</p>
                            </div>
                        </div>
                    </div>
                    <div id="container05" class="container columns full">
                        <div class="wrapper">
                            <div class="inner">
                                <div>
                                    <div id="image04" class="style2 image"><img src={{ asset('images/landing.svg') }}
                                            alt="">
                                    </div>
                                </div>
                                <div>
                                    <h2 id="text37" class="style2">Why do we do this?</h2>
                                    <p id="text21" class="style6">Simply because we know that not every one can afford a
                                        premium
                                        server so we do that for you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="container03" class="container default full">
                        <div class="wrapper">
                            <div class="inner">
                                <h2 id="text04" class="style1">How can we help?</h2>
                                <p id="text27" class="style4">Just do not block the ads ;(, we are only able to continue
                                    running
                                    this amazing project through the revenue gained by the advertisements</p>
                            </div>
                        </div>
                    </div>
                    <div id="container04" class="container default full screen">
                        <div class="wrapper">
                            <div class="inner">
                                <p id="text16" class="style6">© {{ env('APP_NAME') }} All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>