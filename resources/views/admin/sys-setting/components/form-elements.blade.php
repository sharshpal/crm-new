<div class="form-group row align-items-center" :class="{'has-danger': errors.has('crm_user'), 'has-success': fields.crm_user && fields.crm_user.valid }">
    <label for="crm_user" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sys-setting.columns.crm_user') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.crm_user" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('crm_user'), 'form-control-success': fields.crm_user && fields.crm_user.valid}" id="crm_user" name="crm_user" placeholder="{{ trans('admin.sys-setting.columns.crm_user') }}">
        <div v-if="errors.has('crm_user')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('crm_user') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('key'), 'has-success': fields.key && fields.key.valid }">
    <label for="key" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sys-setting.columns.key') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

            <multiselect
                v-model="form.key"
                name="key"
                placeholder="{{ trans('admin.forms.select_an_option') }}"
                :options="{{json_encode($availableKeys)}}"
                :multiple="false"
                track-by="id"
                label="name"
                open-direction="bottom"
                :show-no-options="false"
                v-validate="'required'"
                @input="onSetKey"
            ></multiselect>

        <div v-if="errors.has('key')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('key') }}</div>
    </div>
</div>

@if(false)
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('value'), 'has-success': fields.value && fields.value.valid }">
    <label for="value" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.sys-setting.columns.value') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.value" v-validate="'required'" id="value" name="value"></textarea>
        </div>
        <div v-if="errors.has('value')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('value') }}</div>
    </div>
</div>
@endif


<div v-if="isGlobalPanel()">
    <h2>Global</h2>
</div>

<div v-if="isTemplatePanel()" >

    <div class="row mt-5">
        <h4 class="pl-4">Colori Principali</h4>
        <hr class="w-100"/>
        <div class="col-lg-12 d-flex justify-content-start flex-wrap">
            <div class="color-ctn" v-for="(color,index) in form.value.colors" v-if="color.type=='color'">
                <div class="color-title">@{{getColorLabel(color.id)}}</div>
                <div>
                    <verte  menu-position="top" picker="square" model="rgb" v-model="form.value.colors[index].value" @input="colorChanged($event,color)" :showHistory="true" :color-history.sync="primaryColorList"></verte>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <h4 class="pl-4">Elementi</h4>
        <hr class="w-100"/>
        <div class="col-lg-12 d-flex justify-content-start flex-wrap">
            <div class="color-ctn" v-for="(color,index) in form.value.colors" v-if="color.type=='status'">
                <div class="color-title">@{{getColorLabel(color.id)}}</div>
                <div>
                    <verte  menu-position="top" picker="square" model="rgb" v-model="form.value.colors[index].value" @input="colorChanged($event,color)" :showHistory="true" :color-history.sync="primaryColorList"></verte>
                </div>
            </div>
        </div>
    </div>


</div>
