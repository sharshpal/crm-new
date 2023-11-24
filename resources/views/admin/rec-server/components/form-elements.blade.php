<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.rec-server.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select
               v-model="form.type" v-validate="'required'" @input="validate($event)"
               class="form-control"
               :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}"
               id="type" name="type">
            <option :value="'vicidial'">Vicidial</option>
        </select>
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_driver'), 'has-success': fields.db_driver && fields.db_driver.valid }">
    <label for="db_driver" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_driver') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select
            v-model="form.db_driver" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('db_driver'), 'form-control-success': fields.db_driver && fields.db_driver.valid}"
            id="db_driver" name="db_driver">
            <option :value="'mysql'">Mysql</option>
        </select>
        <div v-if="errors.has('db_driver')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_driver') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_host'), 'has-success': fields.db_host && fields.db_host.valid }">
    <label for="db_host" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_host') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_host" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_host'), 'form-control-success': fields.db_host && fields.db_host.valid}" id="db_host" name="db_host" placeholder="{{ trans('admin.rec-server.columns.db_host') }}">
        <div v-if="errors.has('db_host')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_host') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_port'), 'has-success': fields.db_port && fields.db_port.valid }">
    <label for="db_port" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_port') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_port" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_port'), 'form-control-success': fields.db_port && fields.db_port.valid}" id="db_port" name="db_port" placeholder="{{ trans('admin.rec-server.columns.db_port') }}">
        <div v-if="errors.has('db_port')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_port') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_name'), 'has-success': fields.db_name && fields.db_name.valid }">
    <label for="db_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_name'), 'form-control-success': fields.db_name && fields.db_name.valid}" id="db_name" name="db_name" placeholder="{{ trans('admin.rec-server.columns.db_name') }}">
        <div v-if="errors.has('db_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_user'), 'has-success': fields.db_user && fields.db_user.valid }">
    <label for="db_user" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_user') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_user" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_user'), 'form-control-success': fields.db_user && fields.db_user.valid}" id="db_user" name="db_user" placeholder="{{ trans('admin.rec-server.columns.db_user') }}">
        <div v-if="errors.has('db_user')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_user') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_password'), 'has-success': fields.db_password && fields.db_password.valid }">
    <label for="db_password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_password') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.db_password" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_password'), 'form-control-success': fields.db_password && fields.db_password.valid}" id="db_password" name="db_password" placeholder="{{ trans('admin.rec-server.columns.db_password') }}">
        <div v-if="errors.has('db_password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_password') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('db_rewrite_host'), 'has-success': fields.db_rewrite_host && fields.db_rewrite_host.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="db_rewrite_host" type="checkbox" v-model="form.db_rewrite_host" v-validate="''" data-vv-name="db_rewrite_host"  name="db_rewrite_host_fake_element">
        <label class="form-check-label" for="db_rewrite_host">
            {{ trans('admin.rec-server.columns.db_rewrite_host') }}
        </label>
        <input type="hidden" name="db_rewrite_host" :value="form.db_rewrite_host">
        <div v-if="errors.has('db_rewrite_host')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_rewrite_host') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_rewrite_search'), 'has-success': fields.db_rewrite_search && fields.db_rewrite_search.valid }">
    <label for="db_rewrite_search" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_rewrite_search') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_rewrite_search" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_rewrite_search'), 'form-control-success': fields.db_rewrite_search && fields.db_rewrite_search.valid}" id="db_rewrite_search" name="db_rewrite_search" placeholder="{{ trans('admin.rec-server.columns.db_rewrite_search') }}">
        <div v-if="errors.has('db_rewrite_search')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_rewrite_search') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('db_rewrite_replace'), 'has-success': fields.db_rewrite_replace && fields.db_rewrite_replace.valid }">
    <label for="db_rewrite_replace" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.rec-server.columns.db_rewrite_replace') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.db_rewrite_replace" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('db_rewrite_replace'), 'form-control-success': fields.db_rewrite_replace && fields.db_rewrite_replace.valid}" id="db_rewrite_replace" name="db_rewrite_replace" placeholder="{{ trans('admin.rec-server.columns.db_rewrite_replace') }}">
        <div v-if="errors.has('db_rewrite_replace')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('db_rewrite_replace') }}</div>
    </div>
</div>


