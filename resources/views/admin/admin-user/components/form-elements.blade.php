<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.first_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="text"
               v-model="form.first_name"
               v-validate="'required'"
               @input="validate($event)" class="form-control"
               :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}"
               id="first_name"
               name="first_name"
               placeholder="{{ trans('admin.admin-user.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('first_name') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('last_name'), 'has-success': fields.last_name && fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.last_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control"
               :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': fields.last_name && fields.last_name.valid}"
               id="last_name" name="last_name" placeholder="{{ trans('admin.admin-user.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('last_name') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="text" v-model="form.email" v-validate="'required|email'" @input="validate($event)"
               class="form-control"
               :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}"
               id="email" name="email" placeholder="{{ trans('admin.admin-user.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
    <label for="password" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="password"
               v-model="form.password"
               v-validate="{required:isCreate,min:8,regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/}"
               @input="validate($event)"
               class="form-control"
               :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}"
               id="password"
               name="password" placeholder="{{ trans('admin.admin-user.columns.password') }}"
               ref="password">
        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password')
            }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
    <label for="password_confirmation" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.password_repeat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="password" v-model="form.password_confirmation"
               v-validate="{confirmed:form.password,required:isCreate,min:8,regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/}"
               @input="validate($event)" class="form-control"
               :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}"
               id="password_confirmation" name="password_confirmation"
               placeholder="{{ trans('admin.admin-user.columns.password') }}" data-vv-as="password">
        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('password_confirmation') }}
        </div>
    </div>
</div>

<div class="form-group row" v-if="activation"
     :class="{'has-danger': errors.has('activated'), 'has-success': fields.activated && fields.activated.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="activated" type="checkbox" v-model="form.activated" v-validate="''"
               data-vv-name="activated" name="activated_fake_element">
        <label class="form-check-label" for="activated">
            {{ trans('admin.admin-user.columns.activated') }}
        </label>
        <input type="hidden" name="activated" :value="form.activated">
        <div v-if="errors.has('activated')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('activated') }}
        </div>
    </div>
</div>

<div class="form-group row"
     :class="{'has-danger': errors.has('forbidden'), 'has-success': fields.forbidden && fields.forbidden.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-9'">
        <input class="form-check-input" id="forbidden" type="checkbox" v-model="form.forbidden" v-validate="''"
               data-vv-name="forbidden" name="forbidden_fake_element">
        <label class="form-check-label" for="forbidden">
            {{ trans('admin.admin-user.columns.forbidden') }}
        </label>
        <input type="hidden" name="forbidden" :value="form.forbidden">
        <div v-if="errors.has('forbidden')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('forbidden') }}
        </div>
    </div>
</div>

@if(false)
    <div class="form-group row align-items-center"
         :class="{'has-danger': errors.has('language'), 'has-success': fields.language && fields.language.valid }">
        <label for="language" class="col-form-label text-md-right"
               :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.language') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
            <multiselect v-model="form.language" placeholder="{{ trans('admin.forms.select_an_option') }}"
                         :options="{{ $locales->toJson() }}" open-direction="bottom"></multiselect>
            <div v-if="errors.has('language')" class="form-control-feedback form-text" v-cloak>@{{
                errors.first('language') }}
            </div>
        </div>
    </div>
@endif

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('roles'), 'has-success': fields.roles && fields.roles.valid }">
    <label for="roles" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.roles') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <multiselect
            name="roles"
            v-validate="'required'"
            v-model="form.roles"
            placeholder="{{ trans('admin.forms.select_options') }}"
            label="label" track-by="id"
            :options="{{ $roles->toJson() }}" :multiple="false" open-direction="bottom"></multiselect>
        <div v-if="errors.has('roles')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('roles') }}
        </div>
    </div>
</div>


<div v-if="form.roles && form.roles.name!='Admin'"
     class="form-group row align-items-center"
     :class="{'has-danger': errors.has('campaigns'), 'has-success': fields.campaigns && fields.campaigns.valid }">
    <label for="campaigns" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.campaigns') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <multiselect
            name="campaigns"
            v-model="form.campaigns"
            placeholder="{{ trans('admin.forms.select_options') }}"
            label="nome"
            track-by="id"
            :options="campaignsList"
            :multiple="true" open-direction="bottom">
        </multiselect>
        <div v-if="errors.has('campaigns')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('campaigns') }}
        </div>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-success" @click="assignAllCampaigns()">Assegna Tutto</button>
        <button type="button" class="btn btn-warning ml-2" @click="clearAllCampaigns()">Pulisci Tutto</button>
    </div>
</div>


<div v-if="form.roles && form.roles.name!='Admin'"
     class="form-group row align-items-center"
     :class="{'has-danger': errors.has('partners'), 'has-success': fields.partners && fields.partners.valid }">
    <label for="partners" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.partners') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <multiselect
            v-model="form.partners"
            name="partners"
            placeholder="{{ trans('admin.forms.select_options') }}"
            label="nome"
            track-by="id"
            :options="partnersList"
            :multiple="isSimpleOperator() ? false : true"
            v-validate="isSimpleOperator() ? 'required' : ''"
            open-direction="bottom"></multiselect>
        <div v-if="errors.has('partners')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partners')
            }}
        </div>
    </div>
    <div class="col-md-3" v-if="!isSimpleOperator()">
        <button type="button" class="btn btn-success" @click="assignAllPartners()">Assegna Tutto</button>
        <button type="button" class="btn btn-warning ml-2" @click="clearAllPartners()">Pulisci Tutto</button>
    </div>
</div>

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('ipfilter'), 'has-success': fields.ipfilter && fields.ipfilter.valid }">
    <label for="ipfilter" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.admin-user.columns.ipfilter') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-6 col-xl-6'">
        <input type="text" v-model="form.ipfilter" v-validate="''" @input="validate($event)" class="form-control"
               :class="{'form-control-danger': errors.has('ipfilter'), 'form-control-success': fields.ipfilter && fields.ipfilter.valid}"
               id="ipfilter" name="ipfilter" placeholder="{{ trans('admin.admin-user.columns.ipfilter') }}">
        <div v-if="errors.has('ipfilter')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ipfilter')
            }}
        </div>
    </div>
</div>
