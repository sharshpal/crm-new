@extends('ui.layout.app')

@section('title', trans('admin.user-performance.title'))

@section('body')

    <user-performance-stat
        :data="{{ json_encode($data, JSON_HEX_APOS) }}"
        :url="'{{ url('user-performance') }}'"
        :export-url="'{{$exportUrl}}'"
        :partners-input="'{{ json_encode($partnersList->toArray(), JSON_HEX_APOS) }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row pl-3">
                            <div class="col d-flex align-items-center">
                                <i class="fa fa-align-justify"></i>&nbsp; {{ trans('admin.user-performance.title') }}
                            </div>

                            <div class="col-auto">
                                <button type="button" @click="setToday" class="btn btn-primary ml-3">Oggi</button>
                                <button type="button" @click="setWeek" class="btn btn-primary ml-3">Questa Settimana</button>
                                <button type="button" @click="setMonth" class="btn btn-primary ml-3">Questo Mese</button>
                                <button type="button" @click="setYear" class="btn btn-primary ml-3">Questo Anno</button>
                            </div>

                            <div class="col-auto border-left">
                                <button type="button"
                                        class="btn btn-primary"
                                        @click="exportData"
                                        :disabled="this.$parent.loading"
                                >
                                    <i class="fa fa-file-excel-o"></i>
                                    Exporta Excel
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col-lg-2 col-md-12 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">Dal: </div>
                                            <div class="input-group col-9">
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
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label">Al: </div>
                                            <div class="input-group col-9">
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
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-3 col-form-label text-right">Partner</div>
                                            <div class="input-group col-9">
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
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="75">75</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>

                                </div>
                            </form>

                            <div class="table-responsive">
                            <table class="table table-hover table-listing table-last-normal up-table">
                                <thead>
                                    <tr>

                                        <th is='sortable' :column="'partner'" class="text-center border border-dark align-middle"  rowspan="2">{{ trans('admin.user-performance.columns.partner') }}</th>
                                        <th is='sortable' :column="'full_name'" class="text-center border border-dark align-middle"  rowspan="2" colspan="2">{{ trans('admin.user-performance.columns.user') }}</th>
                                        <th is='sortable' :column="'ore'" class="text-center border border-dark align-middle" rowspan="2">{{ trans('admin.user-performance.columns.ore') }}</th>
                                        <th is='sortable' :column="'pezzi_singoli'" class="text-center border border-dark" scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_singoli') }}</th>
                                        <th is='sortable' :column="'pezzi_dual'" class="text-center border border-dark"  scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_dual') }}</th>
                                        <th is='sortable' :column="'pezzi_energia'" class="text-center border border-dark"  scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_energia') }}</th>
                                        <th is='sortable' :column="'pezzi_fisso'" class="text-center border border-dark"  scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_fisso') }}</th>
                                        <th is='sortable' :column="'pezzi_mobile'" class="text-center border border-dark"  scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_mobile') }}</th>
                                        <th is='sortable' :column="'pezzi_telefonia'" class="text-center border border-dark" scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_telefonia') }}</th>
                                        <th is='sortable' :column="'pezzi_tot'" class="text-center border border-dark" scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.pezzi_tot') }}</th>
                                        <th is='sortable' :column="'resa'" class="text-center border border-dark" scope="colgroup" colspan="2">{{ trans('admin.user-performance.columns.resa') }}</th>

                                    </tr>

                                    <tr>
                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="border border-dark text-center">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="text-center border-dark border">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>

                                        <th scope="col" class="border border-dark text-center">Lordo</th>
                                        <th scope="col" class="border border-dark text-center">Netto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        <td class="text-left pl-2 border-left border border-dark">
                                            <img :src="item.partner.logo_thumb_url"  v-if="item.partner && item.partner.logo_thumb_url" class="logo-img mr-2"/>
                                            <span class="font-weight-bold">@{{ item.partner.nome }}</span>
                                            <div v-if="item.partners && item.partners.length>1"> + altri @{{ item.partners.length-1 }} partner</div>
                                        </td>

                                        <td class="text-center border border-dark border-right-0">
                                            <img :src="item.avatar_thumb_url"  v-if="item.avatar_thumb_url" class="logo-img mr-2"/>
                                        </td>

                                        <td class="border border-dark border-left-0">
                                            <div><span class="font-weight-bold">@{{ item.full_name }}</span></div>
                                            <div>ID: @{{ item.id }} - @{{ item.email }}</div>
                                        </td>

                                        <td class="text-center font-weight-bold text-green border border-dark">@{{ item.ore_rounded}}</td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_singoli_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_singoli }}</span> </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_dual_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_dual }}</span> </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_energia_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_energia }}</span>  </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_fisso_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_fisso }}</span></td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_mobile_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_mobile }} </span> </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_telefonia_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_telefonia }} </span> </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.pezzi_tot_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.pezzi_tot }} </span> </td>

                                        <td class="text-center border-upg"><span class="user-performance-gross">@{{ item.resa_lordo }}</span></td>
                                        <td class="text-center border-upn"><span class="user-performance-net">@{{ item.resa }}</span></td>

                                    </tr>
                                </tbody>
                            </table>
                            </div>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('admin.pagination.overview') }}</span>
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
        </div>
    </user-performance-stat>

@endsection
