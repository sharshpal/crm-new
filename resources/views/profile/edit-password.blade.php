@extends('ui.layout.app')

@section('title', trans('admin.admin-user.actions.edit_password'))

@section('body')

    <div class="container-xl">

        <div class="card">

            <profile-edit-password-form
                :action="'{{ url('profile/password') }}'"
                :data="{{ $adminUser->toJson() }}"
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.admin-user.actions.edit_password') }}
                    </div>

                    <div class="card-body">

                        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
                            <label for="password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
                                <input type="password" v-model="form.password"
                                       v-validate="{required:true,min:8,regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/}"
                                       @input="validate($event)"
                                       class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.admin-user.columns.password') }}" ref="password">
                                <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
                            <label for="password_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password_repeat') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-7'">
                                <input type="password"
                                       v-model="form.password_confirmation"
                                       v-validate="{confirmed:form.password,required:true,min:8,regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/}"
                                       @input="validate($event)"
                                       class="form-control"
                                       :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.admin-user.columns.password') }}" data-vv-as="password">
                                <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
                            </div>
                        </div>


                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

            </profile-edit-password-form>

        </div>

    </div>

@endsection
