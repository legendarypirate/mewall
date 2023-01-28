@extends('admin.master')

@section('page-title')
     Core system
@endsection

@section('content-heading')
      Ерөнхий мэдээлэл
@endsection


@section('mainContent')

<h2 class="intro-y text-lg font-medium mt-10">
Улирлын текст тохируулах тохируулах                </h2>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                        <button class="button text-white bg-theme-1 shadow-md mr-2"><a href="save">Add New Quart</a></button>
                        <div class="dropdown">
                            <button class="dropdown-toggle button px-2 box text-gray-700 dark:text-gray-300">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                            </button>
                            <div class="dropdown-box w-40">
                                <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of 150 entries</div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                                <input type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Хайх...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-no-wrap">Дугаар</th>
                                    <th class="whitespace-no-wrap center">Uliral</th>
                                                                <th class="whitespace-no-wrap center">Sar</th>

                                    <th class="text-center whitespace-no-wrap">Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>  <?php

                                    $i=0;

                                   ?>
                            @foreach($user as $singleUser)
                                <tr class="intro-x">
                                    <td class="w-40">{{++$i}}</td>
                                 
                                    <td >{{$singleUser->quart}}</td>
                                    <td >{{$singleUser->sar}}</td>


                                                                        <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="{{url('/quarter/edit/'.$singleUser->id)}}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Засах </a>
                                        </div>
                                    </td>
                                </tr>
                               @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                  
                    <!-- END: Pagination -->
                </div>



@endsection
