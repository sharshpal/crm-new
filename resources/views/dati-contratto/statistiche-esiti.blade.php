@extends('ui.layout.app')

@section('title', trans('admin.statistiche-esiti.actions.index'))

@section('body')

    <statistiche-esiti
        :data="{{ json_encode($data, JSON_HEX_APOS) }}"
        :url="'{{ url('/dati-contratto/statistiche-esiti') }}'"
        :campaigns-input="'{{ json_encode($campaignsList->toArray(), JSON_HEX_APOS) }}'"
        :partners-input="'{{ json_encode($partnersList->toArray(), JSON_HEX_APOS) }}'"
        :esiti-input="'{{ json_encode($esitiList->toArray(), JSON_HEX_APOS) }}'"
        :search-user-route="'{{$searchUserRoute}}'"
        :export-url="'{{$exportUrl}}'"
        inline-template
        v-cloak
    >

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <i class="fa fa-align-justify"></i> {{ trans('admin.statistiche-esiti.actions.index') }}
                            </div>



                            <div class="col text-right" >
                                <button type="button" class="btn btn-warning mb-0 mr-3 clean-filter"
                                        @click="clearAllFilters()"><i class="fa fa-times-circle"></i> Pulisci Filtri
                                </button>

                                <button type="button" @click="setToday" class="btn btn-primary mr-2">Oggi</button>
                                <button type="button" @click="setWeek" class="btn btn-primary mr-2">Questa Settimana</button>
                                <button type="button" @click="setMonth" class="btn btn-primary mr-2">Questo Mese</button>
                                <button type="button" @click="setYear" class="btn btn-primary mr-2">Questo Anno</button>

                                @can("dati-contratto.statistiche-esiti.export")
                                    <button type="button"
                                            class="btn btn-primary  mb-0 mr-3"
                                            @click="exportData"
                                    >
                                        <i class="fa fa-file-excel-o"></i>
                                        Exporta Excel
                                    </button>
                                @endcan
                            </div>
                        </div>


                    </div>
                    <div class="card-body pt-0" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div
                                    class="row align-items-center justify-content-md-between filter-row-multiselect mb-3">
                                    <div class="col col-lg-4 form-group mb-0">
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
                                                <button type="button" class="btn btn-primary"
                                                        @click="updateListCbk()"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <label>Inserimento - Dal: </label>
                                        <div class="input-group">
                                            <datetime v-model="active.fromDate" ref="fromDateInput"
                                                      :config="fromDatePickerConfig"
                                                      class="text-center flatpickr d-inline-block"
                                                      placeholder="Seleziona data inizio"></datetime>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        @click="clearStartFilter"><i class="icon-close"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <label>Inserimento - Al: </label>
                                        <div class="input-group">
                                            <datetime v-model="active.toDate" ref="toDateInput"
                                                      :config="toDatePickerConfig"
                                                      class="text-center flatpickr d-inline-block"
                                                      placeholder="Seleziona data fine">
                                            </datetime>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        @click="clearEndFilter"><i class="icon-close"></i></button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                @can("dati-contratto.index")
                                    <div
                                        class="row align-items-center justify-content-md-between filter-row-multiselect mb-3">

                                        <div class="col-lg-3 col-sm-12">
                                            <label>Partner</label>
                                            <button type="button" class="btn btn-sm btn-info text-white pull-right"
                                                    :class="{'btn-success':collection.groupByPartner}"
                                                    @click="toggleGroupByPartner">
                                                @{{ collection.groupByPartner ? 'Dati Estesi' : 'Dati Aggregati' }}
                                            </button>
                                            <multiselect
                                                v-model="active.partner"
                                                placeholder="{{ trans('admin.forms.select_an_option') }}"
                                                :options="partnersList"
                                                :multiple="true"
                                                track-by="id"
                                                key="id"
                                                label="nome"
                                                open-direction="bottom"
                                                name="partner"
                                                @input="updateListCbk"
                                            ></multiselect>
                                        </div>


                                        <div class="col-lg-3 col-sm-12">
                                            <label>Campagna</label>
                                            <button type="button" class="btn btn-sm btn-info text-white pull-right"
                                                    :class="{'btn-success':collection.groupByCampagna}"
                                                    @click="toggleGroupByCampagna">
                                                @{{ collection.groupByCampagna ? 'Dati Estesi' : 'Dati Aggregati' }}
                                            </button>
                                            <multiselect
                                                v-model="active.campagna"
                                                placeholder="{{ trans('admin.forms.select_an_option') }}"
                                                :options="campaignsList"
                                                :multiple="true"
                                                track-by="id"
                                                key="id"
                                                label="nome"
                                                name="campagna"
                                                open-direction="bottom"
                                                @input="updateListCbk"
                                            ></multiselect>
                                        </div>


                                        @if(Auth::user()->hasPermissionTo("admin.admin-user.search"))
                                            <div class="col-lg-3 col-sm-12">
                                                <label>Operatore</label>
                                                <button type="button" class="btn btn-sm btn-info text-white pull-right"
                                                        :class="{'btn-success':collection.groupByUser}"
                                                        @click="toggleGroupByUser">
                                                    @{{ collection.groupByUser ? 'Dati Estesi' : 'Dati Aggregati' }}
                                                </button>
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

                                        <div class="col-lg-3 col-sm-12 text-left">

                                            <label>Esito</label>
                                            <button type="button" class="btn btn-sm btn-info text-white pull-right"
                                                    :class="{'btn-success':collection.groupByLabel}"
                                                    @click="toggleGroupByLabel">
                                                @{{ collection.groupByLabel ? 'Dati Estesi' : 'Dati Aggregati' }}
                                            </button>
                                            <multiselect
                                                v-model="active.esito"
                                                placeholder="{{ trans('admin.forms.select_an_option') }}"
                                                :options="esitiList"
                                                :multiple="true"
                                                track-by="id"
                                                key="id"
                                                label="nome"
                                                open-direction="bottom"
                                                name="partner"
                                                @input="updateListCbk"
                                            ></multiselect>
                                        </div>

                                    </div>
                                @endcan

                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover table-listing table-last-normal mt-4 table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center col-auto"
                                                :column="'partner'">{{ trans('admin.statistiche-esiti.columns.partner') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'campagna'">{{ trans('admin.statistiche-esiti.columns.campagna') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'crm_user'">{{ trans('admin.statistiche-esiti.columns.crm_user') }}</th>


                                            <th class="text-center col-auto"
                                                :column="'esito'">{{ trans('admin.statistiche-esiti.columns.esito') }}</th>


                                            <th class="text-center col-auto"
                                                :column="'stato'">{{ trans('admin.statistiche-esiti.columns.stato') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'partial_total'">{{ trans('admin.statistiche-esiti.columns.partial_total') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'totale_globale'">{{ trans('admin.statistiche-esiti.columns.totale_globale') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'partial_total'">{{ trans('admin.statistiche-esiti.columns.partial_total_pz') }}</th>

                                            <th class="text-center col-auto"
                                                :column="'totale_globale'">{{ trans('admin.statistiche-esiti.columns.totale_pezzi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in collection.esiti" :key="item.id+'_'+item.partialCount+'_'+index"
                                            :class="{'bg-bulk' : bulkItems[item.id] }">

                                            <td class="text-center col-auto"
                                                :class="{'st-elem-separator':!isSameGroup(index)}"
                                            >@{{ collection.groupByPartner ? item.partner : '-' }}</td>

                                            <td class="text-center col-auto" :class="{'st-elem-separator':!isSameGroup(index)}">@{{ collection.groupByCampagna ? item.campagna : '-' }}</td>

                                            <td class="col-auto text-center" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                @{{ collection.groupByUser ? item.first_name + ' ' + item.last_name : '-' }}
                                            </td>

                                            <td class="col-auto text-center" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                @{{ collection.groupByLabel ? item.nome : '-' }}
                                            </td>

                                            <td class="col-auto text-center" :class="{'st-elem-separator':!isSameGroup(index)}">



                                                <span v-if="item.label.startsWith('FINAL')" class="badge badge-secondary text-white p-1">
                                                    CONCLUSO
                                                </span>
                                                <span v-if="!item.label.startsWith('FINAL')" class="text-info p-1">
                                                    APERTO
                                                </span>


                                                <span v-if="item.label.endsWith('_NEW')" class="badge badge-info text-white p-1">
                                                   <i class="fa fa-check text-white"></i> Nuovo Inserimento
                                                </span>

                                                <span v-if="item.label.endsWith('_OK')" class="text-success p-1 font-weight-bold">
                                                    <i class="icon-trophy text-success"
                                                    ></i> POSITIVO
                                                </span>

                                                <span v-if="item.label.endsWith('_KO')" class="text-danger p-1 font-weight-bold">
                                                    <i class="fa fa-exclamation-triangle text-danger"
                                                    ></i> NEGATIVO
                                                </span>

                                                <span v-if="item.label=='RECOVER'" class="badge badge-warning text-white p-1">
                                                    <i class="fa fa-check text-white"></i> RECUPERATO
                                                </span>
                                            </td>

                                            <td class="col-auto text-center pr-3" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                <span class="badge badge-info text-white border mb-1 font-weight-bold">@{{ item.partialCount}} /  @{{ getGroupTotalSchede(item)}}</span>
                                                <div class="progress border">
                                                    <div class="progress-bar"
                                                         :class="{'bg-success':item.is_ok && item.is_final, 'bg-danger':!item.is_ok && item.is_final, 'bg-info':!item.is_final}"
                                                         role="progressbar" :style="{width: getGroupTotalSchedePercent(item)+'%'}" :aria-valuenow="getGroupTotalSchedePercent(item)" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="text-dark font-weight-bold d-inline" :style="{background:'#ffffff45'}">@{{getGroupTotalSchedePercent(item)}} %</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="col-auto text-center" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                <span class="badge badge-dark border mb-1 font-weight-bold">@{{ item.partialCount}} /  @{{ collection.total}}</span>

                                                <div class="progress border">
                                                    <div class="progress-bar"
                                                         :class="{'bg-success':item.is_ok && item.is_final, 'bg-danger':!item.is_ok && item.is_final, 'bg-info':!item.is_final}"
                                                         role="progressbar" :style="{width: getSchedePercent(item)+'%'}" :aria-valuenow="getSchedePercent(item)" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="text-dark font-weight-bold d-inline" :style="{background:'#ffffff45'}">@{{getSchedePercent(item)}} %</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="col-auto text-center pr-3" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                <span class="badge badge-info text-white border mb-1 font-weight-bold">@{{ item.partialCountPz}} /  @{{ getGroupTotalPz(item)}}</span>
                                                <div class="progress border">
                                                    <div class="progress-bar"
                                                         :class="{'bg-success':item.is_ok && item.is_final, 'bg-danger':!item.is_ok && item.is_final, 'bg-info':!item.is_final}"
                                                         role="progressbar" :style="{width: getGroupTotalPzPercent(item)+'%'}" :aria-valuenow="getGroupTotalPzPercent(item)" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="text-dark font-weight-bold d-inline" :style="{background:'#ffffff45'}">@{{getGroupTotalPzPercent(item)}} %</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="col-auto text-center" :class="{'st-elem-separator':!isSameGroup(index)}">
                                                <span class="badge badge-dark border mb-1 font-weight-bold">@{{ item.partialCountPz}} /  @{{ collection.totalPz}}</span>

                                                    <div class="progress border">
                                                      <div class="progress-bar"
                                                           :class="{'bg-success':item.is_ok && item.is_final, 'bg-danger':!item.is_ok && item.is_final, 'bg-info':!item.is_final}"
                                                           role="progressbar" :style="{width: getPezziPercent(item)+'%'}" :aria-valuenow="getPezziPercent(item)" aria-valuemin="0" aria-valuemax="100">
                                                          <span class="text-dark font-weight-bold d-inline" :style="{background:'#ffffff45'}">@{{getPezziPercent(item)}} %</span>
                                                      </div>
                                                    </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>



                            <div class="no-items-found" v-if="!collection.esiti.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin.index.no_items') }}</h3>
                                <p>{{ trans('admin.index.try_changing_items') }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </statistiche-esiti>

@endsection
