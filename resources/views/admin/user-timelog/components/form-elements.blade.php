

<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('user'), 'has-success': fields.user && fields.user.valid }">
    <label for="user" class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-timelog.columns.user') }}
        </label>
    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-9 col-xl-8'">
        <multiselect

            v-model="form.user"
            placeholder="{{ trans('admin.forms.search_a_user') }}"
            :options="userList"
            :multiple="false"
            track-by="id"
            label="full_name"
            open-direction="bottom"
            :show-no-options="false"
            v-validate="'required'"
            name="user"
            :loading="searchUserIsLoading"
            :preserve-search="false"
            @search-change="asyncUserFind"
            @open="resetUserList"
        >
            <template slot="noResult">
                {{ trans('admin.forms.no_result') }}
            </template>
            <template slot="noOptions">
                {{ trans('admin.forms.no_result') }}
            </template>
        </multiselect>
        <div v-if="errors.has('user')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('user')
            }}
        </div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('period'), 'has-success': fields.period && fields.period.valid }">
    <label for="period" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-timelog.columns.period') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.period" :config="datePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('period'), 'form-control-success': fields.period && fields.period.valid}" id="period" name="period" placeholder="{{ trans('admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('period')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('period') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ore'), 'has-success': fields.ore && fields.ore.valid }">
    <label for="ore" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-timelog.columns.ore') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ore" v-validate="'required|decimal:2'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ore'), 'form-control-success': fields.ore && fields.ore.valid}" id="ore" name="ore" placeholder="{{ trans('admin.user-timelog.columns.ore') }}">
        <div v-if="errors.has('ore')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ore') }}</div>
    </div>
</div>







