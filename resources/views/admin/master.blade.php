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
    <link href="{{asset('admin')}}/dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MY WALL</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
      
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('front')}}/images/lgd.png">

         <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
         <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
         <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
      <link href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

 <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

 
 
 <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

 
    <!-- Styles -->

    <link rel="stylesheet" href="{{asset('admin')}}/dist/css/app.css"/>
    <style>


        #se-pre-con {
            position: fixed;
            -webkit-transition: opacity 5s ease-in-out;
            -moz-transition: opacity 5s ease-in-out;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(https://ubl.mn/static/images/uLMS2019_Loading_SVG.svg) center no-repeat #ffffff91;
        }
        .formslct{
            width:100%;border-radius:0.375rem;border-width:1px;padding:0.5rem 2rem 0.5rem 0.75rem;
        }
    </style>
    <script>
        function loading(cmd) {
            var l = document.getElementById("se-pre-con");
            l.style.display = cmd;
        }
    </script>
</head>
<!-- END: Head -->
<body class="app">
<div id="se-pre-con" style="display: none;">
    <!--    <i data-loading-icon="ball-triangle" class="w-8 h-8"></i>-->
</div>
<!-- BEGIN: Mobile Menu -->
@include('admin.inc.mobileMenu')
<!-- END: Mobile Menu -->
<div class="flex">
    <!-- BEGIN: Side Menu -->
    @include('admin.inc.leftMenu')
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        <!-- BEGIN: Top Bar -->
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"><a href="" class="">Эхлэл</a> <i
                    data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">@yield('content-heading')</a>
            </div>
            <!-- END: Breadcrumb -->
            <!-- BEGIN: Search -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <!--                <div class="search hidden sm:block">-->
                <!--                    <input type="text" class="search__input input placeholder-theme-13" placeholder="Хайх...">-->
                <!--                    <i data-feather="search" class="search__icon dark:text-gray-300"></i>-->
                <!--                </div>-->
                <a class="notification sm:hidden" href=""> <i data-feather="search"
                                                              class="notification__icon dark:text-gray-300"></i> </a>
                <div class="search-result">
                    <div class="search-result__content">
                        <div class="search-result__content__title">Pages</div>
                        <div class="mb-5">
                            <a href="" class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-theme-18 text-theme-9 flex items-center justify-center rounded-full">
                                    <i class="w-4 h-4" data-feather="inbox"></i></div>
                                <div class="ml-3">Mail Settings</div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-17 text-theme-11 flex items-center justify-center rounded-full">
                                    <i class="w-4 h-4" data-feather="users"></i></div>
                                <div class="ml-3">Users & Permissions</div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full">
                                    <i class="w-4 h-4" data-feather="credit-card"></i></div>
                                <div class="ml-3">Transactions Report</div>
                            </a>
                        </div>
                        <div class="search-result__content__title">Users</div>
                        <div class="mb-5">
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                         src="{{asset('admin')}}/dist/images/profile-4.jpg">
                                </div>
                                <div class="ml-3">John Travolta</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">
                                    johntravolta@left4code.com
                                </div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                         src="{{asset('admin')}}/dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-3">Tom Cruise</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">
                                    tomcruise@left4code.com
                                </div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                         src="{{asset('admin')}}/dist/images/profile-6.jpg">
                                </div>
                                <div class="ml-3">John Travolta</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">
                                    johntravolta@left4code.com
                                </div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                         src="{{asset('admin')}}/dist/images/profile-13.jpg">
                                </div>
                                <div class="ml-3">Tom Cruise</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">
                                    tomcruise@left4code.com
                                </div>
                            </a>
                        </div>
                        <div class="search-result__content__title">Products</div>
                        <a href="" class="flex items-center mt-2">
                            <div class="w-8 h-8 image-fit">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/preview-13.jpg">
                            </div>
                            <div class="ml-3">Samsung Galaxy S20 Ultra</div>
                            <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Smartphone &amp;
                                Tablet
                            </div>
                        </a>
                        <a href="" class="flex items-center mt-2">
                            <div class="w-8 h-8 image-fit">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/preview-11.jpg">
                            </div>
                            <div class="ml-3">Dell XPS 13</div>
                            <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">PC &amp; Laptop</div>
                        </a>
                        <a href="" class="flex items-center mt-2">
                            <div class="w-8 h-8 image-fit">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/preview-3.jpg">
                            </div>
                            <div class="ml-3">Samsung Q90 QLED TV</div>
                            <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Electronic</div>
                        </a>
                        <a href="" class="flex items-center mt-2">
                            <div class="w-8 h-8 image-fit">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/preview-5.jpg">
                            </div>
                            <div class="ml-3">Nike Tanjun</div>
                            <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Sport &amp; Outdoor
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Search -->
            <!-- BEGIN: Notifications -->
            <div class="intro-x dropdown mr-auto sm:mr-6">
                <div class="dropdown-toggle notification notification--bullet cursor-pointer"><i data-feather="bell"
                                                                                                 class="notification__icon dark:text-gray-300"></i>
                </div>
                <div class="notification-content pt-2 dropdown-box">
                    <div class="notification-content__box dropdown-box__content box dark:bg-dark-6">
                        <div class="notification-content__title">Notifications</div>
                        <div class="cursor-pointer relative flex items-center ">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/profile-4.jpg">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">John Travolta</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">05:09 AM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard
                                    dummy text ever since the 1500
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/profile-11.jpg">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Tom Cruise</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">03:20 PM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard
                                    dummy text ever since the 1500
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/profile-6.jpg">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">John Travolta</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">06:05 AM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">Contrary to popular belief, Lorem Ipsum is
                                    not simply random text. It has roots in a piece of classical Latin literature from
                                    45 BC, making it over 20
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/profile-13.jpg">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Tom Cruise</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">05:09 AM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard
                                    dummy text ever since the 1500
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{asset('admin')}}/dist/images/profile-5.jpg">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">Kevin Spacey</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">01:10 PM</div>
                                </div>
                                <div class="w-full truncate text-gray-600">There are many variations of passages of
                                    Lorem Ipsum available, but the majority have suffered alteration in some form, by
                                    injected humour, or randomi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Notifications -->
            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                    <img alt="Midone Tailwind HTML Admin Template" src="{{asset('admin')}}/dist/images/profile-1.jpg">
                </div>
                <div class="dropdown-box w-56">
                    <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
                        <div class="p-4 border-b border-theme-40 dark:border-dark-3">
                            <div class="font-medium">John Travolta</div>
                            <div class="text-xs text-theme-41 dark:text-gray-600">DevOps Engineer</div>
                        </div>
                        <div class="p-2">
                            <a href=""
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                            <a href=""
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                            <a href=""
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                            <a href=""
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                        </div>
                        <div class="p-2 border-t border-theme-40 dark:border-dark-3">
                            <a class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
        <!-- END: Top Bar -->
        @yield('mainContent')

    </div>
    <!-- END: Content -->
</div>
<!-- BEGIN: Dark Mode Switcher-->


<script src="{{asset('admin')}}/dist/js/app.js"></script>
<script type="text/javascript">
    $(document).ready(
        function () {
            var url = document.location.href;
            $(".side-nav ul li a").removeClass("side-menu--active");
            if (url.indexOf("/credits") > -1) {
                $(".side-nav ul li:nth-child(3) a").addClass("side-menu--active");
            }
            if (url.indexOf("/paidlist") > -1) {
                $(".side-nav ul li:nth-child(5) a").addClass("side-menu--active");

            } else if (url.indexOf("/loanSms/manage") > -1) {
                $(".side-nav ul li:nth-child(4) a").addClass("side-menu--active");

            } else if (url.indexOf("/khan") > -1) {
                $(".side-nav ul li:nth-child(1) a").addClass("side-menu--active");

            } else if (url.indexOf("/statment/changed/list") > -1) {
                $(".side-nav ul li:nth-child(2) a").addClass("side-menu--active");

            } else if (url.indexOf("/sms") > -1) {
                $(".side-nav ul li:nth-child(8) a").addClass("side-menu--active");

            }

        });
</script>
<script>
//DOM elements
const DOMstrings = {
  stepsBtnClass: 'multisteps-form__progress-btn',
  stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
  stepsBar: document.querySelector('.multisteps-form__progress'),
  stepsForm: document.querySelector('.multisteps-form__form'),
  stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
  stepFormPanelClass: 'multisteps-form__panel',
  stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
  stepPrevBtnClass: 'js-btn-prev',
  stepNextBtnClass: 'js-btn-next' };


//remove class from a set of items
const removeClasses = (elemSet, className) => {

  elemSet.forEach(elem => {

    elem.classList.remove(className);

  });

};

//return exect parent node of the element
const findParent = (elem, parentClass) => {

  let currentNode = elem;

  while (!currentNode.classList.contains(parentClass)) {
    currentNode = currentNode.parentNode;
  }

  return currentNode;

};

//get active button step number
const getActiveStep = elem => {
  return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

//set all steps before clicked (and clicked too) to active
const setActiveStep = activeStepNum => {

  //remove active state from all the state
  removeClasses(DOMstrings.stepsBtns, 'js-active');

  //set picked items to active
  DOMstrings.stepsBtns.forEach((elem, index) => {

    if (index <= activeStepNum) {
      elem.classList.add('js-active');
    }

  });
};

//get active panel
const getActivePanel = () => {

  let activePanel;

  DOMstrings.stepFormPanels.forEach(elem => {

    if (elem.classList.contains('js-active')) {

      activePanel = elem;

    }

  });

  return activePanel;

};

//open active panel (and close unactive panels)
const setActivePanel = activePanelNum => {

  //remove active class from all the panels
  removeClasses(DOMstrings.stepFormPanels, 'js-active');

  //show active panel
  DOMstrings.stepFormPanels.forEach((elem, index) => {
    if (index === activePanelNum) {

      elem.classList.add('js-active');

      setFormHeight(elem);

    }
  });

};

//set form height equal to current panel height
const formHeight = activePanel => {

  const activePanelHeight = activePanel.offsetHeight;

  DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
  const activePanel = getActivePanel();

  formHeight(activePanel);
};

//STEPS BAR CLICK FUNCTION
DOMstrings.stepsBar.addEventListener('click', e => {

  //check if click target is a step button
  const eventTarget = e.target;

  if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
    return;
  }

  //get active button step number
  const activeStep = getActiveStep(eventTarget);

  //set all steps before clicked (and clicked too) to active
  setActiveStep(activeStep);

  //open active panel
  setActivePanel(activeStep);
});

//PREV/NEXT BTNS CLICK
DOMstrings.stepsForm.addEventListener('click', e => {

  const eventTarget = e.target;

  //check if we clicked on `PREV` or NEXT` buttons
  if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
  {
    return;
  }

  //find active panel
  const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

  let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

  //set active step and active panel onclick
  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
    activePanelNum--;

  } else {

    activePanelNum++;

  }

  setActiveStep(activePanelNum);
  setActivePanel(activePanelNum);

});

//SETTING PROPER FORM HEIGHT ONLOAD
window.addEventListener('load', setFormHeight, false);

//SETTING PROPER FORM HEIGHT ONRESIZE
window.addEventListener('resize', setFormHeight, false);

//changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

const setAnimationType = newType => {
  DOMstrings.stepFormPanels.forEach(elem => {
    elem.dataset.animation = newType;
  });
};

//selector onchange - changing animation
const animationSelect = document.querySelector('.pick-animation__select');

animationSelect.addEventListener('change', () => {
  const newAnimationType = animationSelect.value;

  setAnimationType(newAnimationType);
});

</script>

    <script>
                $(document).ready(function () {
                $('#loans').on('change', function (){
                let stts = $(this).val();
                $('#loand').empty();
                $('#loand').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'subcat/' + stts,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#loand').empty();
                $('#loand').append(``);
                response.forEach(element => {
                  $('#loand').append(` <tr class="intro-x" >
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                            ${element['id']}
                                            </div>
                                           
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">${element['name']}</a> 
                                    
                                    </td>
                                    <td class="text-center">${element['amount']}</td>
                                    <td class="text-center">${element['getdate']}</td>
									<td class="text-center">${element['contnum']}</td>
                                   
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Засварлах </a>
											<a class="flex items-center text-theme-9" href="javascript:;"> <i data-feather="maximize-2" class="w-4 h-4 mr-1"></i> Дэлгэрэнгүй  </a>
											<a class="flex items-center text-theme-6" onclick="return confirm('Are you sure?')" href=""><i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Устгах</a>
                                        </div>
                                    </td>
                                </tr>`);
                 
                    });
                }
            });
        });
    });
    </script>
        <script src="{{asset('syst')}}/dist/js/app.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $(".select").select2();
});

</script>
  
<script>

$(".mt-3 :checkbox").click(function () {
    var testVar = ".area" + this.value;
    if (this.checked) $(testVar).hide();
    else $(testVar).show();
});

</script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle();
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
                $(document).ready(function () {
                $('#sub_category_name').on('change', function () {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'subcats/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                response.forEach(element => {
                    $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });
    </script>

<script>
                $(document).ready(function () {
                $('#deliver').on('change', function () {
                let id = $(this).val();
                $('#textField').empty();
                $('#textField').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'phone/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#textField').empty();
        
                response.forEach(element => {
                    $('#textField').append(`<option value="${element['phone']}">${element['phone']}</option>`);
                    });
                }
            });
        });
    });


    $(document).ready(function () {
                $('#good').on('change', function () {
                let id = $(this).val();
                $('#products').empty();
                $('#products').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'good/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#products').empty();
        
                response.forEach(element => {
                    $('#products').append(`<option value="${element['id']}">${element['goodname']}</option>`);
                    });
                }
            });
        });
    });


    $(document).ready(function () {
                $('#deliver').on('change', function () {
                let id = $(this).val();
                $('#textField1').empty();
                $('#textField1').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'address/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#textField1').empty();
       
                response.forEach(element => {
                    $('#textField1').append(`<option value="${element['address']}">${element['address']}</option>`);
                    });
                }
            });
        });
    });


    const ac = document.getElementById("admin_code");
ac.style.display = "none";

function toggleDropdown(selObj) {
  ac.style.display = selObj.value === "Admin" ? "block" : "none";
}
    </script>

<script>
                $(document).ready(function () {
                $('#sub_category').on('change', function () {
                let id = $(this).val();
                $('#prime_cat').empty();
                $('#prime_cat').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                type: 'GET',
                url: 'primecat/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
                $('#prime_cat').empty();
                $('#prime_cat').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                response.forEach(element => {
                    $('#prime_cat').append(`<option value="${element['name']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });

    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
    function cartloadDetails()
    {
        $.ajaxSetup({     
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: '/load-cart-details',
            method: "GET",
            
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            success: function (response) {
              $("#cart_details").html(response); 
            }
        });
    }

    function cartloadDetailsPhone()
    {
        $.ajaxSetup({     
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: '/load-phone-details',
            method: "GET",
            
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            success: function (response) {
              $("#cart_details").html(response); 
            }
        });
    }
    
    function cartloadDetailsAdd()
    {
        $.ajaxSetup({     
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: '/load-address-details',
            method: "GET",
            
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            success: function (response) {
              $("#cart_details_add").html(response); 
            }
        });
    }
  



   function cartload()
    {
        $.ajaxSetup({
     
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: '/load-cart-data',
            method: "GET",
            
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            success: function (response) {
                $('.basket-item-count').html('');
                var parsed = jQuery.parseJSON(response)
                var value = parsed; //Single Data Viewing
                $('.basket-item-count').append($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
            }
        });
    }

    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
    function cartloadDetails()
    {
        $.ajaxSetup({     
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: '/load-cart-details',
            method: "GET",
            
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            success: function (response) {
              $("#cart_details").html(response); 
            }
        });
    }
    $(document).ready(function () {
        $('.add-to-cart').click(function (e) {
            e.preventDefault();

            $.ajaxSetup({
              contentType: "application/x-www-form-urlencoded;charset=utf-8",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    
                }
            });
            var product_id = $("#products option:selected" ).val();
            var product_name = $("#products option:selected" ).text();
            var quantity = $(this).closest('.proddata').find('.qty-input').val();

            $.ajax({
                url: "/add-to-cart",
                method: "POST",
           
                data: {
                    'quantity': quantity,
                    'product_id': product_id,
                    'product_name': product_name,
                },
       
                success: function (response) {
                  console.log(response);
                  //window.location.reload();
                  $("#cart_details").html(response);                   
                  cartloadDetails();
                },
            });
        });
    });
    

    
$(document).ready(function () {

$('.delete_cart_data').click(function (e) {
    e.preventDefault();

    var product_id = $(this).closest(".cartpage").find('.product_id').val();

    var data = {
        '_token': $('input[name=_token]').val(),
        "product_id": product_id,
    };

    // $(this).closest(".cartpage").remove();

    $.ajax({
        url: '/delete-from-cart',
        type: 'DELETE',
  
        data: data,
        success: function (response) {
            window.location.reload();
        }
    });
});

});


$(document).ready(function () {

$('.cc').click(function (e) {


    $.ajax({
        url: '/clear-cart',
        type: 'GET',

        success: function (response) {
          
            alertify.set('notifier','position','top-right');
            alertify.success(response.status);
        }
    });

});

});

$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $(".select").select2();
});
    </script>
<script>
$('input[name="foo"]').click(function() {
    document.getElementById("result").textContent = "Total Number of Items Selected = " + document.querySelectorAll('input[name="foo"]:checked').length;

});
</script>
<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to do this?');
    }

    window.updateCount = function() {
    var x = $(".checkbox:checked").length;
    document.getElementById("y").innerHTML ='Нйит '+ x+' мөр сонгосон байна';
};


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
<!-- END: JS Assets-->
</body>
</html>
