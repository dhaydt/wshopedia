@extends('layouts.back-end.app')

@push('css_or_js')
<!-- Custom styles for this page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Custom styles for this page -->
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Shipping_Method')}}</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{\App\CPU\translate('Shipping')}} {{\App\CPU\translate('Method')}}</h4>
    </div>

    <div class="row w-100 justify-content-center" style="padding-bottom: 20px">
        <div class="col-md-6" style="padding-bottom: 20px">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{\App\CPU\translate('JNE')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('dhl_parcel'))
                    <form {{--
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.shipping-method.dhlUpdate',['dhl_parcel']):'javascript:'}}"
                        --}} style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        method="post">
                        @csrf

                        <div class="form-group mb-2">
                            <label class="control-label">{{\App\CPU\translate('JNE')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input type="radio" name="status" value="1" {{isset($config) &&
                                $config['status']==1?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('active')}}</label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <input type="radio" name="status" value="0" {{isset($config) &&
                                $config['status']==0?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('inactive')}} </label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <label class="text-capitalize" style="padding-{{Session::get('direction') === " rtl"
                                ? 'right' : 'left' }}: 10px">{{\App\CPU\translate('api_key')}}</label><br>
                            <input type="text" class="form-control" name="dhl_key"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_key']??"":''}}">
                        </div>
                        <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('api_secret')}}</label><br>
                            <input type="text" class="form-control" name="dhl_secret"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_secret']??"":''}}">
                        </div>

                        {{-- <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('otp_template')}}</label><br>
                            <input type="text" class="form-control" name="otp_template"
                                value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                        </div> --}}

                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" disabled
                            class="btn btn-primary mb-2">{{\App\CPU\translate('save')}}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-bottom: 20px">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{\App\CPU\translate('TIKI')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('dhl_parcel'))
                    <form {{--
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.shipping-method.dhlUpdate',['dhl_parcel']):'javascript:'}}"
                        --}} style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        method="post">
                        @csrf

                        <div class="form-group mb-2">
                            <label class="control-label">{{\App\CPU\translate('TIKI')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input type="radio" name="status" value="1" {{isset($config) &&
                                $config['status']==1?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('active')}}</label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <input type="radio" name="status" value="0" {{isset($config) &&
                                $config['status']==0?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('inactive')}} </label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <label class="text-capitalize" style="padding-{{Session::get('direction') === " rtl"
                                ? 'right' : 'left' }}: 10px">{{\App\CPU\translate('api_key')}}</label><br>
                            <input type="text" class="form-control" name="dhl_key"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_key']??"":''}}">
                        </div>
                        <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('api_secret')}}</label><br>
                            <input type="text" class="form-control" name="dhl_secret"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_secret']??"":''}}">
                        </div>

                        {{-- <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('otp_template')}}</label><br>
                            <input type="text" class="form-control" name="otp_template"
                                value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                        </div> --}}

                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" disabled
                            class="btn btn-primary mb-2">{{\App\CPU\translate('save')}}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-bottom: 20px">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{\App\CPU\translate('Si_CEPAT')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('dhl_parcel'))
                    <form {{--
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.shipping-method.dhlUpdate',['dhl_parcel']):'javascript:'}}"
                        --}} style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        method="post">
                        @csrf

                        <div class="form-group mb-2">
                            <label class="control-label">{{\App\CPU\translate('Si_CEPAT')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input type="radio" name="status" value="1" {{isset($config) &&
                                $config['status']==1?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('active')}}</label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <input type="radio" name="status" value="0" {{isset($config) &&
                                $config['status']==0?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('inactive')}} </label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <label class="text-capitalize" style="padding-{{Session::get('direction') === " rtl"
                                ? 'right' : 'left' }}: 10px">{{\App\CPU\translate('api_key')}}</label><br>
                            <input type="text" class="form-control" name="dhl_key"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_key']??"":''}}">
                        </div>
                        <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('api_secret')}}</label><br>
                            <input type="text" class="form-control" name="dhl_secret"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_secret']??"":''}}">
                        </div>

                        {{-- <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('otp_template')}}</label><br>
                            <input type="text" class="form-control" name="otp_template"
                                value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                        </div> --}}

                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" disabled
                            class="btn btn-primary mb-2">{{\App\CPU\translate('save')}}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-bottom: 20px">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{\App\CPU\translate('DHL')}} {{\App\CPU\translate('PARSEL')}} </h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('dhl_parcel'))
                    <form
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.shipping-method.dhlUpdate',['dhl_parcel']):'javascript:'}}"
                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};" method="post">
                        @csrf

                        <div class="form-group mb-2">
                            <label class="control-label">{{\App\CPU\translate('DHL_Parcel')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input type="radio" name="status" value="1" {{isset($config) &&
                                $config['status']==1?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('active')}}</label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <input type="radio" name="status" value="0" {{isset($config) &&
                                $config['status']==0?'checked':''}}>
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('inactive')}} </label>
                            <br>
                        </div>
                        <div class="form-group mb-2">
                            <label class="text-capitalize" style="padding-{{Session::get('direction') === " rtl"
                                ? 'right' : 'left' }}: 10px">{{\App\CPU\translate('api_key')}}</label><br>
                            <input type="text" class="form-control" name="dhl_key"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_key']??"":''}}">
                        </div>
                        <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('api_secret')}}</label><br>
                            <input type="text" class="form-control" name="dhl_secret"
                                value="{{env('APP_MODE')!='demo'?$config['dhl_secret']??"":''}}">
                        </div>

                        {{-- <div class="form-group mb-2">
                            <label style="padding-{{Session::get('direction') === " rtl" ? 'right' : 'left' }}:
                                10px">{{\App\CPU\translate('otp_template')}}</label><br>
                            <input type="text" class="form-control" name="otp_template"
                                value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                        </div> --}}

                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                            class="btn btn-primary mb-2">{{\App\CPU\translate('save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('script')

    @endpush
