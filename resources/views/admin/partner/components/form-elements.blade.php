<div class="row">
    <div class="col-md-4 text-center">
        <div class="avatar-upload">
            @include('ui.partials.avatar-uploader', [
                'mediaCollection' => app(\App\Models\Partner::class)->getMediaCollection('logo'),
                'media' => $partner->getThumbs200ForCollection('logo'),
                'clickable'=>true,
                'showRemoveLink'=> true,
                'maxNumberOfFiles'=>1
            ])
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('nome'), 'has-success': fields.nome && fields.nome.valid }">
            <label for="nome" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.partner.columns.nome') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.nome" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nome'), 'form-control-success': fields.nome && fields.nome.valid}" id="nome" name="nome" placeholder="{{ trans('admin.partner.columns.nome') }}">
                <div v-if="errors.has('nome')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nome') }}</div>
            </div>
        </div>

        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('campaigns'), 'has-success': fields.campaigns && fields.campaigns.valid }">
            <label for="campaigns" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.admin-user.columns.campaigns') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <multiselect v-model="form.campaigns" placeholder="{{ trans('admin.forms.select_options') }}" label="nome" track-by="id" :options="campaignsList" :multiple="true" open-direction="bottom"></multiselect>
                <div v-if="errors.has('campaigns')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('campaigns') }}</div>
            </div>
        </div>


        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('vc_usergroup'), 'has-success': fields.vc_usergroup && fields.vc_usergroup.valid }">
            <label for="vc_usergroup" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.partner.columns.vc_usergroup') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.vc_usergroup" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vc_usergroup'), 'form-control-success': fields.vc_usergroup && fields.vc_usergroup.valid}" id="vc_usergroup" name="vc_usergroup" placeholder="{{ trans('admin.partner.columns.vc_usergroup') }}">
                <div v-if="errors.has('vc_usergroup')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vc_usergroup') }}</div>
            </div>
        </div>
    </div>
</div>



