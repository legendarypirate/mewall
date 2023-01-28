@extends('admin.master')

@section('mainContent')

<div class="content">
                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                   
                    <!-- END: Search -->
                    <!-- BEGIN: Notifications -->
              
                    <!-- END: Notifications -->
                    <!-- BEGIN: Account Menu -->
                  
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->
                <div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
            Quarter үүсгэх
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Input -->
                        <div class="intro-y box">
                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                             
                            </div>
                            {!! Form::open(['url' => 'quarter/save', 'method'=>'post', 'role'=>'form', 'files' => true, 'enctype'=>'multipart/form-data' ]) !!}

                            <div id="input" class="p-5">
                                <div class="preview">
                                   <div class="mt-3">
                                        <label for="regular-form-3" class="form-label">Текст оруулах <span class="required">*</span>  </label>
                                        <div class="mt-3">
                                        <input id="regular-form-5" type="text" class="form-control" placeholder="Давдамж" name="quart" required>
                                    </div>
                                         <div class="mt-3">
                                        <label for="regular-form-3" class="form-label">Sar оруулах <span class="required">*</span>  </label>
                                        <div class="mt-3">
                                        <input id="regular-form-5" type="text" class="form-control" placeholder="Давдамж" name="sar" required>
                                    </div>
                                   
                             
                            </div>
                        </div>
                        <!-- END: Input -->
                        <!-- BEGIN: Input Sizing -->
                       
                        <!-- END: Input Sizing -->
                        <!-- BEGIN: Input Groups -->
                   
                        <!-- END: Input Groups -->
                        <!-- BEGIN: Input State -->
                      
                                <div class="source-code hidden">
                                    <button data-target="#copy-checkbox-switch" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                    <div class="overflow-y-auto mt-3 rounded-md">
                                        <pre id="copy-checkbox-switch" class="source-preview"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdivHTMLCloseTag HTMLOpenTaglabelHTMLCloseTagVertical CheckboxHTMLOpenTag/labelHTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mt-2&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-1&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-1&quot;HTMLCloseTagChris EvansHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mt-2&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-2&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-2&quot;HTMLCloseTagLiam NeesonHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mt-2&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-3&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-3&quot;HTMLCloseTagDaniel CraigHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;mt-3&quot;HTMLCloseTag HTMLOpenTaglabelHTMLCloseTagHorizontal CheckboxHTMLOpenTag/labelHTMLCloseTag HTMLOpenTagdiv class=&quot;flex flex-col sm:flex-row mt-2&quot;HTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mr-2&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-4&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-4&quot;HTMLCloseTagChris EvansHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mr-2 mt-2 sm:mt-0&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-5&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-5&quot;HTMLCloseTagLiam NeesonHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;form-check mr-2 mt-2 sm:mt-0&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-6&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot; value=&quot;&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-6&quot;HTMLCloseTagDaniel CraigHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;mt-3&quot;HTMLCloseTag HTMLOpenTaglabelHTMLCloseTagSwitchHTMLOpenTag/labelHTMLCloseTag HTMLOpenTagdiv class=&quot;mt-2&quot;HTMLCloseTag HTMLOpenTagdiv class=&quot;form-check form-switch&quot;HTMLCloseTag HTMLOpenTaginput id=&quot;checkbox-switch-7&quot; class=&quot;form-check-input&quot; type=&quot;checkbox&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;form-check-label&quot; for=&quot;checkbox-switch-7&quot;HTMLCloseTagDefault switch checkbox inputHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="Submit"  style="background: #1c3faa;"
                class="button btn-primary button--sm inline-block mr-1 mb-2 text-white inline-flex items-center mr-5"><i
                data-feather="file-text" class="w-4 h-4 mr-2"></i>Хадгалах
        </button>                        {!! Form::close()!!}
                   
                        <!-- END: Checkbox & Switch -->
                        <!-- BEGIN: Radio Button -->
                      
                        <!-- END: Radio Button -->
                    </div>
                </div>
            </div>
                <!-- BEGIN: Top Bar -->
               
                <!-- END: Top Bar -->

@endsection
