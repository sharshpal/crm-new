@extends('ui.layout.app')

@section('title', trans('admin.dati-contratto.actions.index'))

@section('body')

    <dati-contratto-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('/dati-contratto') }}'"
        :campaigns-input="'{{ json_encode($campaignsList->toArray(), JSON_HEX_APOS) }}'"
        :esiti-input="'{{ json_encode($esitiList, JSON_HEX_APOS) }}'"
        :selectable-esiti-input="'{{ json_encode($selectableEsitiList, JSON_HEX_APOS) }}'"
        :partners-input="'{{ json_encode($partnersList->toArray(), JSON_HEX_APOS) }}'"
        :recall-input="'{{ json_encode($recallCounters, JSON_HEX_APOS) }}'"
        :search-user-route="'{{$searchUserRoute}}'"
        :bulk-edit-esito-route="'{{$bulkEditEsitoRoute}}'"
        inline-template
        v-cloak
    >

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.dati-contratto.actions.index') }}

                        @if(Auth::user()->hasPermissionTo('dati-contratto.create'))
                            <a class="btn btn-primary btn-spinner btn-sm pull-right mb-0"
                               href="{{ url('/dati-contratto/create') }}" role="button"><i
                                    class="fa fa-plus"></i>&nbsp; {{ trans('admin.dati-contratto.actions.create') }}</a>
                        @endif

                        @can("dati-contratto.export")
                            <button type="button"
                                    class="btn btn-primary btn-sm pull-right mb-0 mr-3"
                                    @click="showExportModal()"
                            >
                                <i class="fa fa-file-excel-o"></i>
                                Exporta Excel
                            </button>
                        @endcan

                        @if(Auth::user()->hasPermissionTo('check.invito-fatturazione'))
                            <button type="button"
                                    class="btn btn-primary btn-sm pull-right mb-0 mr-3"
                                    @click="openParserModal()"
                            >
                                <i class="fa fa-credit-card"></i>
                                Verifica Invito Fatturazione
                            </button>
                        @endif

                        <button type="button" class="btn btn-sm pull-right mb-0 mr-3 clean-filter"
                                :class="{'btn-success':useCookieFilters,'btn-primary':!useCookieFilters}"
                                @click="toggleSaveFilters()">Mantieni Filtri: <span class="badge">@{{ useCookieFilters ? ' ON' : 'OFF' }}</span>
                        </button>

                        <button type="button" class="btn btn-sm btn-warning pull-right mb-0 mr-3 clean-filter"
                                @click="clearAllFilters()"><i class="fa fa-times-circle"></i> Pulisci Filtri
                        </button>
                    </div>
                    <div class="card-body pt-0" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div
                                    class="row align-items-center justify-content-md-between filter-row-multiselect mb-3" style="display:inline-flex">
                                    <div class="col col-lg-5 form-group mb-0">
                                        <label>Filtra per testo</label>
                                        <div class="input-group w-100">
                                            <input
                                                maxlength="100"
                                                type="text"
                                                class="form-control"
                                                placeholder="{{ trans('admin.placeholder.search') }}"
                                                v-model="active.search"
                                                ref="textSearchInput"
                                                @keyup.enter="updateListCbk()"/>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary m-0"
                                                        @click="updateListCbk()"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <label>Inserimento - Dal: </label>
                                        <div class="input-group">
                                            <datetime v-model="active.fromDate" ref="fromDateInput"
                                                      :config="fromDatePickerConfig"
                                                      class="text-center flatpickr d-inline-block"
                                                      placeholder="Seleziona data inizio"></datetime>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary m-0"
                                                        @click="clearStartFilter"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <label>Inserimento - Al: </label>
                                        <div class="input-group">
                                            <datetime v-model="active.toDate" ref="toDateInput"
                                                      :config="toDatePickerConfig"
                                                      class="text-center flatpickr d-inline-block"
                                                      placeholder="Seleziona data fine">
                                            </datetime>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary m-0"
                                                        @click="clearEndFilter"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-sm-12 form-group mb-0">
                                        <label>N./Pag.</label>
                                        <select class="form-control w-100 p-small p-0" v-model="pagination.state.per_page">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>

                                @can("dati-contratto.index")
                                    <div
                                        class="row align-items-center justify-content-md-between filter-row-multiselect mb-3">

                                        @if(Auth::user()->hasPermissionTo("admin.admin-user.search"))
                                            <div class="col-lg-4 col-sm-12">
                                                <label>Operatore</label>
                                                <multiselect
                                                    v-model="active.crm_user"
                                                    placeholder="{{ trans('admin.forms.search_a_user') }}"
                                                    :options="userList"
                                                    :multiple="true"
                                                    track-by="id"
                                                    label="full_name"
                                                    open-direction="bottom"
                                                    :show-no-options="false"
                                                    name="crm_user"
                                                    :loading="searchUserIsLoading"
                                                    :preserve-search="false"
                                                    @search-change="asyncUserFind"
                                                    @open="resetUserList"
                                                    @input="updateListCbk"
                                                >
                                                    <template slot="noResult">
                                                        {{ trans('admin.forms.no_result') }}
                                                    </template>
                                                    <template slot="noOptions">
                                                        {{ trans('admin.forms.no_result') }}
                                                    </template>
                                                </multiselect>
                                            </div>
                                        @endif

                                        <div class="col-lg-4 col-sm-12">
                                            <label>Campagna</label>
                                            <multiselect
                                                v-model="active.campagna"
                                                placeholder="{{ trans('admin.forms.select_an_option') }}"
                                                :options="campaignsList"
                                                :multiple="true"
                                                track-by="id"
                                                key="id"
                                                label="nome"
                                                open-direction="bottom"
                                                @close="updateListCbk"
                                                @remove="updateListCbk"
                                            ></multiselect>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label>Partner</label>
                                            <multiselect
                                                v-model="active.partner"
                                                placeholder="{{ trans('admin.forms.select_an_option') }}"
                                                :options="partnersList"
                                                :multiple="true"
                                                track-by="id"
                                                key="id"
                                                label="nome"
                                                open-direction="bottom"
                                                @close="updateListCbk"
                                                @remove="updateListCbk"
                                            ></multiselect>
                                        </div>
                                    </div>
                                @endcan

                                <div class="row align-items-center mt-3 filter-row-multiselect ">
                                    <div class="col col-lg-4">
                                        <label>Tipo Inserimento </label>
                                        <multiselect
                                            v-model="active.tipo_inserimento"
                                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                                            :options="[{id:'lucegas',label:'Energia'},{id:'telefonia',label:'Telefonia'}]"
                                            :multiple="true"
                                            track-by="id"
                                            label="label"
                                            open-direction="bottom"
                                            name="tipo_inserimento"
                                            class="w-100"
                                            @input="updateListCbk"
                                        ></multiselect>
                                    </div>
                                    <div class="col col-lg-4">
                                        <label>Tipo Offerta </label>
                                        <multiselect
                                            v-model="active.tipo_offerta"
                                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                                            :options="[{id:'luce',label:'Luce'},{id:'gas',label:'Gas'},{id:'lucegas',label:'Luce + Gas'},{id:'telefonia',label:'Telefonia'}]"
                                            :multiple="true"
                                            track-by="id"
                                            label="label"
                                            open-direction="bottom"
                                            name="tipo_offerta"
                                            class="w-100"
                                            @input="updateListCbk"
                                        ></multiselect>
                                    </div>
                                    <div class="col col-lg-4">
                                        <label>Tipo Contratto </label>
                                        <multiselect
                                            v-model="active.tipo_contratto"
                                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                                            :options="[{id:'family',label:'Family'},{id:'business',label:'Business'}]"
                                            :multiple="true"
                                            track-by="id"
                                            label="label"
                                            open-direction="bottom"
                                            name="tipo_contratto"
                                            class="w-100"
                                            @input="updateListCbk"
                                        ></multiselect>
                                    </div>
                                </div>

                                @can("dati-contratto.index")
                                    <hr/>
                                    <div class="row align-items-center mt-4 filter-row-multiselect ">
                                        <div class="col-lg-3 col-md-12">
                                            <label>Richiamo - Dal: </label>
                                            <div class="input-group">
                                                <datetime v-model="active.recall_fromDate" ref="recall_fromDateInput"
                                                          :config="recall_fromDatePickerConfig"
                                                          class="text-center flatpickr d-inline-block recall-dt"
                                                          placeholder="Seleziona data inizio"></datetime>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-primary m-0"
                                                            @click="clearRecallStartFilter"><i class="now-ui-icons ui-1_simple-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-12">
                                            <label>Richiamo - Al: </label>
                                            <div class="input-group">
                                                <datetime v-model="active.recall_toDate" ref="recall_toDateInput"
                                                          :config="recall_toDatePickerConfig"
                                                          class="text-center flatpickr d-inline-block recall-dt"
                                                          placeholder="Seleziona data fine">
                                                </datetime>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-primary m-0"
                                                            @click="clearRecallEndFilter"><i class="now-ui-icons ui-1_simple-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12">

                                            <div class="row">
                                                <div class="col-md-12 text-center">

                                                    <button
                                                        v-if="false"
                                                        type="button" class="btn recall"
                                                        :class="{'has-recall':recallCounters.tot_min15>0}"
                                                        @click="setRecallInterval(15)"
                                                    >Entro 15 Min. <span class="badge">@{{getRecallCounterLabel(recallCounters.partial_min15,recallCounters.tot_min15)}}</span>
                                                    </button>


                                                    <button type="button" class="btn recall"
                                                            :class="{'has-recall':recallCounters.tot_min30>0}"
                                                            @click="setRecallInterval(30)"
                                                    >Entro 30 Min. <span class="badge">@{{getRecallCounterLabel(recallCounters.partial_min30,recallCounters.tot_min30)}}</span>
                                                    </button>

                                                    <button type="button" class="btn recall"
                                                            :class="{'has-recall':recallCounters.tot_min60>0}"
                                                            @click="setRecallInterval(60)"
                                                    >Entro 60 min. <span class="badge">@{{getRecallCounterLabel(recallCounters.partial_min60,recallCounters.tot_min60)}}</span>
                                                    </button>

                                                    <button type="button" class="btn recall"
                                                            :class="{'has-recall':recallCounters.tot_today>0}"
                                                            @click="setRecallToday()"
                                                    >Oggi <span class="badge">@{{getRecallCounterLabel(recallCounters.partial_today,recallCounters.tot_today)}}</span>
                                                    </button>


                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12 text-center">

                                                    <button type="button" class="btn recall"
                                                            :class="{'expired':recallCounters.tot_expired_today>0}"
                                                            @click="setRecallExpiredToday()"
                                                    >Scaduti Oggi<span class="badge">@{{getRecallCounterLabel(recallCounters.partial_expired_today,recallCounters.tot_expired_today)}}</span>
                                                    </button>

                                                    <button type="button" class="btn recall"
                                                            :class="{'expired':recallCounters.tot_all_expired>0}"
                                                            @click="setRecallAllExpired()"
                                                    >Scaduti Totali<span class="badge">@{{getRecallCounterLabel(recallCounters.partial_all_expired,recallCounters.tot_all_expired)}}</span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endcan

                                <hr class="mb-3 mt-3"/>

                                @can("dati-contratto.index")
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button
                                                type="button"
                                                v-for="esito in esitiList"
                                                :key="esito.id"
                                                class="btn  m-1 filter"
                                                @click="toggleEsitoFilter(esito.id)"
                                                :disabled="esito.mainTotal == 0"
                                                :class="{'filter-active':isEsitoFilterSelected(esito.id), 'light': esito.partialCount == 0, /*'final-state':esito.is_final == 1*/}"
                                            >
                                                @{{esito.nome}}
                                                <span class="badge">@{{ esito.mainTotal > 0 ? esito.partialCount + " / " + esito.total : 0 }}</span>
                                            </button>
                                        </div>
                                    </div>
                                @endcan

                            </form>

                            <div class="table-responsive">
                                <table class="table-dt table table-hover table-listing mx-3 mt-4 table-sm">
                                    <thead>
                                    <tr>

                                        @can("dati-contratto.bulk-edit-esito")
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox"
                                                       v-model="isClickedAll" v-validate="''" data-vv-name="enabled"
                                                       name="enabled_fake_element"
                                                       @click="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled"></label>
                                            </th>
                                        @endcan


                                        <th is='sortable'
                                            :column="'id'">{{ trans('admin.dati-contratto.columns.id') }}</th>
                                        <th is='sortable'
                                            :column="'created_at'">{{ trans('admin.dati-contratto.columns.created_at') }}</th>

                                        <th is='sortable'
                                            :column="'partner'">{{ trans('admin.dati-contratto.columns.partner') }}</th>
                                        <th is='sortable'
                                            :column="'campagna'">{{ trans('admin.dati-contratto.columns.campagna') }}</th>
                                        <th is='sortable'
                                            :column="'crm_user'">{{ trans('admin.dati-contratto.columns.operatore') }}</th>
                                        <th is='sortable'
                                            :column="'codice_pratica'">{{ trans('admin.dati-contratto.columns.codice_pratica') }}</th>
                                        <th is='sortable'
                                            :column="'nome_intestatario'">{{ trans('admin.dati-contratto.columns.nome_intestatario') }}</th>
                                        <th is='sortable'
                                            :column="'owner_cf'">{{ trans('admin.dati-contratto.columns.owner_cf') }}</th>
                                        <th
                                            :column="'contatti'">{{ trans('admin.dati-contratto.columns.contatti') }}</th>

                                        <th is='sortable' class="text-center"
                                            :column="'tipo_offerta'">{{ trans('admin.dati-contratto.columns.tipo_offerta') }}</th>

                                        <th :column="'id_linea'">{{ trans('admin.dati-contratto.columns.id_linea') }}</th>

                                        <th is='sortable'
                                            :column="'tipo_contratto'">{{ trans('admin.dati-contratto.columns.tipo_contratto') }}</th>
                                        <th is='sortable'
                                            :column="'mod_pagamento'">{{ trans('admin.dati-contratto.columns.mod_pagamento') }}</th>
                                        <th is='sortable'
                                            :column="'esito'">{{ trans('admin.dati-contratto.columns.esito') }}</th>
                                        <th is='sortable'
                                            :column="'recall_at'">{{ trans('admin.dati-contratto.columns.recall_at') }}</th>
                                        <th>{{ trans('admin.btn.show-notes') }}</th>
                                        <th></th>
                                    </tr>


                                    @can("dati-contratto.bulk-edit-esito")
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-left pt-3 pb-3" colspan="18">
                                            <span class="align-middle font-weight-bold text-dark">

                                                <span class="btn btn-success btn-sm text-white">{{ trans('admin.listing.selected_items') }}  [ @{{ clickedBulkItemsCount }} ]</span>

                                                <span class="text-primary ml-2 mr-2">|</span>

                                                <a href="#" class="btn btn-primary btn-sm"
                                                   @click="onBulkItemsClickedAll('/dati-contratto')"
                                                   v-if="(clickedBulkItemsCount < pagination.state.total)">
                                                    <i class="fa"
                                                       :class="bulkCheckingAllLoader ? 'fa-spinner' : ''">
                                                    </i>
                                                    {{ trans('admin.listing.check_all_items') }} [ @{{ pagination.state.total }} ]
                                                </a>

                                                <span class="text-primary ml-2 mr-2">|</span>

                                                <a href="#" class="btn btn-primary btn-sm"
                                                   @click="onBulkItemsClickedAllUncheck()">
                                                    {{ trans('admin.listing.uncheck_all_items') }}
                                                </a>
                                            </span>
                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-warning pr-3 pl-3"
                                                            @click="openBulkEsitoModal">
                                                        Assegna Esito
                                                    </button>
                                                </span>

                                                @if(false)
                                                    <span class="pull-right pr-2">
                                                        <button class="btn btn-sm btn-danger pr-3 pl-3"
                                                                @click="bulkDelete('/dati-contratto/bulk-destroy')">
                                                            {{ trans('admin.btn.delete') }}
                                                        </button>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endcan


                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id"
                                        :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        @can("dati-contratto.bulk-edit-esito")
                                            <td class="bulk-checkbox">
                                                <input class="form-check-input" :id="'enabled' + item.id"
                                                       type="checkbox"
                                                       v-model="bulkItems[item.id]" v-validate="''"
                                                       :data-vv-name="'enabled' + item.id"
                                                       :name="'enabled' + item.id + '_fake_element'"
                                                       @click="onBulkItemClicked(item.id)"
                                                       :disabled="bulkCheckingAllLoader">
                                                <label class="form-check-label" :for="'enabled' + item.id">
                                                </label>
                                            </td>
                                        @endcan


                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.created_at | formatDateTime}}</td>

                                        <td><img :src="item.partner.logo_thumb_url"  v-if="item.partner?.logo_thumb_url" class="logo-img mr-2 border" />  <div>@{{ item.partner?.nome }}  </div> </td>
                                        <td><img :src="item.campagna.logo_thumb_url" v-if="item.campagna?.logo_thumb_url" class="logo-img mr-2 border" />  <div>@{{ item.campagna?.nome }} </div> </td>
                                        <td><img :src="item.crm_user.avatar_thumb_url"  v-if="item.crm_user?.avatar_thumb_url" class="logo-img mr-2 border" /> <div>@{{ item.crm_user?.full_name }} </div> </td>

                                        <td>@{{ item.codice_pratica }}</td>
                                        <td>@{{ item.nome_intestatario }}</td>
                                        <td>@{{ item.owner_cf }}</td>
                                        <td>
                                            <div v-if="item.telefono" class="badge-light" >@{{ item.telefono?.replace(/ /g,'') }}</div>
                                            <div v-if="item.cellulare"class="badge-light" >@{{ item.cellulare?.replace(/ /g,'') }}</div>
                                        </td>

                                        <td class="tipo-offerta">
                                            <i v-if="hasTelefonia(index)" class="icon-phone text-pink"></i>
                                            <i v-if="hasLuce(index)" class="icon-bulb text-warning"></i>
                                            <i v-if="hasGas(index)" class="icon-fire text-primary"></i>
                                            <div class="badge-light">@{{ item.tipo_offerta }}</div>
                                        </td>

                                        <td>
                                            <div v-if="hasLuce(index)">
                                                <span class="font-weight-bold">POD</span>
                                                <span class="badge-light" >@{{ item.luce_pod }}</span>
                                            </div>
                                            <div v-if="hasGas(index)">
                                                <span class="font-weight-bold">PDR</span>
                                                <span class="badge-light" >@{{ item.gas_pdr }}</span>
                                            </div>
                                        </td>

                                        <td class="tipo-contratto">
                                            <i v-if="item.tipo_contratto=='family'" class="icon-home"></i>
                                            <i v-if="item.tipo_contratto=='business'" class="fa fa-building-o"></i>
                                            <div class="badge-light">@{{ item.tipo_contratto }}</div>
                                        </td>
                                        <td class="mod_pagamento">
                                            <i v-if="item.mod_pagamento=='bollettino'" class="fa fa-barcode"></i>
                                            <i v-if="item.mod_pagamento=='sdd'" class="fa fa-bank"></i>
                                            <i v-if="item.mod_pagamento=='carta_di_credito'" class="fa fa-credit-card"></i>
                                            <div class="badge-light">@{{ item.mod_pagamento.replace(/_/g," ")}}</div>
                                        </td>
                                        <td>
                                            <span class="esito-label"
                                                  :class="{ 'text-success font-weight-bold':isEsitoPositivo(item),
                                                            'text-danger font-weight-bold':isEsitoNegativo(item),
                                                            'text-warning font-weight-bold':isEsitoRecover(item)
                                                            }"
                                            >@{{ item.esito.nome }}
                                            </span>
                                            @can("dati-contratto.set-esito")
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-link"
                                                            @click="openEsitoModal(item)">{{ trans('admin.btn.edit') }}</button>
                                                </div>
                                            @endcan
                                        </td>

                                        <td>@{{ item.recall_at | formatDateTime}}</td>

                                        <td>
                                            <button
                                                v-if="itemHasNotes(item)"
                                                type="button"
                                                class="btn btn-sm btn-warning m-0"
                                                title="{{ trans('admin.btn.show-notes') }}"
                                                @click="openNoteModal(item)"
                                            >
                                                {{ trans('admin.btn.show-notes') }}
                                            </button>
                                        </td>

                                        <td>
                                            <div>
                                                @if(Auth::user()->hasPermissionTo("dati-contratto.show"))
                                                    <a class="btn btn-sm btn-info"
                                                       :href="item.resource_url + '/show'"
                                                       title="{{ trans('admin.btn.show') }}"
                                                       role="button"><i class="fa fa-eye"></i></a>
                                                @endif

                                                @if(Auth::user()->hasPermissionTo("dati-contratto.set-recovered"))
                                                    <button
                                                        v-if="isEsitoNegativo(item)"
                                                        type="button" class="btn btn-sm btn-warning"
                                                        @click="openRecoverContrattoModal(item)"
                                                        title="{{ trans('admin.btn.recover') }}"
                                                        role="button"><i class="fa fa-refresh"></i></button>
                                                @endif

                                                @if(Auth::user()->hasPermissionTo("dati-contratto.edit"))
                                                    <a v-if="!item.esito.is_final"
                                                       class="btn btn-sm btn-spinner btn-info"
                                                       :href="item.resource_url + '/edit'"
                                                       title="{{ trans('admin.btn.edit') }}"
                                                       role="button"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if(Auth::user()->hasPermissionTo("dati-contratto.edit-when-closed"))
                                                    <a v-if="item.esito.is_final"
                                                       class="btn btn-sm btn-spinner btn-info"
                                                       :href="item.resource_url + '/edit'"
                                                       title="{{ trans('admin.btn.edit') }}"
                                                       role="button"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if(Auth::user()->hasPermissionTo("dati-contratto.delete"))
                                                    <form class=""
                                                          @submit.prevent="deleteItem(item.resource_url)"
                                                          v-if="!item.esito.is_final">
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                title="{{ trans('admin.btn.delete') }}"><i
                                                                class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span
                                        class="pagination-caption">{{ trans('admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin.index.no_items') }}</h3>
                                <p>{{ trans('admin.index.try_changing_items') }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @can('dati-contratto.export')
                <export-excel-modal
                    :export-url="'{{ url($exportUrl) }}'"
                    :exportable-columns="'{{ json_encode($exportableColumns, JSON_HEX_APOS) }}'"
                    :export-label="'{{trans("admin.btn.export")}}'"
                    :get-filters-fn="getFiltersOut"
                >
                </export-excel-modal>
            @endcan


            @can('check.invito-fatturazione')
                <file-parser-modal
                    :send-data-url="'{{url("/check-fatturazione")}}'"
                    :send-callback-fn="clearAllFilters"
                ></file-parser-modal>
            @endcan


            <modal name="note-modal" id="note-modal"
                   class="modal--translation" width="50%" height="auto" :scrollable="true"
                   :adaptive="true" :pivot-y="0.25"
                   v-cloak
            >
                <h4 class="modal-title mb-2">Note Contratto ID: @{{currentNoteItem?.id}}</h4>

                <div class="row" v-if="currentNoteItem?.note_ope">
                    <div class="col-lg-12">
                        <h5>{{trans("admin.dati-contratto.columns.note_ope")}}</h5>
                        <textarea readonly="readonly" disabled="disabled"
                                  class="w-100 note">@{{currentNoteItem?.note_ope}}</textarea>
                    </div>
                </div>

                <hr v-if="currentNoteItem?.note_sv"/>
                <div class="row" v-if="currentNoteItem?.note_sv">
                    <div class="col-lg-12">
                        <h5>{{trans("admin.dati-contratto.columns.note_sv")}}</h5>
                        <textarea readonly="readonly" disabled="disabled"
                                  class="w-100 note">@{{currentNoteItem?.note_sv}}</textarea>
                    </div>
                </div>

                <hr v-if="currentNoteItem?.note_bo"/>
                <div class="row" v-if="currentNoteItem?.note_bo">
                    <div class="col-lg-12">
                        <h5>{{trans("admin.dati-contratto.columns.note_bo")}}</h5>
                        <textarea
                                  @if(!Auth()->user()->can("dati-contratto.set-note"))
                                    readonly="readonly" disabled="disabled"
                                  @endif
                                  v-model="selectedNote_NoteBo"
                                  class="w-100 note">@{{selectedNote_NoteBo}}
                        </textarea>
                    </div>
                </div>

                <hr v-if="currentNoteItem?.note_verifica"/>
                <div class="row" v-if="currentNoteItem?.note_verifica">
                    <div class="col-lg-12">
                        <h5>{{trans("admin.dati-contratto.columns.note_sv")}}</h5>
                        <textarea readonly="readonly" disabled="disabled" class="w-100 note">@{{currentNoteItem?.note_verifica}}</textarea>
                    </div>
                </div>

                @can("dati-contratto.set-note")
                    <hr/>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="button" class="btn btn-success" @click="saveNoteContract">Salva</button>
                        </div>
                    </div>
                @endcan
            </modal>


            <modal name="edit-esito-modal" id="edit-esito-modal"
                   class="modal--translation" width="50%" height="auto" :scrollable="true"
                   :adaptive="true" :pivot-y="0.25"
                   v-cloak
            >
                <h4 class="modal-title mb-2 mt-3">Modifica Esito <span v-if="currentEsitoItem">- Contratto ID: @{{currentEsitoItem?.id}}</span>
                </h4>
                <div class="row mt-5">
                    <div class="col-lg-6 offset-lg-3 col-sm-12">
                        <multiselect
                            v-model="selectedNewEsito"
                            name="new_esito"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="selectableEsitiList"
                            :multiple="false"
                            track-by="id"
                            label="nome"
                            open-direction="bottom"
                            :max-height="170"
                            :allow-empty="false"
                        ></multiselect>
                    </div>
                </div>

                <hr class="mt-5 mb-5"/>

                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-lg btn-primary"
                                @click="saveNewEsito">{{ trans('admin.btn.save') }}</button>
                    </div>
                </div>

            </modal>


            <modal name="bulk-edit-esito-modal" id="bulk-edit-esito-modal"
                   class="modal--translation" width="50%" height="auto" :scrollable="true"
                   :adaptive="true" :pivot-y="0.25"
                   v-cloak
            >
                <h4 class="modal-title mb-2 mt-3">Modifica Esito</h4>
                <div class="row mt-5">
                    <div class="col-lg-6 offset-lg-3 col-sm-12">
                        <multiselect
                            v-model="selectedNewBulkEsito"
                            name="new_bulk_esito"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="selectableEsitiList"
                            :multiple="false"
                            track-by="id"
                            label="nome"
                            open-direction="bottom"
                            :max-height="170"
                            :allow-empty="false"
                        ></multiselect>
                    </div>
                </div>

                <hr class="mt-5 mb-5"/>

                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-lg btn-primary"
                                :disabled="selectableEsitiList.length==0||selectedNewBulkEsito==null||selectedNewBulkEsito=={}"
                                @click="bulkEditEsito">{{ trans('admin.btn.save') }}</button>
                    </div>
                </div>

            </modal>


            <modal name="recover-contract-modal" id="recover-contract-modal"
                   class="modal--translation" width="50%" height="auto" :scrollable="true"
                   :adaptive="true" :pivot-y="0.25"
                   v-cloak
            >
                <h4 class="modal-title mb-2 mt-3">Recupera Contratto ID: @{{currentRecoverItem?.id}}</h4>
                @can("dati-contratto.recover.set-recall")
                <div class="row mt-5">
                    <h5 class="w-100 text-center">Richiamo</h5>
                    <div
                        class="col-md-6 offset-md-3 col-xs-12 pr-0 pl-0 input-group">
                        <datetime
                            v-model="selectedRecovery_RecallAt"
                            :config="datetimePickerConfig"
                            class="flatpickr text-center"
                            placeholder="Seleziona data e ora del richiamo"></datetime>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-primary"
                                    @click="selectedRecovery_RecallAt=null"><i class="icon-close"></i></button>
                        </div>
                    </div>
                </div>
                @endcan

                <hr class="mt-4 mb-4"/>

                <div class="row mt-3">
                    <h5 class="w-100 text-center">Note</h5>
                    <div
                        class="col-md-8 offset-md-2 col-xs-12 pr-0 pl-0 input-group">
                        <textarea
                            class="form-control note"
                            v-model="selectedRecovery_Note"
                            id="selectedRecovery_Note"
                            name="selectedRecovery_Note">
                        </textarea>
                    </div>
                </div>

                <hr class="mt-3 mb-3"/>

                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-lg btn-primary"
                                @click="saveRecoveryContract">{{ trans('admin.btn.recover') }}</button>
                    </div>
                </div>

            </modal>

        </div>
    </dati-contratto-listing>

@endsection
