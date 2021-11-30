@extends('layouts.front-end.app')

@section('title', \App\CPU\translate('Register'))

@push('css_or_js')
<style>
    @media (max-width: 500px) {
        #sign_in {
            margin-top: -23% !important;
        }

    }
</style>
@endpush

@section('content')
<div class="container py-4 py-lg-5 my-4" style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
    }};">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <h2 class="h4 mb-1">{{\App\CPU\translate('no_account')}}</h2>
                    <p class="font-size-sm text-muted mb-4">{{\App\CPU\translate('register_control_your_order')}}
                        .</p>
                    <form class="needs-validation_" action="{{route('customer.auth.register')}}" method="post"
                        id="sign-up-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-fn">{{\App\CPU\translate('first_name')}}</label>
                                    <input class="form-control" value="{{old('f_name')}}" type="text" name="f_name"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};" required>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your first
                                        name')}}!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('last_name')}}</label>
                                    <input class="form-control" type="text" value="{{old('l_name')}}" name="l_name"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};">
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your last name')}}!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('Address')}}</label>
                                    <input class="form-control" type="text" value="{{old('address')}}" name="address"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};" required>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your address')}}!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('country')}}</label>
                                    <input class="form-control" type="text" value="" name="country"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};" required>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please select your country')}}!
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 prov-inter">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('Province')}}</label>
                                    <input class="form-control" name="province"
                                        placeholder="Enter your province address"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};">
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your province')}}!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 prov-inter">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('city')}}</label>
                                    <input class="form-control" name="city" placeholder="Enter your city address"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};">
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your city
                                        address')}}!
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 prov-indo d-none">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('Province')}}</label>
                                    <select class="form-control" name="province">
                                        <option value="">Select your Province Address</option>
                                        @foreach($prov as $p)
                                        <option value="{{$p['province_id'].','. $p['province']}}"
                                            provincename="{{$p['province']}}">
                                            {{$p['province']}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your province
                                        address')}}!
                                    </div>
                                </div>
                                {{-- <select name="kota_id" id="kota_id" class="form-control"></select> --}}
                            </div>
                            <div class="col-sm-6 prov-indo d-none">
                                <div class="form-group">
                                    <label for="reg-ln">{{\App\CPU\translate('city')}}</label>
                                    <select class="form-control" name="city" placeholder="Enter your city address"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};">
                                        <option value="">Select your city address</option>
                                    </select>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your city
                                        address')}}!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-email">{{\App\CPU\translate('email_address')}}</label>
                                    <input class="form-control" type="email" value="" name="email"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};" required>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter valid email
                                        address')}}!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-phone">{{\App\CPU\translate('phone_number')}}
                                        <small class="text-primary">( * {{\App\CPU\translate('country_code_is_must')}}
                                            {{\App\CPU\translate('like_for_BD_880')}} )</small></label>
                                    <input class="form-control" type="number" value="{{old('phone')}}" name="phone"
                                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                        }};" required>
                                    <div class="invalid-feedback">{{\App\CPU\translate('Please enter your phone
                                        number')}}!</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="si-password">{{\App\CPU\translate('password')}}</label>
                                    <div class="password-toggle">
                                        <input class="form-control" name="password" type="password" id="si-password"
                                            style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                            }};" placeholder="{{\App\CPU\translate('minimum_8_characters_long')}}"
                                            required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox"><i
                                                class="czi-eye password-toggle-indicator"></i><span
                                                class="sr-only">{{\App\CPU\translate('Show')}}
                                                {{\App\CPU\translate('password')}} </span>
                                        </label>
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="reg-password">{{\App\CPU\translate('password')}}</label>
                                    <input class="form-control" type="password" name="password">
                                    <div class="invalid-feedback">Please enter password!</div>
                                </div> --}}
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="si-password">{{\App\CPU\translate('confirm_password')}}</label>
                                    <div class="password-toggle">
                                        <input class="form-control" name="con_password" type="password"
                                            style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left'
                                            }};" placeholder="{{\App\CPU\translate('minimum_8_characters_long')}}"
                                            id="si-password" required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox"
                                                style="text-align: {{Session::get('direction') === " rtl" ? 'right'
                                                : 'left' }};"><i class="czi-eye password-toggle-indicator"></i><span
                                                class="sr-only">{{\App\CPU\translate('Show')}}
                                                {{\App\CPU\translate('password')}} </span>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="reg-password-confirm">{{\App\CPU\translate('confirm_password')}}</label>
                                    <input class="form-control" type="password" name="con_password">
                                    <div class="invalid-feedback">Passwords do not match!</div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between">

                            <div class="form-group mb-1">
                                <strong>
                                    <input type="checkbox" class="mr-1" name="remember" id="inputCheckd">
                                </strong>
                                <label class="" for="remember">{{\App\CPU\translate('i_agree_to_Your_terms')}}<a
                                        class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                        {{\App\CPU\translate('terms_and_condition')}}
                                    </a></label>
                            </div>

                        </div>
                        <div class="flex-between row" style="direction: {{ Session::get('direction') }}">
                            <div class="mx-1">
                                <div class="text-right">
                                    <button class="btn btn-primary" id="sign-up" type="submit" disabled>
                                        <i class="czi-user {{Session::get('direction') === " rtl" ? 'ml-2 mr-n1'
                                            : 'mr-2 ml-n1' }}"></i>
                                        {{\App\CPU\translate('sign_up')}}
                                    </button>
                                </div>
                            </div>
                            <div class="mx-1">
                                <a class="btn btn-outline-primary" href="{{route('customer.auth.login')}}">
                                    <i class="fa fa-sign-in"></i> {{\App\CPU\translate('sign_in')}}
                                </a>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    @foreach (\App\CPU\Helpers::get_business_settings('social_login') as
                                    $socialLoginService)
                                    @if (isset($socialLoginService) && $socialLoginService['status']==true)
                                    <div class="col-sm-6 text-center mt-1">
                                        <a class="btn btn-outline-primary"
                                            href="{{route('customer.auth.service-login', $socialLoginService['login_medium'])}}"
                                            style="width: 100%">
                                            <i class="czi-{{ $socialLoginService['login_medium'] }} {{Session::get('direction') === "
                                                rtl" ? 'ml-2 mr-n1' : 'mr-2 ml-n1' }}"></i>
                                            {{\App\CPU\translate('sing_up_with_'.$socialLoginService['login_medium'])}}
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        //ini ketika provinsi tujuan di klik maka akan eksekusi perintah yg kita mau
        //name select nama nya "provinve_id" kalian bisa sesuaikan dengan form select kalian
        $('input[name="country"]').on('change', function(){
            let country = $(this).val()
            if(country == 'indonesia' || country == "Indonesia"){
                $('.prov-inter').addClass('d-none');
                $('.prov-indo').removeClass('d-none');
                $('input[name="country"]').attr('readonly', true)
            }else {
                $('.prov-indo').remove();
                $('input[name="country"]').attr('readonly', true)
                console.log('no indo')
            }
        })
        $('select[name="province"]').on('change', function(){
        // kita buat variable provincedid untk menampung data id select province
        console.log($(this).val())
            let prov = $(this).val();
            var array = prov.split(",");
            let provin = $.each(array,function(i){
            // console.log(array[0]);
            return array[0]
            });
            let provinceid = provin[0]
            //kita cek jika id di dpatkan maka apa yg akan kita eksekusi
            if(provinceid){
                // jika di temukan id nya kita buat eksekusi ajax GET
                jQuery.ajax({
                    // url yg di root yang kita buat tadi
                    url:"/customer/auth/city/"+provinceid,
                    // aksion GET, karena kita mau mengambil data
                    type:'GET',
                    // type data json
                    dataType:'json',
                    // jika data berhasil di dapat maka kita mau apain nih
                    success:function(data){
                        console.log(data);
                        // jika tidak ada select dr provinsi maka select kota kososng / empty
                        $('select[name="kota_id"]').addClass('work');
                        // // jika ada kita looping dengan each
                        $.each(data, function(key, value){
                            console.log(key, value)
                            kota = value.city_name
                            type = value.type
                            id = value.city_id
                        // // perhtikan dimana kita akan menampilkan data select nya, di sini saya memberi name select kota adalah kota_id
                        $('select[name="city"]').append(`<option value="${id},${kota}">
                            ${kota} (${type})
                        </option>`);

                        //.append('<option value="'+ value.city_id +'"
                        //     namakota="'+ value.type +' ' +value.city_name+ '">' + value.type + ' ' + value.city_name + '</option>');
                        });
                        // }
                        // });
                        // }else {
                        // $('select[name="kota_id"]').empty();
                    }
                });
            }
        });
    });

    // term condition
    $('#inputCheckd').change(function () {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#sign-up').removeAttr('disabled');
            } else {
                $('#sign-up').attr('disabled', 'disabled');
            }

        });
        /*$('#sign-up-form').submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.auth.register')}}',
                dataType: 'json',
                data: $('#sign-up-form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setInterval(function () {
                            location.href = data.url;
                        }, 2000);
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function () {
                  console.log(response)
                }
            });
        });*/
</script>
@endpush
