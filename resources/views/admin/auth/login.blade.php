@extends('ui.layout.auth')

@section('title', trans('admin.login.title'))

@section('content')


<div class="container" id="app">

          <div class="col-md-4 ml-auto mr-auto">
		  <auth-form :action="'{{ url('/login') }}'" :data="{}" inline-template>
		  <div class="">
				  <h1 class="text-white text-center">{{ trans('admin.login.title') }}</h1>
				  <p class="text-white text-center">{{ trans('admin.login.sign_in_text') }}</p>
                  </div>
		  @include('admin.auth.includes.messages')
		  <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" novalidate>
								{{ csrf_field() }}
              <div class="card card-login card-plain">
                <div class="card-header ">
                  
                </div>
                <div class="card-body ">
                  <div class="input-group no-border form-control-lg">
                    <span class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                      </div>
                    </span>
                    <input
                                                type="text"
                                                v-model="form.email"
                                                v-validate="'required|email'"
                                                class="form-control"
                                                :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}"
                                                id="email"
                                                name="email"
                                                placeholder="{{ trans('admin.auth_global.email') }}">
                  </div>
                  <div class="input-group no-border form-control-lg">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="now-ui-icons objects_key-25"></i>
                      </div>
                    </div>
                    <input type="password" v-model="form.password"  class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.auth_global.password') }}">
                  </div>
                </div>
                <div class="card-footer ">
				@if(false)<input type="hidden" name="remember" value="1">@endif
                  <button type="submit"  class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ trans('admin.login.button') }}</button>
                  @if(false) 
				  <div class="pull-left">
                    <h6><a href="{{ url('/password-reset') }}" class="link footer-link">{{ trans('admin.login.forgot_password') }}</a></h6>
                  </div>
				  @endif
                  
                </div>
              </div>
            </form>
			</auth-form>
          </div>
        </div>








@endsection


@section('bottom-scripts')
<script type="text/javascript">
    // fix chrome password autofill
    // https://github.com/vuejs/vue/issues/1331
    document.getElementById('password').dispatchEvent(new Event('input'));
</script>
@endsection
