<div class="card card-accent-primary">
    <header class="card-header">
        <h2 class="text-center">Dati Contratto</h2>
    </header>
    <div class="card-body">
        <div class="row">

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('partner'), 'has-success': fields.partner && fields.partner.valid }">
                    <label for="partner" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.partner') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            v-model="form.partner"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="partnersList"
                            :multiple="false"
                            track-by="id"
                            label="nome"
                            open-direction="bottom"
                            :show-no-options="false"
                            v-validate="'required'"
                            name="partner"
                            :disabled="!isEdit || partnersList.length==1"
                            @input="onSetPartner"
                        ></multiselect>
                        <div v-if="errors.has('partner')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('partner')
                            }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('campagna'), 'has-success': fields.campagna && fields.campagna.valid }">
                    <label for="campagna" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.campagna') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            v-model="form.campagna"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="campaignsList"
                            :multiple="false"
                            track-by="id"
                            label="nome"
                            open-direction="bottom"
                            :show-no-options="false"
                            v-validate="'required'"
                            name="campagna"
                            id="campagna"
                            :disabled="!isEdit"
                            @input="onSetCampaign"
                        ></multiselect>
                        <div v-if="errors.has('campagna')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('campagna')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <div class="row">
            @can("admin.admin-user.search")
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row align-items-center"
                         :class="{'has-danger': errors.has('crm_user'), 'has-success': fields.crm_user && fields.crm_user.valid }">
                        <label for="crm_user" class="col-form-label"
                               :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.crm_user') }}
                            *</label>
                        <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                            <multiselect

                                v-model="form.crm_user"
                                placeholder="{{ trans('admin.forms.search_a_user') }}"
                                :options="userList"
                                :multiple="false"
                                track-by="id"
                                label="full_name"
                                open-direction="bottom"
                                :show-no-options="false"
                                v-validate="'required'"
                                name="crm_user"
                                :disabled="!isEdit"
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
                            <div v-if="errors.has('crm_user')" class="form-control-feedback form-text" v-cloak>@{{
                                errors.first('crm_user')
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can("dati-contratto.edit-create-date")
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row align-items-center"
                         :class="{'has-danger': errors.has('created_at'), 'has-success': fields.created_at && fields.created_at.valid }">
                        <label for="created_at" class="col-form-label"
                               :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.created_at') }}</label>
                        <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                            <div class="input-group">
                                <datetime
                                    :disabled="!isEdit"
                                    name="created_at"
                                    v-model="form.created_at"
                                    :config="datetimePickerConfig"
                                    class="flatpickr text-center"
                                    placeholder="Seleziona data creazione"
                                    v-validate="'required'"
                                ></datetime>
                                <div class="input-group-append" v-if="isEdit">
                                    <button type="button" class="btn btn-sm btn-primary m-0"
                                            @click="form.created_at=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                </div>
                            </div>
                            <div v-if="errors.has('created_at')" class="form-control-feedback form-text"
                                 v-cloak>@{{
                                errors.first('created_at') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-lg-6 col-sm-12" v-if="showCp">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('codice_pratica'), 'has-success': fields.codice_pratica && fields.codice_pratica.valid }">
                    <label for="codice_pratica" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.codice_pratica') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.codice_pratica" v-validate="''" maxlength="100"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('codice_pratica'), 'form-control-success': fields.codice_pratica && fields.codice_pratica.valid}"
                               id="codice_pratica" name="codice_pratica"
                               placeholder="{{ trans('admin.dati-contratto.columns.codice_pratica') }}">
                        <div v-if="errors.has('codice_pratica')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('codice_pratica') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tipo_offerta'), 'has-success': fields.tipo_offerta && fields.tipo_offerta.valid }">
                    <label for="tipo_offerta" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tipo_offerta') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.tipo_offerta"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="tipoOffertaList()"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                            :allow-empty="false"
                            v-validate="'required'"
                            name="tipo_offerta"
                            id="tipo_offerta"
                        ></multiselect>
                        <div v-if="errors.has('tipo_offerta')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tipo_offerta') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tipo_contratto'), 'has-success': fields.tipo_contratto && fields.tipo_contratto.valid }">
                    <label for="tipo_contratto" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tipo_contratto') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.tipo_contratto"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'family',label:'Family'},{id:'business',label:'Business'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                            :allow-empty="false"
                            v-validate="'required'"
                            name="tipo_contratto"
                        ></multiselect>
                        <div v-if="errors.has('tipo_contratto')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('tipo_contratto') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('lista'), 'has-success': fields.lista && fields.lista.valid }">
                    <label for="lista" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.lista') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.lista" v-validate="''" maxlength="100"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('lista'), 'form-control-success': fields.lista && fields.lista.valid}"
                               id="lista" name="lista"
                               placeholder="{{ trans('admin.dati-contratto.columns.lista') }}">
                        <div v-if="errors.has('lista')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('lista') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<hr/>


<div class="card card-accent-primary" v-if="isBusiness()">
    <header class="card-header">
        <h2 class="text-center">Dati Azienda</h2>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_rag_soc'), 'has-success': fields.owner_rag_soc && fields.owner_rag_soc.valid }">
                    <label for="owner_rag_soc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_rag_soc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               v-model="form.owner_rag_soc"
                               maxlength="255"
                               name="owner_rag_soc"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_rag_soc'), 'form-control-success': fields.owner_rag_soc && fields.owner_rag_soc.valid}"
                               id="owner_rag_soc" name="owner_rag_soc"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_rag_soc') }}">
                        <div v-if="errors.has('owner_rag_soc')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_rag_soc') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_piva'), 'has-success': fields.owner_piva && fields.owner_piva.valid }">
                    <label for="owner_piva" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_piva') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="11"
                               v-model="form.owner_piva"
                               name="owner_piva"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_piva'), 'form-control-success': fields.owner_piva && fields.owner_piva.valid}"
                               id="owner_piva" name="owner_piva"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_piva') }}">
                        <div v-if="errors.has('owner_piva')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_piva') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_az_nome_societa'), 'has-success': fields.owner_az_nome_societa && fields.owner_az_nome_societa.valid }">
                    <label for="owner_az_nome_societa" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_az_nome_societa') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="255"
                               v-model="form.owner_az_nome_societa"
                               name="owner_az_nome_societa"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_az_nome_societa'), 'form-control-success': fields.owner_az_nome_societa && fields.owner_az_nome_societa.valid}"
                               id="owner_az_nome_societa"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_az_nome_societa') }}">
                        <div v-if="errors.has('owner_az_nome_societa')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('owner_az_nome_societa') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_az_codice_business'), 'has-success': fields.owner_az_codice_business && fields.owner_az_codice_business.valid }">
                    <label for="owner_az_codice_business" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_az_codice_business') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               v-model="form.owner_az_codice_business"
                               maxlength="255"
                               name="owner_az_codice_business"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_az_codice_business'), 'form-control-success': fields.owner_az_codice_business && fields.owner_az_codice_business.valid}"
                               id="owner_az_codice_business"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_az_codice_business') }}">
                        <div v-if="errors.has('owner_az_codice_business')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('owner_az_codice_business') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_az_comune'), 'has-success': fields.owner_az_comune && fields.owner_az_comune.valid }">
                    <label for="owner_az_comune" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_az_comune') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="255"
                               v-model="form.owner_az_comune"
                               name="owner_az_comune"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_az_comune'), 'form-control-success': fields.owner_az_comune && fields.owner_az_comune.valid}"
                               id="owner_az_comune" name="owner_az_comune"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_az_comune') }}">
                        <div v-if="errors.has('owner_az_comune')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('owner_az_comune') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_az_prov'), 'has-success': fields.owner_az_prov && fields.owner_az_prov.valid }">
                    <label for="owner_az_prov" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-5' : 'col-md-5'">{{ trans('admin.dati-contratto.columns.owner_az_prov') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-7' : 'col-md-7 col-xl-7'">
                        <input type="text"
                               maxlength="2"
                               v-model="form.owner_az_prov"
                               name="owner_az_prov"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_az_prov'), 'form-control-success': fields.owner_az_prov && fields.owner_az_prov.valid}"
                               id="owner_az_prov" name="owner_az_prov"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_az_prov') }}">
                        <div v-if="errors.has('owner_az_prov')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_az_prov') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_az_cap'), 'has-success': fields.owner_az_cap && fields.owner_az_cap.valid }">
                    <label for="owner_az_cap" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_az_cap') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-7 col-xl-8'">
                        <input type="text"
                               maxlength="5"
                               v-model="form.owner_az_cap"
                               name="owner_az_cap"
                               v-validate="isBusiness() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_az_cap'), 'form-control-success': fields.owner_az_cap && fields.owner_az_cap.valid}"
                               id="owner_az_cap" name="owner_az_cap"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_az_cap') }}">
                        <div v-if="errors.has('owner_az_cap')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_az_cap') }}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="card card-accent-primary">
    <header class="card-header">
        <h2 class="text-center" v-text="isBusiness() ? 'Dati del Referente' : 'Dati Intestatario'"></h2>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_nome'), 'has-success': fields.owner_nome && fields.owner_nome.valid }">
                    <label for="owner_nome" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_nome') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_nome" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_nome'), 'form-control-success': fields.owner_nome && fields.owner_nome.valid}"
                               id="owner_nome" name="owner_nome"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_nome') }}">
                        <div v-if="errors.has('owner_nome')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_nome') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_cognome'), 'has-success': fields.owner_cognome && fields.owner_cognome.valid }">
                    <label for="owner_cognome" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_cognome') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_cognome" v-validate="'required'"
                               maxlength="255"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_cognome'), 'form-control-success': fields.owner_cognome && fields.owner_cognome.valid}"
                               id="owner_cognome" name="owner_cognome"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_cognome') }}">
                        <div v-if="errors.has('owner_cognome')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_cognome') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_dob'), 'has-success': fields.owner_dob && fields.owner_dob.valid }">
                    <label for="owner_dob" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.owner_dob"
                    >
                        {{ trans('admin.dati-contratto.columns.owner_dob') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="owner_dob"
                                v-model="form.owner_dob"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data nascita"
                                v-validate="'required'"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.owner_dob=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('owner_dob')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_dob') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_pob'), 'has-success': fields.owner_pob && fields.owner_pob.valid }">
                    <label for="owner_pob" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_pob') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_pob" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_pob'), 'form-control-success': fields.owner_pob && fields.owner_pob.valid}"
                               id="owner_pob" name="owner_pob"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_pob') }}">
                        <div v-if="errors.has('owner_pob')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_pob') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_tipo_doc'), 'has-success': fields.owner_tipo_doc && fields.owner_tipo_doc.valid }">
                    <label for="owner_tipo_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_tipo_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.owner_tipo_doc"
                            name="owner_tipo_doc"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'carta_identita',label:'Carta Identita'},{id:'patente',label:'Patente'},{id:'passaporto',label:'Passaporto'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('owner_tipo_doc')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_tipo_doc') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_ente_doc'), 'has-success': fields.owner_ente_doc && fields.owner_ente_doc.valid }">
                    <label for="owner_ente_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_ente_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_ente_doc" v-validate="'required'"
                               maxlength="255"
                               :disabled="!isEdit"
                               @input="validate($event)"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_ente_doc'), 'form-control-success': fields.owner_ente_doc && fields.owner_ente_doc.valid}"
                               id="owner_ente_doc" name="owner_ente_doc"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_ente_doc') }}">
                        <div v-if="errors.has('owner_ente_doc')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_ente_doc') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_nr_doc'), 'has-success': fields.owner_nr_doc && fields.owner_nr_doc.valid }">
                    <label for="owner_nr_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_nr_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_nr_doc" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="45"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_nr_doc'), 'form-control-success': fields.owner_nr_doc && fields.owner_nr_doc.valid}"
                               id="owner_nr_doc" name="owner_nr_doc"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_nr_doc') }}">
                        <div v-if="errors.has('owner_nr_doc')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_nr_doc') }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_doc_data'), 'has-success': fields.owner_doc_data && fields.owner_doc_data.valid }">
                    <label for="owner_doc_data" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.owner_doc_data"
                    >{{ trans('admin.dati-contratto.columns.owner_doc_data') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="owner_doc_data"
                                v-model="form.owner_doc_data"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data documento"
                                v-validate="'required'"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.owner_doc_data=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('owner_doc_data')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_doc_data') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_doc_scadenza'), 'has-success': fields.owner_doc_scadenza && fields.owner_doc_scadenza.valid }">
                    <label for="owner_doc_scadenza" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.owner_doc_scadenza"
                    >{{ trans('admin.dati-contratto.columns.owner_doc_scadenza') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="owner_doc_scadenza"
                                v-model="form.owner_doc_scadenza"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data scadenza"
                                v-validate="'required'"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.owner_doc_scadenza=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('owner_doc_scadenza')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('owner_doc_scadenza') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">


                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_cf'), 'has-success': fields.owner_cf && fields.owner_cf.valid }">
                    <label for="owner_cf" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_cf') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_cf" v-validate="'required'" @input="validate($event)"
                               maxlength="16"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_cf'), 'form-control-success': fields.owner_cf && fields.owner_cf.valid}"
                               id="owner_cf" name="owner_cf"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_cf') }}">
                        <div v-if="errors.has('owner_cf')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_cf')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('telefono'), 'has-success': fields.telefono && fields.telefono.valid }">
                    <label for="telefono" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.telefono') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.telefono" v-validate="'required'" @input="validate($event)"
                               maxlength="20"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('telefono'), 'form-control-success': fields.telefono && fields.telefono.valid}"
                               id="telefono" name="telefono"
                               placeholder="{{ trans('admin.dati-contratto.columns.telefono') }}">
                        <div v-if="errors.has('telefono')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('telefono')
                            }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('cellulare'), 'has-success': fields.cellulare && fields.cellulare.valid }">
                    <label for="cellulare" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.cellulare') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.cellulare" v-validate="''" @input="validate($event)"
                               maxlength="20"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('cellulare'), 'form-control-success': fields.cellulare && fields.cellulare.valid}"
                               id="cellulare" name="cellulare"
                               placeholder="{{ trans('admin.dati-contratto.columns.cellulare') }}">
                        <div v-if="errors.has('cellulare')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('cellulare') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_email'), 'has-success': fields.owner_email && fields.owner_email.valid }">
                    <label for="owner_email" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_email') }}
                    </label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="255"
                               v-model="form.owner_email"
                               name="owner_email"
                               v-validate="'email'"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_email'), 'form-control-success': fields.owner_email && fields.owner_email.valid}"
                               id="owner_email"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_email') }}">
                        <div v-if="errors.has('owner_email')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('owner_email')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<hr/>

<div class="card card-accent-primary">

    <header class="card-header">
        <h2 class="text-center">Indirizzo Residenza</h2>
    </header>

    <div class="card-body">

        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_indirizzo'), 'has-success': fields.owner_indirizzo && fields.owner_indirizzo.valid }">
                    <label for="owner_indirizzo" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-2' : 'col-md-4 col-lg-2'">{{ trans('admin.dati-contratto.columns.owner_indirizzo') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-10' : 'col-md-8 col-lg-10'">
                        <input type="text" v-model="form.owner_indirizzo" v-validate="'required'"
                               maxlength="255"
                               @change="onChangeIndResidenza"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_indirizzo'), 'form-control-success': fields.owner_indirizzo && fields.owner_indirizzo.valid}"
                               id="owner_indirizzo" name="owner_indirizzo"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_indirizzo') }}">
                        <div v-if="errors.has('owner_indirizzo')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('owner_indirizzo') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_civico'), 'has-success': fields.owner_civico && fields.owner_civico.valid }">
                    <label for="owner_civico" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_civico') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_civico" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="10"
                               @change="onChangeIndResidenza"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_civico'), 'form-control-success': fields.owner_civico && fields.owner_civico.valid}"
                               id="owner_civico" name="owner_civico"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_civico') }}">
                        <div v-if="errors.has('owner_civico')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_civico') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_comune'), 'has-success': fields.owner_comune && fields.owner_comune.valid }">
                    <label for="owner_comune" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-3' : 'col-md-4 col-lg-3'">{{ trans('admin.dati-contratto.columns.owner_comune') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-9' : 'col-md-8 col-lg-9'">
                        <input type="text" v-model="form.owner_comune" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               @change="onChangeIndResidenza"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_comune'), 'form-control-success': fields.owner_comune && fields.owner_comune.valid}"
                               id="owner_comune" name="owner_comune"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_comune') }}">
                        <div v-if="errors.has('owner_comune')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_comune') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_prov'), 'has-success': fields.owner_prov && fields.owner_prov.valid }">
                    <label for="owner_prov" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_prov') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_prov" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="2"
                               @change="onChangeIndResidenza"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_prov'), 'form-control-success': fields.owner_prov && fields.owner_prov.valid}"
                               id="owner_prov" name="owner_prov"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_prov') }}">
                        <div v-if="errors.has('owner_prov')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_prov') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('owner_cap'), 'has-success': fields.owner_cap && fields.owner_cap.valid }">
                    <label for="owner_cap" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.owner_cap') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.owner_cap"
                               v-validate="'required'" @input="validate($event)" maxlength="5"
                               @change="onChangeIndResidenza"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('owner_cap'), 'form-control-success': fields.owner_cap && fields.owner_cap.valid}"
                               id="owner_cap" name="owner_cap"
                               placeholder="{{ trans('admin.dati-contratto.columns.owner_cap') }}">
                        <div v-if="errors.has('owner_cap')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('owner_cap') }}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>


<div class="card card-accent-primary">

    <header class="card-header pb-3">
        <h2 class="text-center mb-0">
            Indirizzo Fornitura
            <div class="row no-gutters">
                <span class="card-chk d-flex">
                    <label class="switch switch-3d switch-success mb-0">
                        <input type="checkbox" class="switch-input"
                               :disabled="!isEdit"
                               v-model="use_forn_residenza"
                               @change="onToggleUseFornRes">
                        <span class="switch-slider"></span>
                    </label>
                    <label class="ml-2 my-switch-label mb-0">Usa Indirizzo Residenza</label>
                </span>
            </div>
        </h2>
    </header>

    <div class="card-body" v-show="!use_forn_residenza">

        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('forn_indirizzo'), 'has-success': fields.forn_indirizzo && fields.forn_indirizzo.valid }">
                    <label for="forn_indirizzo" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-2' : 'col-md-4 col-lg-2'">{{ trans('admin.dati-contratto.columns.forn_indirizzo') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-10' : 'col-md-8 col-lg-10'">
                        <input type="text" v-model="form.forn_indirizzo" v-validate="'required'"
                               maxlength="255"
                               :disabled="!isEdit"
                               @input="validate($event)"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('forn_indirizzo'), 'form-control-success': fields.forn_indirizzo && fields.forn_indirizzo.valid}"
                               id="forn_indirizzo" name="forn_indirizzo"
                               placeholder="{{ trans('admin.dati-contratto.columns.forn_indirizzo') }}">
                        <div v-if="errors.has('forn_indirizzo')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('forn_indirizzo') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('forn_civico'), 'has-success': fields.forn_civico && fields.forn_civico.valid }">
                    <label for="forn_civico" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.forn_civico') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.forn_civico" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="10"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('forn_civico'), 'form-control-success': fields.forn_civico && fields.forn_civico.valid}"
                               id="forn_civico" name="forn_civico"
                               placeholder="{{ trans('admin.dati-contratto.columns.forn_civico') }}">
                        <div v-if="errors.has('forn_civico')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('forn_civico') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('forn_comune'), 'has-success': fields.forn_comune && fields.forn_comune.valid }">
                    <label for="forn_comune" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-3' : 'col-md-4 col-lg-3'">{{ trans('admin.dati-contratto.columns.forn_comune') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-3' : 'col-md-8 col-xl-9'">
                        <input type="text" v-model="form.forn_comune" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('forn_comune'), 'form-control-success': fields.forn_comune && fields.forn_comune.valid}"
                               id="forn_comune" name="forn_comune"
                               placeholder="{{ trans('admin.dati-contratto.columns.forn_comune') }}">
                        <div v-if="errors.has('forn_comune')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('forn_comune') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('forn_prov'), 'has-success': fields.forn_prov && fields.forn_prov.valid }">
                    <label for="forn_prov" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.forn_prov') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.forn_prov" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="2"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('forn_prov'), 'form-control-success': fields.forn_prov && fields.forn_prov.valid}"
                               id="forn_prov" name="forn_prov"
                               placeholder="{{ trans('admin.dati-contratto.columns.forn_prov') }}">
                        <div v-if="errors.has('forn_prov')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('forn_prov') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('forn_cap'), 'has-success': fields.forn_cap && fields.forn_cap.valid }">
                    <label for="forn_cap" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.forn_cap') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.forn_cap" v-validate="'required'" @input="validate($event)"
                               maxlength="5"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('forn_cap'), 'form-control-success': fields.forn_cap && fields.forn_cap.valid}"
                               id="forn_cap" name="forn_cap"
                               placeholder="{{ trans('admin.dati-contratto.columns.forn_cap') }}">
                        <div v-if="errors.has('forn_cap')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('forn_cap')
                            }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="card card-accent-primary">

    <header class="card-header pb-3">
        <h2 class="text-center mb-0">
            Indirizzo Fatturazione
            <div class="row no-gutters">
                <span class="card-chk d-flex">
                    <label class="switch switch-3d switch-success mb-0">
                        <input type="checkbox" class="switch-input"
                               :disabled="!isEdit"
                               v-model="use_fatt_residenza"
                               @change="onToggleUseFattRes">
                        <span class="switch-slider"></span>
                    </label>
                    <label class="ml-2 my-switch-label mb-0">Usa Indirizzo Residenza</label>
                </span>
            </div>
        </h2>
    </header>

    <div class="card-body" v-show="!use_fatt_residenza">
        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('fatt_indirizzo'), 'has-success': fields.fatt_indirizzo && fields.fatt_indirizzo.valid }">
                    <label for="fatt_indirizzo" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-2' : 'col-md-4 col-lg-2'">{{ trans('admin.dati-contratto.columns.fatt_indirizzo') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-10' : 'col-md-8 col-lg-10'">
                        <input type="text" v-model="form.fatt_indirizzo" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('fatt_indirizzo'), 'form-control-success': fields.fatt_indirizzo && fields.fatt_indirizzo.valid}"
                               id="fatt_indirizzo" name="fatt_indirizzo"
                               placeholder="{{ trans('admin.dati-contratto.columns.fatt_indirizzo') }}">
                        <div v-if="errors.has('fatt_indirizzo')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('fatt_indirizzo') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('fatt_civico'), 'has-success': fields.fatt_civico && fields.fatt_civico.valid }">
                    <label for="fatt_civico" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.fatt_civico') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.fatt_civico" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="10"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('fatt_civico'), 'form-control-success': fields.fatt_civico && fields.fatt_civico.valid}"
                               id="fatt_civico" name="fatt_civico"
                               placeholder="{{ trans('admin.dati-contratto.columns.fatt_civico') }}">
                        <div v-if="errors.has('fatt_civico')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('fatt_civico') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('fatt_comune'), 'has-success': fields.fatt_comune && fields.fatt_comune.valid }">
                    <label for="fatt_comune" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4 col-lg-3' : 'col-md-4 col-lg-3'">{{ trans('admin.dati-contratto.columns.fatt_comune') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8 col-lg-9' : 'col-md-8 col-lg-9'">
                        <input type="text" v-model="form.fatt_comune" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('fatt_comune'), 'form-control-success': fields.fatt_comune && fields.fatt_comune.valid}"
                               id="fatt_comune" name="fatt_comune"
                               placeholder="{{ trans('admin.dati-contratto.columns.fatt_comune') }}">
                        <div v-if="errors.has('fatt_comune')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('fatt_comune') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('fatt_prov'), 'has-success': fields.fatt_prov && fields.fatt_prov.valid }">
                    <label for="fatt_prov" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.fatt_prov') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.fatt_prov" v-validate="'required'"
                               @input="validate($event)"
                               maxlength="2"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('fatt_prov'), 'form-control-success': fields.fatt_prov && fields.fatt_prov.valid}"
                               id="fatt_prov" name="fatt_prov"
                               placeholder="{{ trans('admin.dati-contratto.columns.fatt_prov') }}">
                        <div v-if="errors.has('fatt_prov')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('fatt_prov') }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('fatt_cap'), 'has-success': fields.fatt_cap && fields.fatt_cap.valid }">
                    <label for="fatt_cap" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.fatt_cap') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.fatt_cap" v-validate="'required'" @input="validate($event)"
                               maxlength="5"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('fatt_cap'), 'form-control-success': fields.fatt_cap && fields.fatt_cap.valid}"
                               id="fatt_cap" name="fatt_cap"
                               placeholder="{{ trans('admin.dati-contratto.columns.fatt_cap') }}">
                        <div v-if="errors.has('fatt_cap')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('fatt_cap')
                            }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<div class="card card-accent-primary">
    <div class="card-body">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('titolarita_immobile'), 'has-success': fields.titolarita_immobile && fields.titolarita_immobile.valid }">
            <label for="titolarita_immobile" class="col-form-label"
                   :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.titolarita_immobile') }}</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-8 col-xl-8'">
                <multiselect
                    :disabled="!isEdit"
                    v-model="form.titolarita_immobile"
                    placeholder="{{ trans('admin.forms.select_an_option') }}"
                    :options="[{id:'proprietario',label:'Proprietario'},{id:'inquilino',label:'Inquilino'},{id:'usufruttuario',label:'usufruttuario'},{id:'comodatario',label:'Comodatario'},{id:'altro',label:'Altro'}]"
                    :multiple="false"
                    track-by="id"
                    label="label"
                    open-direction="bottom"
                ></multiselect>
                <div v-if="errors.has('titolarita_immobile')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('titolarita_immobile') }}
                </div>
            </div>
        </div>

        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('fascia_reperibilita'), 'has-success': fields.fascia_reperibilita && fields.fascia_reperibilita.valid }">
            <label for="fascia_reperibilita" class="col-form-label"
                   :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.fascia_reperibilita') }}
                *</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-8 col-xl-8'">
                <multiselect
                    :disabled="!isEdit"
                    v-model="form.fascia_reperibilita"
                    name="fascia_reperibilita"
                    v-validate="'required'"
                    placeholder="{{ trans('admin.forms.select_an_option') }}"
                    :options="[{id:'mattina',label:'Mattina'},{id:'pomeriggio',label:'Pomeriggio'},{id:'sera',label:'Sera'}]"
                    :multiple="false"
                    track-by="id"
                    label="label"
                    open-direction="bottom"
                ></multiselect>
                <div v-if="errors.has('fascia_reperibilita')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('fascia_reperibilita') }}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card card-accent-primary">
    <header class="card-header">
        <h3 class="text-center">Tipo Fatturazione</h3>
    </header>
    <div class="card-body">

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tipo_fatturazione'), 'has-success': fields.tipo_fatturazione && fields.tipo_fatturazione.valid }">
                    <label for="tipo_fatturazione" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tipo_fatturazione') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.tipo_fatturazione"
                            name="tipo_fatturazione"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'email',label:'Email'},{id:'cartaceo',label:'Cartaceo'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('tipo_fatturazione')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tipo_fatturazione') }}
                        </div>
                    </div>
                </div>
            </div>


            <div v-if="form.tipo_fatturazione && form.tipo_fatturazione.id=='email'" class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tipo_fatturazione_email'), 'has-success': fields.tipo_fatturazione_email && fields.tipo_fatturazione_email.valid }">
                    <label for="tipo_fatturazione_email" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tipo_fatturazione_email') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="255"
                               v-model="form.tipo_fatturazione_email"
                               name="tipo_fatturazione_email"
                               v-validate="form.tipo_fatturazione && form.tipo_fatturazione.id=='email' ? 'required|email' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tipo_fatturazione_email'), 'form-control-success': fields.tipo_fatturazione_email && fields.tipo_fatturazione_email.valid}"
                               id="tipo_fatturazione_email"
                               placeholder="{{ trans('admin.dati-contratto.columns.tipo_fatturazione_email') }}">
                        <div v-if="errors.has('tipo_fatturazione_email')" class="form-control-feedback form-text"
                             v-cloak>@{{
                            errors.first('tipo_fatturazione_email')
                            }}
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>


<hr v-if="hasLuce()"/>
<div v-if="hasLuce()" class="card card-accent-primary">

    <header class="card-header">
        <h3 class="text-center">Offerta Luce</h3>
    </header>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-check row"
                     :class="{'has-danger': errors.has('luce_polizza'), 'has-success': fields.luce_polizza && fields.luce_polizza.valid }">
                    <div class="ml-md-auto pl-0" :class="isFormLocalized ? 'col-md-8' : 'col-md-8'">
                        <input class="form-check-input" id="luce_polizza" type="checkbox"
                               v-model="form.luce_polizza"
                               v-validate="''"
                               data-vname="luce_polizza" name="luce_polizza_fake_element"
                               :disabled="!isEdit"
                        >
                        <label class="form-check-label" for="luce_polizza">
                            {{ trans('admin.dati-contratto.columns.luce_polizza') }}
                        </label>
                        <input type="hidden" name="luce_polizza" :value="form.luce_polizza"
                               v-validate="''">
                        <div v-if="errors.has('luce_polizza')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_polizza') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_pod'), 'has-success': fields.luce_pod && fields.luce_pod.valid }">
                    <label for="luce_pod" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_pod') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_pod"
                               maxlength="20"
                               name="luce_pod"
                               v-validate="hasLuce() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_pod'), 'form-control-success': fields.luce_pod && fields.luce_pod.valid}"
                               id="luce_pod" name="luce_pod"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_pod') }}">
                        <div v-if="errors.has('luce_pod')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_pod')
                            }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_kw'), 'has-success': fields.luce_kw && fields.luce_kw.valid }">
                    <label for="luce_kw" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_kw') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_kw"
                               maxlength="20"
                               v-validate="hasLuce() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_kw'), 'form-control-success': fields.luce_kw && fields.luce_kw.valid}"
                               id="luce_kw" name="luce_kw"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_kw') }}">
                        <div v-if="errors.has('luce_kw')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_kw')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_tensione'), 'has-success': fields.luce_tensione && fields.luce_tensione.valid }">
                    <label for="luce_tensione" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_tensione') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_tensione"
                               maxlength="20"
                               v-validate=""
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_tensione'), 'form-control-success': fields.luce_tensione && fields.luce_tensione.valid}"
                               id="luce_tensione" name="luce_tensione"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_tensione') }}">
                        <div v-if="errors.has('luce_tensione')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_tensione') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_consumo'), 'has-success': fields.luce_consumo && fields.luce_consumo.valid }">
                    <label for="luce_consumo" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_consumo') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_consumo"
                               maxlength="20"
                               v-validate=""
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_consumo'), 'form-control-success': fields.luce_consumo && fields.luce_consumo.valid}"
                               id="luce_consumo" name="luce_consumo"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_consumo') }}">
                        <div v-if="errors.has('luce_consumo')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_consumo') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_fornitore'), 'has-success': fields.luce_fornitore && fields.luce_fornitore.valid }">
                    <label for="luce_fornitore" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_fornitore') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_fornitore"
                               maxlength="100"
                               name="luce_fornitore"
                               v-validate="hasLuce() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_fornitore'), 'form-control-success': fields.luce_fornitore && fields.luce_fornitore.valid}"
                               id="luce_fornitore" name="luce_fornitore"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_fornitore') }}">
                        <div v-if="errors.has('luce_fornitore')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_fornitore') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('luce_mercato'), 'has-success': fields.luce_mercato && fields.luce_mercato.valid }">
                    <label for="luce_mercato" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.luce_mercato') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.luce_mercato"
                               maxlength="45"
                               name="luce_mercato"
                               v-validate="hasLuce() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('luce_mercato'), 'form-control-success': fields.luce_mercato && fields.luce_mercato.valid}"
                               id="luce_mercato" name="luce_mercato"
                               placeholder="{{ trans('admin.dati-contratto.columns.luce_mercato') }}">
                        <div v-if="errors.has('luce_mercato')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('luce_mercato') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<hr v-if="hasGas()"/>
<div v-if="hasGas()" class="card card-accent-primary">
    <header class="card-header">
        <h2 class="text-center">Offerta Gas</h2>
    </header>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-check row"
                     :class="{'has-danger': errors.has('gas_polizza'), 'has-success': fields.gas_polizza && fields.gas_polizza.valid }">
                    <div class="ml-md-auto pl-0" :class="isFormLocalized ? 'col-md-8' : 'col-md-8'">
                        <input class="form-check-input" id="gas_polizza" type="checkbox" v-model="form.gas_polizza"
                               :disabled="!isEdit"
                               v-validate="''"
                               data-vname="gas_polizza" name="gas_polizza_fake_element">
                        <label class="form-check-label" for="gas_polizza">
                            {{ trans('admin.dati-contratto.columns.gas_polizza') }}
                        </label>
                        <input type="hidden" name="gas_polizza" :value="form.gas_polizza">
                        <div v-if="errors.has('gas_polizza')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_polizza') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-check row"
                     :class="{'has-danger': errors.has('gas_polizza_caldaia'), 'has-success': fields.gas_polizza_caldaia && fields.gas_polizza_caldaia.valid }">
                    <div class="ml-md-auto pl-0" :class="isFormLocalized ? 'col-md-8' : 'col-md-8'">
                        <input class="form-check-input" id="gas_polizza_caldaia" type="checkbox"
                               :disabled="!isEdit"
                               v-model="form.gas_polizza_caldaia"
                               v-validate="''"
                               data-vname="gas_polizza_caldaia" name="gas_polizza_caldaia_fake_element">
                        <label class="form-check-label" for="gas_polizza_caldaia">
                            {{ trans('admin.dati-contratto.columns.gas_polizza_caldaia') }}
                        </label>
                        <input type="hidden" name="gas_polizza_caldaia" :value="form.gas_polizza_caldaia">
                        <div v-if="errors.has('gas_polizza_caldaia')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('gas_polizza_caldaia') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_pdr'), 'has-success': fields.gas_pdr && fields.gas_pdr.valid }">
                    <label for="gas_pdr" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_pdr') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="20"
                               v-model="form.gas_pdr"
                               name="gas_pdr"
                               v-validate="hasGas() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_pdr'), 'form-control-success': fields.gas_pdr && fields.gas_pdr.valid}"
                               id="gas_pdr" name="gas_pdr"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_pdr') }}">
                        <div v-if="errors.has('gas_pdr')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_pdr')
                            }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_consumo'), 'has-success': fields.gas_consumo && fields.gas_consumo.valid }">
                    <label for="gas_consumo" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_consumo') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.gas_consumo" v-validate="''" @input="validate($event)"
                               maxlength="20"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_consumo'), 'form-control-success': fields.gas_consumo && fields.gas_consumo.valid}"
                               id="gas_consumo" name="gas_consumo"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_consumo') }}">
                        <div v-if="errors.has('gas_consumo')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_consumo') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_matricola'), 'has-success': fields.gas_matricola && fields.gas_matricola.valid }">
                    <label for="gas_matricola" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_matricola') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.gas_matricola"
                               maxlength="20"
                               name="gas_matricola"
                               v-validate=""
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_matricola'), 'form-control-success': fields.gas_matricola && fields.gas_matricola.valid}"
                               id="gas_matricola" name="gas_matricola"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_matricola') }}">
                        <div v-if="errors.has('gas_matricola')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_matricola') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">


                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_remi'), 'has-success': fields.gas_remi && fields.gas_remi.valid }">
                    <label for="gas_remi" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_remi') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.gas_remi" v-validate="''" @input="validate($event)"
                               maxlength="20"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_remi'), 'form-control-success': fields.gas_remi && fields.gas_remi.valid}"
                               id="gas_remi" name="gas_remi"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_remi') }}">
                        <div v-if="errors.has('gas_remi')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_remi')
                            }}
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_fornitore'), 'has-success': fields.gas_fornitore && fields.gas_fornitore.valid }">
                    <label for="gas_fornitore" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_fornitore') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.gas_fornitore"
                               maxlength="100"
                               name="gas_fornitore"
                               v-validate="hasGas() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_fornitore'), 'form-control-success': fields.gas_fornitore && fields.gas_fornitore.valid}"
                               id="gas_fornitore" name="gas_fornitore"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_fornitore') }}">
                        <div v-if="errors.has('gas_fornitore')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_fornitore') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('gas_mercato'), 'has-success': fields.gas_mercato && fields.gas_mercato.valid }">
                    <label for="gas_mercato" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.gas_mercato') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.gas_mercato"
                               maxlength="45"
                               name="gas_mercato"
                               v-validate="hasGas() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('gas_mercato'), 'form-control-success': fields.gas_mercato && fields.gas_mercato.valid}"
                               id="gas_mercato" name="gas_mercato"
                               placeholder="{{ trans('admin.dati-contratto.columns.gas_mercato') }}">
                        <div v-if="errors.has('gas_mercato')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('gas_mercato') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<hr v-if="hasTelefonia()"/>
<div v-if="hasTelefonia()" class="card card-accent-primary">

    <header class="card-header">
        <h2 class="text-center">Offerta Telefono</h2>
    </header>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_offerta'), 'has-success': fields.tel_offerta && fields.tel_offerta.valid }">
                    <label for="tel_offerta" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_offerta') }} *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_offerta" v-validate="'required'" @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_offerta'), 'form-control-success': fields.tel_offerta && fields.tel_offerta.valid}"
                               id="tel_offerta" name="tel_offerta"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_offerta') }}">
                        <div v-if="errors.has('tel_offerta')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('tel_offerta') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_gia_cliente'), 'has-success': fields.tel_gia_cliente && fields.tel_gia_cliente.valid }">
                    <label for="tel_gia_cliente" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_gia_cliente') }} *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">


                        <multiselect
                            :disabled="!isEdit"
                            name="tel_gia_cliente"
                            v-model="form.tel_gia_cliente"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'0',label:'NO'},{id:'1',label:'SI'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>

                        <div v-if="errors.has('tel_gia_cliente')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('tel_gia_cliente') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_cod_mig_adsl'), 'has-success': fields.tel_cod_mig_adsl && fields.tel_cod_mig_adsl.valid }">
                    <label for="tel_cod_mig_adsl" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_cod_mig_adsl') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_cod_mig_adsl" v-validate="''" @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_cod_mig_adsl'), 'form-control-success': fields.tel_cod_mig_adsl && fields.tel_cod_mig_adsl.valid}"
                               id="tel_cod_mig_adsl" name="tel_cod_mig_adsl"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_cod_mig_adsl') }}">
                        <div v-if="errors.has('tel_cod_mig_adsl')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tel_cod_mig_adsl') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_cod_mig_voce'), 'has-success': fields.tel_cod_mig_voce && fields.tel_cod_mig_voce.valid }">
                    <label for="tel_cod_mig_voce" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_cod_mig_voce') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_cod_mig_voce" v-validate="''" @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_cod_mig_voce'), 'form-control-success': fields.tel_cod_mig_voce && fields.tel_cod_mig_voce.valid}"
                               id="tel_cod_mig_voce" name="tel_cod_mig_voce"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_cod_mig_voce') }}">
                        <div v-if="errors.has('tel_cod_mig_voce')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tel_cod_mig_voce') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_tipo_passaggio'), 'has-success': fields.tel_tipo_passaggio && fields.tel_tipo_passaggio.valid }">
                    <label for="tel_tipo_passaggio" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_tipo_passaggio') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.tel_tipo_passaggio"
                            name="tel_tipo_passaggio"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'mnp',label:'MNP'},{id:'nuovo_numero',label:'Nuovo Numero'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('tel_tipo_passaggio')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tel_tipo_passaggio') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_cellulare_assoc'), 'has-success': fields.tel_cellulare_assoc && fields.tel_cellulare_assoc.valid }">
                    <label for="tel_cellulare_assoc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_cellulare_assoc') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input
                            type="text"
                            v-model="form.tel_cellulare_assoc"
                            @input="validate($event)"
                            maxlength="20"
                            :disabled="!isEdit"
                            class="form-control"
                            v-validate="isTelefoniaMnp() ? 'required' : ''"
                            :class="{'form-control-danger': errors.has('tel_cellulare_assoc'), 'form-control-success': fields.tel_cellulare_assoc && fields.tel_cellulare_assoc.valid}"
                            id="tel_cellulare_assoc" name="tel_cellulare_assoc"
                            placeholder="{{ trans('admin.dati-contratto.columns.tel_cellulare_assoc') }}">
                        <div v-if="errors.has('tel_cellulare_assoc')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('tel_cellulare_assoc') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_tipo_linea'), 'has-success': fields.tel_tipo_linea && fields.tel_tipo_linea.valid }">
                    <label for="tel_tipo_linea" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_tipo_linea') }} *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">


                        <multiselect
                            :disabled="!isEdit"
                            name="tel_tipo_linea"
                            v-model="form.tel_tipo_linea"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'fisso',label:'Linea Fissa'},{id:'mobile',label:'Mobile'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>

                        <div v-if="errors.has('tel_tipo_linea')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('tel_tipo_linea') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_iccd'), 'has-success': fields.tel_iccd && fields.tel_iccd.valid }">
                    <label for="tel_iccd" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_iccd') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_iccd" v-validate="''" @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_iccd'), 'form-control-success': fields.tel_iccd && fields.tel_iccd.valid}"
                               id="tel_iccd" name="tel_iccd"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_iccd') }}">
                        <div v-if="errors.has('tel_iccd')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tel_iccd') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_fornitore'), 'has-success': fields.tel_fornitore && fields.tel_fornitore.valid }">
                    <label for="tel_fornitore" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_fornitore') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_fornitore" v-validate="''" @input="validate($event)"
                               maxlength="100"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_fornitore'), 'form-control-success': fields.tel_fornitore && fields.tel_fornitore.valid}"
                               id="tel_fornitore" name="tel_fornitore"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_fornitore') }}">
                        <div v-if="errors.has('tel_fornitore')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('tel_fornitore') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_canone'), 'has-success': fields.tel_canone && fields.tel_canone.valid }">
                    <label for="tel_canone" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_canone') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.tel_canone" v-validate="''"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('tel_canone'), 'form-control-success': fields.tel_canone && fields.tel_canone.valid}"
                               id="tel_canone" name="tel_canone"
                               placeholder="{{ trans('admin.dati-contratto.columns.tel_canone') }}">
                        <div v-if="errors.has('tel_canone')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('tel_canone') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_finanziamento'), 'has-success': fields.tel_finanziamento && fields.tel_finanziamento.valid }">
                    <label for="tel_finanziamento" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_finanziamento') }} *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">


                        <multiselect
                            :disabled="!isEdit"
                            name="tel_finanziamento"
                            v-model="form.tel_finanziamento"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'0',label:'NO'},{id:'1',label:'SI'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>

                        <div v-if="errors.has('tel_finanziamento')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('tel_finanziamento') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('tel_sell_smartphone'), 'has-success': fields.tel_sell_smartphone && fields.tel_sell_smartphone.valid }">
                    <label for="tel_sell_smartphone" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.tel_sell_smartphone') }} *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            name="tel_sell_smartphone"
                            v-model="form.tel_sell_smartphone"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'0',label:'NO'},{id:'1',label:'SI'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('tel_sell_smartphone')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('tel_sell_smartphone') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>

</div>

<hr/>

<div class="card card-accent-primary">

    <header class="card-header">
        <h2 class="text-center">Modalit&agrave; Pagamento</h2>
    </header>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('mod_pagamento'), 'has-success': fields.mod_pagamento && fields.mod_pagamento.valid }">
                    <label for="mod_pagamento" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.mod_pagamento') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.mod_pagamento"
                            v-validate="'required'"
                            name="mod_pagamento"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'bollettino',label:'Bollettino'},{id:'sdd',label:'SDD'},{id:'carta_di_credito',label:'Carta Di Credito'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('mod_pagamento')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('mod_pagamento') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('sdd_ente'), 'has-success': fields.sdd_ente && fields.sdd_ente.valid }">
                    <label for="sdd_ente" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.sdd_ente') }}</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.sdd_ente" v-validate="''" @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('sdd_ente'), 'form-control-success': fields.sdd_ente && fields.sdd_ente.valid}"
                               id="sdd_ente" name="sdd_ente"
                               placeholder="{{ trans('admin.dati-contratto.columns.sdd_ente') }}">
                        <div v-if="errors.has('sdd_ente')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('sdd_ente')
                            }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12" v-if="form.mod_pagamento && form.mod_pagamento.id=='sdd'">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('sdd_intestatario'), 'has-success': fields.sdd_intestatario && fields.sdd_intestatario.valid }">
                    <label for="sdd_intestatario" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.sdd_intestatario') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="255"
                               v-model="form.sdd_intestatario"
                               name="sdd_intestatario"
                               v-validate="form.mod_pagamento && form.mod_pagamento.id=='sdd' ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('sdd_intestatario'), 'form-control-success': fields.sdd_intestatario && fields.sdd_intestatario.valid}"
                               id="sdd_intestatario" name="sdd_intestatario"
                               placeholder="{{ trans('admin.dati-contratto.columns.sdd_intestatario') }}">
                        <div v-if="errors.has('sdd_intestatario')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('sdd_intestatario') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12" v-if="form.mod_pagamento && form.mod_pagamento.id=='sdd'">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('sdd_cf'), 'has-success': fields.sdd_cf && fields.sdd_cf.valid }">
                    <label for="sdd_cf" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.sdd_cf') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="20"
                               v-model="form.sdd_cf"
                               name="sdd_cf"
                               v-validate="form.mod_pagamento && form.mod_pagamento.id=='sdd' ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('sdd_cf'), 'form-control-success': fields.sdd_cf && fields.sdd_cf.valid}"
                               id="sdd_cf" name="sdd_cf"
                               placeholder="{{ trans('admin.dati-contratto.columns.sdd_cf') }}">
                        <div v-if="errors.has('sdd_cf')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('sdd_cf') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12" v-if="form.mod_pagamento && form.mod_pagamento.id=='sdd'">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('sdd_iban'), 'has-success': fields.sdd_iban && fields.sdd_iban.valid }">
                    <label for="sdd_iban" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.sdd_iban') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               maxlength="27"
                               v-model="form.sdd_iban"
                               name="sdd_iban"
                               v-validate="form.mod_pagamento && form.mod_pagamento.id=='sdd' ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('sdd_iban'), 'form-control-success': fields.sdd_iban && fields.sdd_iban.valid}"
                               id="sdd_iban" name="sdd_iban"
                               placeholder="{{ trans('admin.dati-contratto.columns.sdd_iban') }}">
                        <div v-if="errors.has('sdd_iban')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('sdd_iban')
                            }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega'), 'has-success': fields.delega && fields.delega.valid }">
                    <label for="delega" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            name="delega"
                            v-model="form.delega"
                            v-validate="'required'"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'0',label:'No'},{id:'1',label:'Si'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('delega')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<div v-if="hasDelega()" class="card card-accent-primary">

    <header class="card-header">
        <h2 class="text-center"> Delegato </h2>
    </header>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_tipo_rapporto'), 'has-success': fields.delega_tipo_rapporto && fields.delega_tipo_rapporto.valid }">
                    <label for="delega_tipo_rapporto" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_tipo_rapporto') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.delega_tipo_rapporto"
                               maxlength="100"
                               name="delega_tipo_rapporto"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_tipo_rapporto'), 'form-control-success': fields.delega_tipo_rapporto && fields.delega_tipo_rapporto.valid}"
                               id="delega_tipo_rapporto" name="delega_tipo_rapporto"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_tipo_rapporto') }}">
                        <div v-if="errors.has('delega_tipo_rapporto')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('delega_tipo_rapporto') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_cf'), 'has-success': fields.delega_cf && fields.delega_cf.valid }">
                    <label for="delega_cf" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_cf') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.delega_cf"
                               maxlength="20"
                               name="delega_cf"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_cf'), 'form-control-success': fields.delega_cf && fields.delega_cf.valid}"
                               id="delega_cf" name="delega_cf"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_cf') }}">
                        <div v-if="errors.has('delega_cf')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_cf') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_nome'), 'has-success': fields.delega_nome && fields.delega_nome.valid }">
                    <label for="delega_nome" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_nome') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.delega_nome"
                               maxlength="100"
                               name="delega_nome"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_nome'), 'form-control-success': fields.delega_nome && fields.delega_nome.valid}"
                               id="delega_nome" name="delega_nome"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_nome') }}">
                        <div v-if="errors.has('delega_nome')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_nome') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_cognome'), 'has-success': fields.delega_cognome && fields.delega_cognome.valid }">
                    <label for="delega_cognome" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_cognome') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.delega_cognome"
                               maxlength="100"
                               name="delega_cognome"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_cognome'), 'form-control-success': fields.delega_cognome && fields.delega_cognome.valid}"
                               id="delega_cognome" name="delega_cognome"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_cognome') }}">
                        <div v-if="errors.has('delega_cognome')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_cognome') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_dob'), 'has-success': fields.delega_dob && fields.delega_dob.valid }">
                    <label for="delega_dob" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.delega_dob"
                    >{{ trans('admin.dati-contratto.columns.delega_dob') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="delega_dob"
                                v-model="form.delega_dob"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data nascita"
                                v-validate="hasDelega() ? 'required' : ''"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.delega_dob=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('delega_dob')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_dob') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_pob'), 'has-success': fields.delega_pob && fields.delega_pob.valid }">
                    <label for="delega_pob" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_pob') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text" v-model="form.delega_pob"
                               maxlength="255"
                               name="delega_pob"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_pob'), 'form-control-success': fields.delega_pob && fields.delega_pob.valid}"
                               id="delega_pob" name="delega_pob"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_pob') }}">
                        <div v-if="errors.has('delega_pob')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_pob') }}
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_tipo_doc'), 'has-success': fields.delega_tipo_doc && fields.delega_tipo_doc.valid }">
                    <label for="delega_tipo_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_tipo_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <multiselect
                            :disabled="!isEdit"
                            v-model="form.delega_tipo_doc"
                            name="delega_tipo_doc"
                            id="delega_tipo_doc"
                            v-validate="hasDelega() ? 'required' : ''"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="[{id:'carta_identita',label:'Carta Identita'},{id:'patente',label:'Patente'},{id:'passaporto',label:'Passaporto'}]"
                            :multiple="false"
                            track-by="id"
                            label="label"
                            open-direction="bottom"
                        ></multiselect>
                        <div v-if="errors.has('delega_tipo_doc')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('delega_tipo_doc') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_ente_doc'), 'has-success': fields.delega_ente_doc && fields.delega_ente_doc.valid }">
                    <label for="delega_ente_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_ente_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               id="delega_ente_doc"
                               name="delega_ente_doc"
                               v-model="form.delega_ente_doc"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               maxlength="255"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_ente_doc'), 'form-control-success': fields.delega_ente_doc && fields.delega_ente_doc.valid}"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_ente_doc') }}">
                        <div v-if="errors.has('delega_ente_doc')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('delega_ente_doc') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_nr_doc'), 'has-success': fields.delega_nr_doc && fields.delega_nr_doc.valid }">
                    <label for="delega_nr_doc" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.delega_nr_doc') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <input type="text"
                               name="delega_nr_doc"
                               v-model="form.delega_nr_doc"
                               v-validate="hasDelega() ? 'required' : ''"
                               @input="validate($event)"
                               maxlength="20"
                               :disabled="!isEdit"
                               class="form-control"
                               :class="{'form-control-danger': errors.has('delega_nr_doc'), 'form-control-success': fields.delega_nr_doc && fields.delega_nr_doc.valid}"
                               id="delega_nr_doc"
                               placeholder="{{ trans('admin.dati-contratto.columns.delega_nr_doc') }}">
                        <div v-if="errors.has('delega_nr_doc')" class="form-control-feedback form-text" v-cloak>
                            @{{
                            errors.first('delega_nr_doc') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_doc_data'), 'has-success': fields.delega_doc_data && fields.delega_doc_data.valid }">
                    <label for="delega_doc_data" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.delega_doc_data"
                    >{{ trans('admin.dati-contratto.columns.delega_doc_data') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="delega_doc_data"
                                v-model="form.delega_doc_data"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data rilascio"
                                v-validate="hasDelega() ? 'required' : ''"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.delega_doc_data=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('delega_doc_data')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('delega_doc_data') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('delega_doc_scadenza'), 'has-success': fields.delega_doc_scadenza && fields.delega_doc_scadenza.valid }">
                    <label for="delega_doc_scadenza" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-4' : 'col-md-4'"
                           :title="form.delega_doc_scadenza"
                    >{{ trans('admin.dati-contratto.columns.delega_doc_scadenza') }}
                        *</label>
                    <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                        <div class="input-group">
                            <datetime
                                :disabled="!isEdit"
                                name="delega_doc_scadenza"
                                v-model="form.delega_doc_scadenza"
                                :config="datePickerConfig"
                                class="flatpickr text-center"
                                placeholder="Seleziona data scadenza"
                                v-validate="hasDelega() ? 'required' : ''"
                            ></datetime>
                            <div class="input-group-append" v-if="isEdit">
                                <button type="button" class="btn btn-sm btn-primary m-0"
                                        @click="form.delega_doc_scadenza=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                            </div>
                        </div>
                        <div v-if="errors.has('delega_doc_scadenza')" class="form-control-feedback form-text"
                             v-cloak>
                            @{{
                            errors.first('delega_doc_scadenza') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>

<hr/>

<div class="card card-accent-primary">

    <header class="card-header">
        <h2 class="text-center">Note</h2>
    </header>

    <div class="card-body">

        <div class="row">
            <div class="col-lg-12">

                <div class="form-group row align-items-center"
                     :class="{'has-danger': errors.has('note_ope'), 'has-success': fields.note_ope && fields.note_ope.valid }">
                    <label for="note_ope" class="col-form-label"
                           :class="isFormLocalized ? 'col-md-2' : 'col-md-2'">{{ trans('admin.dati-contratto.columns.note_ope') }}</label>
                    <div :class="isFormLocalized ? 'col-md-10' : 'col-md-10 col-xl-10'">
                        <div>
            <textarea class="form-control note" v-model="form.note_ope" v-validate="''" id="note_ope"
                      :disabled="!isEdit"
                      name="note_ope"></textarea>
                        </div>
                        <div v-if="errors.has('note_ope')" class="form-control-feedback form-text" v-cloak>@{{
                            errors.first('note_ope')
                            }}
                        </div>
                    </div>
                </div>
            </div>


            @if(!Auth::user()->hasRole("Operatore"))
                <div class="col-lg-12">
                    <div class="form-group row align-items-center"
                         :class="{'has-danger': errors.has('note_sv'), 'has-success': fields.note_sv && fields.note_sv.valid }">
                        <label for="note_sv" class="col-form-label"
                               :class="isFormLocalized ? 'col-md-2' : 'col-md-2'">{{ trans('admin.dati-contratto.columns.note_sv') }}</label>
                        <div :class="isFormLocalized ? 'col-md-10' : 'col-md-10 col-xl-10'">
                            <div>
            <textarea class="form-control note" v-model="form.note_sv" v-validate="''" id="note_sv" :disabled="!isEdit"
                      name="note_sv"></textarea>
                            </div>
                            <div v-if="errors.has('note_sv')" class="form-control-feedback form-text" v-cloak>@{{
                                errors.first('note_sv')
                                }}
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-12">
                    <div class="form-group row align-items-center"
                         :class="{'has-danger': errors.has('note_bo'), 'has-success': fields.note_bo && fields.note_bo.valid }">
                        <label for="note_bo" class="col-form-label"
                               :class="isFormLocalized ? 'col-md-2' : 'col-md-2'">{{ trans('admin.dati-contratto.columns.note_bo') }}</label>
                        <div :class="isFormLocalized ? 'col-md-10' : 'col-md-10 col-xl-10'">
                            <div>
            <textarea class="form-control note" v-model="form.note_bo" v-validate="''" id="note_bo" :disabled="!isEdit"
                      name="note_bo"></textarea>
                            </div>
                            <div v-if="errors.has('note_bo')" class="form-control-feedback form-text" v-cloak>@{{
                                errors.first('note_bo')
                                }}
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @if(Auth::user()->hasRole("BackOffice") || Auth::user()->hasRole("Admin"))
                <div class="col-lg-12">
                    <div class="form-group row align-items-center"
                         :class="{'has-danger': errors.has('note_verifica'), 'has-success': fields.note_verifica && fields.note_verifica.valid }">
                        <label for="note_verifica" class="col-form-label"
                               :class="isFormLocalized ? 'col-md-2' : 'col-md-2'">{{ trans('admin.dati-contratto.columns.note_verifica') }}</label>
                        <div :class="isFormLocalized ? 'col-md-10' : 'col-md-10 col-xl-10'">
                            <div>
            <textarea class="form-control note" v-model="form.note_verifica" v-validate="''" id="note_verifica"
                      disabled="disabled" readonly
                      name="note_verifica"></textarea>
                            </div>
                            <div v-if="errors.has('note_verifica')" class="form-control-feedback form-text" v-cloak>
                                @{{
                                errors.first('note_verifica')
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>

    </div>

</div>

<hr/>

<div class="card card-accent-primary">
    <div class="card-body">
        <div class="form-group row align-items-center"
             :class="{'has-danger': errors.has('id_rec'), 'has-success': fields.id_rec && fields.id_rec.valid }">
            <label for="id_rec" class="col-form-label"
                   :class="isFormLocalized ? 'col-md-4' : 'col-md-4'">{{ trans('admin.dati-contratto.columns.id_rec') }}</label>
            <div :class="isFormLocalized ? 'col-md-8' : 'col-md-8 col-xl-8'">
                <input type="text" v-model="form.id_rec" v-validate="''" @input="validate($event)"
                       maxlength="15"
                       :disabled="!isEdit"
                       class="form-control"
                       :class="{'form-control-danger': errors.has('id_rec'), 'form-control-success': fields.id_rec && fields.id_rec.valid}"
                       id="id_rec" name="id_rec"
                       placeholder="{{ trans('admin.dati-contratto.columns.id_rec') }}">
                <div v-if="errors.has('id_rec')" class="form-control-feedback form-text" v-cloak>@{{
                    errors.first('id_rec') }}
                </div>
            </div>
        </div>
    </div>
</div>

@can("dati-contratto.set-esito")
    <div class="card card-accent-primary" v-if="!isNew">
        <header class="card-header">
            <h2 class="text-center">Esito *</h2>
        </header>
        <div class="card-body">
            <div class="form-group row align-items-center"
                 :class="{'has-danger': errors.has('esito'), 'has-success': fields.esito && fields.esito.valid }">
                <div :class="isFormLocalized ? 'col-md-8 offset-md-2 col-xs-12' : 'col-md-8 offset-md-2 col-xs-12'"
                     class="pr-0 pl-0">
                    <multiselect
                        :disabled="!isEdit"
                        v-model="form.esito"
                        name="esito"
                        v-validate="'required'"
                        placeholder="{{ trans('admin.forms.select_an_option') }}"
                        :options="esitiList"
                        :multiple="false"
                        track-by="id"
                        label="nome"
                        open-direction="bottom"
                    ></multiselect>
                    <div v-if="errors.has('esito')" class="form-control-feedback form-text" v-cloak>@{{
                        errors.first('esito') }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-accent-primary" v-if="!isNew">
        <header class="card-header">
            <h2 class="text-center">Richiamo</h2>
            <h4 v-if="form.recall_at" class="text-center">
                @{{getRecallAt()}}
                <button type="button" class="btn btn-sm btn-primary m-0" v-if="isEdit"
                        @click="clearRecallAt">
                        <i class="now-ui-icons ui-1_simple-remove"></i>
                </button>
            </h4>
        </header>
        <div class="card-body" style="height: 600px"  v-if="isEdit">
            <vue-cal
                ref="vuecal"
                @ready="fetchEvents"
                @view-change="fetchEvents"
                :events="events"

                :time-from="8 * 60"
                :time-to="22.5 * 60"
                :time-step="15"

                :hide-weekdays="[7]"
                :special-hours="specialHours"

                active-view="week"
                :disable-views="['years','year','month','day']"
                :selected-date="form.recall_at || minDate"

                :min-date="minDate"
                locale="it"

                today-button
                @cell-dblclick="isEdit ? createEvent($event) : null"
                @cell-click="isEdit ? createEvent($event) : null"
                :on-event-create="onEventCreate"
                :on-event-dblclick="onEventDblclick"
                :editable-events="{ title: false, drag: false, resize: false, delete: true, create: false }"
                cell-contextmenu
            >

                <template v-slot:time-cell="{ hours, minutes }">
                    <div :class="{ 'vuecal__time-cell-line': true, 'hours': !minutes }">
                        <strong v-if="!minutes" style="font-size: 15px">@{{ hours }}</strong>
                        <span v-else style="font-size: 11px">@{{ minutes }}</span>
                    </div>
                </template>


            </vue-cal>
        </div>
    </div>

    <div class="card card-accent-primary" v-if="!isNew && false">
        <header class="card-header">
            <h2 class="text-center">Richiamo</h2>
        </header>
        <div class="card-body">
            <div class="form-group row align-items-center"
                 :class="{'has-danger': errors.has('recall_at'), 'has-success': fields.recall_at && fields.recall_at.valid }">

                <div :class="isFormLocalized ? 'col-md-6 offset-md-3 col-xs-12' : 'col-md-6 offset-md-3 col-xs-12'"
                     class="pr-0 pl-0 input-group">
                    <datetime
                        v-model="form.recall_at"
                        :config="datetimePickerConfig"
                        class="flatpickr text-center"
                        placeholder="Seleziona data e ora del richiamo"></datetime>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-primary m-0"
                                @click="form.recall_at=''"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                    </div>
                    <div v-if="errors.has('recall_at')" class="form-control-feedback form-text" v-cloak>@{{
                        errors.first('recall_at') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcan


@if(
        ( Auth::user()->can("dati-contratto.upload.attach-on-create") && $isEdit && $isNew) ||
        ( Auth::user()->can("dati-contratto.upload.attach-on-edit") && $isEdit && !$isNew ) ||
        ( Auth::user()->can("dati-contratto.upload.view-on-show") && !$isEdit && !$isNew)
    )
    <div class="card card-accent-primary">
        <header class="card-header">
            <h2 class="text-center">Caricamento Documenti</h2>
        </header>
        <div class="card-body">
            <div class="row no-gutters">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    @include('ui.partials.media-uploader', [
                         'route' => $attachRoute,
                         'mediaCollection' => app(App\Models\DatiContratto::class)->getMediaCollection('doc'),
                         'label' => 'Carica Documenti (pdf, jpeg)',
                         'media'=>$datiContratto->getThumbs200ForCollection('doc'),
                         'clickable'=>$dzClickable,
                         'showRemoveLink'=> $dzShowRemoveLink,
                         'maxNumberOfFiles'=>$dzClickable ? 3 : 0,
                         //'disablePreviews'=>Auth::user()->can(app(App\Models\DatiContratto::class)->getMediaCollection('rec')->getViewPermission())
                   ])
                </div>
            </div>
        </div>
    </div>

    <div class="card card-accent-primary">
        <header class="card-header">
            <h2 class="text-center">Caricamento Registrazioni</h2>
        </header>

        <div class="card-body">
            <div class="row no-gutters">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    @include('ui.partials.media-uploader', [
                          'route' => $attachRoute,
                          'mediaCollection' => app(App\Models\DatiContratto::class)->getMediaCollection('rec'),
                          'label' => 'Carica Registrazione',
                          'media'=>$datiContratto->getThumbs200ForCollection('rec'),
                          'clickable'=>$dzClickable,
                          'showRemoveLink'=> $dzShowRemoveLink,
                          'maxNumberOfFiles'=>$dzClickable ? 3 : 0,
                          //'disablePreviews'=>Auth::user()->can(app(App\Models\DatiContratto::class)->getMediaCollection('rec')->getViewPermission())
                      ])
                </div>
            </div>
        </div>
    </div>

@endif





@if(Auth::user()->hasRole("Admin"))
    <div class="row" v-if="isEdit && form.update_user && form.updated_at">
        <div class="col-12">
            <p class="suggest alert alert-info muted-text font-weight-bold">Ultima Modifica [ (User Id: @{{
                form.update_user.id }}) @{{ form.update_user.full_name }} - @{{ form.updated_at|formatDateTime }} ]</p>
        </div>
    </div>
@endif



