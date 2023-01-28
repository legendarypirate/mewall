@extends('admin.master')
<style>

    [type=search] {
        -webkit-appearance: textfield;
        outline-offset: -2px;
        border: 1px solid #a6bcce;
        padding: 8px;
        border-radius: 10px;
    }
    /* The Modal (background) */
    .modal-custom {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 99999999; /* Sit on top */
      padding-top: 10%; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    
    /* Modal Content */
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 50%;
    }
    
    /* The Close Button */
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
    h6::after {
  content: ' ' counter(checked);
}

input[type=checkbox]:checked {
  counter-increment: checked;
}
    #print_wrapper .table th {
    padding: 0.75rem 1.25rem;
    border: 1px solid;
    font-weight: 700;
    }
    #print_wrapper .table td{
    padding: 0.75rem 1.25rem;
    border: 1px solid;
    }

    @media print{
        .table thead tr td,.table tbody tr td{
            border-width: 1px;
            border-style: solid;
            border-color: black;
            font-size: 10px;
            background-color: red;
            padding:0px;
            -webkit-print-color-adjust:exact;
        }
    }
    
    </style>
@section('page-title')
     Core system
@endsection

@section('content-heading')
      Ерөнхий мэдээлэл
@endsection


@section('mainContent')

<h2 class="intro-y text-lg font-medium mt-10">
                 Хэрэглэгчийн мэдээлэл удирдах
                </h2>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                        <button class="button text-white bg-theme-1 shadow-md mr-2">Add New user</button>
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
                                    <th class="whitespace-no-wrap">Хэрэглэгчийн овог</th>
                                    <th class="whitespace-no-wrap">Хэрэглэгчийн нэр</th>
                                    <th class="text-center whitespace-no-wrap">Имэйл</th>

                                    <th class="text-center whitespace-no-wrap">Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>  <?php

                                    $i=0;

                                   ?>
                            @foreach($user as $singleUser)
                                <tr class="intro-x">
                                    <td class="w-40">{{++$i}}</td>
                                    <td >{{$singleUser->lname}}</td>
                                    <td>
                                        <a href="" class="font-medium whitespace-no-wrap">{{$singleUser->fname}}</a>

                                    </td>
                                    <td class="text-center">{{$singleUser->email}}</td>

                                
                                        <input value="{{$singleUser->id}}" id="data" type="hidden" data-id="{{$singleUser->id}}">
                                                                        <td class="table-report__action w-56" >
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3"  id="btnBusModal" >                                     <input value="Засах"  id="btnBusModal"  type="button" data-id="{{$singleUser->id}}"  onclick="addRow(this)">
 </a>
                                            <a class="flex items-center text-theme-6" href="{{url('/user/delete/'.$singleUser->id)}}" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Устгах </a>
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

                <div id="busModal" class="modal-custom">

<!-- Modal content -->
          <div class="modal-content">
                      <span class="close">&times;</span>

                      <br>
                                                          {!! Form::open(['url' => 'user/edit', 'method'=>'post', 'name'=>'editForm', 'role'=>'form']) !!}

                    <div>  <div>Овог</div> <input id="lname" name="lname">
                     <div> <div>Нэр</div> <input id="fname" name="fname">
                      <div>email</div> <input id="email" name="email">
                      <div>Банк</div> <input id="bank" name="bank">
                      <div>Данс</div> <input id="account" name="account">
                     <div>Сүүлд асаасан цаг</div> <div id="runtime">Байхгүй</div>
                      <div>Улирлын хураагдсан дүн</div> <div id="quarterly">Байхгүй</div>
                      <div>Нийт</div> <div id="lifetimeaccum">Байхгүй</div>
 <input id="id" type="hidden" name="uid">
   <button type="Submit"  style="background: #1c3faa;"
                class="button btn-primary button--sm inline-block mr-1 mb-2 text-white inline-flex items-center mr-5"><i
                data-feather="file-text" class="w-4 h-4 mr-2"></i>Засах                </button>
                
</div>
                                        {!! Form::close() !!}
                                        
                                         {!! Form::open(['url' => 'user/addlot', 'method'=>'post', 'name'=>'editForm', 'role'=>'form']) !!}
                                        <input  name="lt" type="text">
 <input id="ids" name="uid" type="hidden">
 <button type="Submit"  style="background: #1c3faa;"
                class="button btn-primary button--sm inline-block mr-1 mb-2 text-white inline-flex items-center mr-5"><i
                data-feather="file-text" class="w-4 h-4 mr-2"></i>Хонжвор нэмэх                </button>
                
                 {!! Form::close() !!}
<script>

                $(document).on('click', '#btnBusModal', function() {
                            $('#busModal').attr('style','display:block');
                                             
                    });
                    function addRow(ele) 
                                {
                                    var id= $(ele).attr('data-id');
                                    console.log(id);  
                                    $.ajax({
                type: 'GET',
                url: 'det/' + id,
                success: function (response) {
                var response = JSON.parse(response);
                console.log(response);   
           
                                   document.getElementById("lname").value = response[0]['lname'];

              document.getElementById("email").value = response[0]['email'];

                 document.getElementById("fname").value = response[0]['fname'];
                 document.getElementById("bank").value = response[0]['bank'];
                 document.getElementById("account").value = response[0]['account'];
                 document.getElementById("id").value = response[0]['id'];
                 document.getElementById("ids").value = response[0]['id'];

                     $('#runtime').empty();
                  $('#runtime').append(response[0]['runtime']);
                    $('#quarterly').empty();
                  $('#quarterly').append(response[0]['quarterly']);
                    $('#lifetimeaccum').empty();
                  $('#lifetimeaccum').append(response[0]['lifetimeaccum']);
                response.forEach(element => {
                    $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
                                }   

                           
                                         
                                 
                $(document).on('click', '.close', function() {
        $('#customModal').attr('style','display:none');
        $('#statusModal').attr('style','display:none');
        $('#driveModal').attr('style','display:none');
        $('#busModal').attr('style','display:none');
        $('#deleteModal').attr('style','display:none');

        $('#verifyModal').attr('style','display:none');
        $('#importModal').attr('style','display:none');

        $(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#customModal').hide();
  }
});
$(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#statusModal').hide();
  }
});

$(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#deleteModal').hide();
  }
});
$(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#driveModal').hide();
  }
});
$(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#busModal').hide();
  }
});
$(document).keydown(function(event) {
  if (event.keyCode == 27) {
    $('#verifyModal').hide();
  }
});

    });
</script>

@endsection
