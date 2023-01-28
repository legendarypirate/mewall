
<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{asset('admin')}}/dist/images/logo.png" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>Нэвтрэх - MYWALL</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{asset('admin')}}/dist/css/app.css" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{asset('admin')}}/dist/images/logo.svg">
                        <span class="text-white text-lg ml-3"> Core<span class="font-medium">System</span> </span>
                    </a>
                    <div class="my-auto">
                        <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{asset('admin')}}/dist/images/illustration.svg">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                           MYWALL Admin 
                            <br>
                            
                        </div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <form method="POST" action="{{ route('login') }}" style="margin-top:200px;">
                        @csrf
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                           Нэвтрэх
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">Суурь бүртгэлийн систем</div>
                        <div class="intro-x mt-8">
                            <input type="email" name="email" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Имэйл">
                            <input type="password" name="password" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Нууц үг">
                        </div>
                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input type="checkbox" class="input border mr-2" id="remember-me">
                                <label class="cursor-pointer select-none" for="remember-me">Намайг санах</label>
                            </div>
                            @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Нууц үгээ мартсан уу?') }}
                                    </a>
                                @endif
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">

                        <button type="submit" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3 align-top">
                                    {{ __('Нэвтрэх') }}
                                </button>

                           
                                  
                            <button class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 dark:border-dark-5 dark:text-gray-300 mt-3 xl:mt-0 align-top">Бүртгүүлэх</button>
                        </div>
                        <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                            Та бүртгүүлснээр манай
                            <br>
                            <a class="text-theme-1 dark:text-theme-10" href="">Нууцлалын бодлогыг</a> & <a class="text-theme-1 dark:text-theme-10" href="">зөвшөөрч байна</a> 
                        </div>
                    </div>
                </div>
                </form>
                <!-- END: Login Form -->
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
        <div data-url="login-dark-login.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div>
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        <script src="{{asset('admin')}}/dist/js/app.js"></script>
        <!-- END: JS Assets-->
    </body>
</html>