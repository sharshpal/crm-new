<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nome'), 'has-success': fields.nome && fields.nome.valid }">
    <label for="nome" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.esito.columns.nome') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nome" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nome'), 'form-control-success': fields.nome && fields.nome.valid}" id="nome" name="nome" placeholder="{{ trans('admin.esito.columns.nome') }}">
        <div v-if="errors.has('nome')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nome') }}</div>
    </div>
</div>

@if(false)
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('cod'), 'has-success': fields.cod && fields.cod.valid }">
    <label for="cod" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.esito.columns.cod') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.cod" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('cod'), 'form-control-success': fields.cod && fields.cod.valid}" id="cod" name="cod" placeholder="{{ trans('admin.esito.columns.cod') }}">
        <div v-if="errors.has('cod')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('cod') }}</div>
    </div>
</div>
@endif


<div class="form-check row"
     :class="{'has-danger': errors.has('is_final'), 'has-success': fields.is_final && fields.is_final.valid }">
    <div class="ml-md-auto pl-0" :class="isFormLocalized ? 'col-md-9' : 'col-md-9'">
        <input class="form-check-input" id="is_final" type="checkbox" v-model="form.is_final"
               v-validate="''"
               data-vv-name="is_final" name="is_final_fake_element"
        >
        <label class="form-check-label" for="is_final">
            {{ trans('admin.esito.columns.is_final') }}
        </label>
        <input type="hidden" name="is_final" :value="form.is_final"
               v-validate="''">
        <div v-if="errors.has('is_final')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('is_final') }}
        </div>
    </div>
</div>


<div class="form-check row"
     :class="{'has-danger': errors.has('is_ok'), 'has-success': fields.is_ok && fields.is_ok.valid }">
    <div class="ml-md-auto pl-0" :class="isFormLocalized ? 'col-md-9' : 'col-md-9'">
        <input class="form-check-input" id="is_ok" type="checkbox" v-model="form.is_ok"
               v-validate="''"
               data-vv-name="is_ok"
               name="is_ok_fake_element"
        >
        <label class="form-check-label" for="is_ok">
            {{ trans('admin.esito.columns.is_ok') }}
        </label>
        <input type="hidden"
               name="is_ok"
               :value="form.is_ok"
               v-validate="''"
        >
        <div v-if="errors.has('is_ok')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('is_ok') }}
        </div>
    </div>
</div>

