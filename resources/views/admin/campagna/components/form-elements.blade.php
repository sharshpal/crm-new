<div class="row">
    <div class="col-md-4 text-center">
        <div class="avatar-upload">
            @include('ui.partials.avatar-uploader', [
            'mediaCollection' => app(\App\Models\Campagna::class)->getMediaCollection('logo'),
            'media' => $campagna->getThumbs200ForCollection('logo'),
            'clickable'=>true,
            'showRemoveLink'=> true,
            'maxNumberOfFiles'=>1
        ])
        </div>
    </div>
    <div class="col-md-8">

        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('nome'), 'has-success': fields.nome && fields.nome.valid }">
            <label for="nome" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.campagna.columns.nome') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.nome" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nome'), 'form-control-success': fields.nome && fields.nome.valid}" id="nome" name="nome" placeholder="{{ trans('admin.campagna.columns.nome') }}">
                <div v-if="errors.has('nome')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nome') }}</div>
            </div>
        </div>


        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('tipo'), 'has-success': fields.tipo && fields.tipo.valid }">
            <label for="tipo" class="col-form-label  text-md-right"
                   :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.campagna.columns.tipo') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <multiselect
                    v-model="form.tipo"
                    placeholder="{{ trans('admin.forms.select_an_option') }}"
                    :options="[{id:'lucegas',label:'Luce + Gas'},{id:'telefonia',label:'Telefonia'}]"
                    :multiple="false"
                    track-by="id"
                    label="label"
                    open-direction="bottom"
                    :allow-empty="false"
                    v-validate="'required'"
                    name="tipo"
                ></multiselect>
                <div v-if="errors.has('tipo')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('tipo') }}
                </div>
            </div>
        </div>
    </div>

</div>



