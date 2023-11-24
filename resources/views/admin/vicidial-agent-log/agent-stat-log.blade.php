@extends('ui.layout.app')

@section('title', trans('admin.vicidial-agent-log.actions.stat_log'))

@section('body')

    <vicidial-agent-stat-log-listing
        :data="{{ $data }}"
        :url="'{{ url('agent-stat-log') }}'"
        :rec-server-input="'{{ json_encode($recServer, JSON_HEX_APOS) }}'"
        :export-url="'{{$exportUrl}}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.vicidial-agent-log.actions.stat_log') }}

                        <button type="button"
                                class="btn btn-primary btn-sm pull-right mb-0 mr-3"
                                @click="exportData"
                                :disabled="this.$parent.loading"
                        >
                            <i class="fa fa-file-excel-o"></i>
                            Exporta Excel
                        </button>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-start align-items-center filter-row-multiselect mb-4">

                                    <div class="col-lg col-sm-12" :class="active.server ? 'col-lg' : 'col-lg-6'">
                                        <label>Seleziona Server</label>
                                        <multiselect
                                            v-model="active.server"
                                            placeholder="Seleziona un server"
                                            :options="recServerList"
                                            :multiple="false"
                                            track-by="id"
                                            label="name"
                                            open-direction="bottom"
                                            :show-no-options="true"
                                            name="server"
                                            :preserve-search="false"
                                            @input="reloadServer"
                                        >
                                            <template slot="noResult">
                                                {{ trans('admin.forms.no_result') }}
                                            </template>
                                            <template slot="noOptions">
                                                {{ trans('admin.forms.no_result') }}
                                            </template>
                                        </multiselect>
                                    </div>

                                    <div class="col-lg col-sm-12 text-right" :class="active.server ? 'col-lg' : 'col-lg-6'" v-if="active.server">
                                        <button type="button" @click="setToday" class="btn btn-primary mr-2">Oggi</button>
                                        <button type="button" @click="setWeek" class="btn btn-primary mr-2">Questa Settimana</button>
                                        <button type="button" @click="setMonth" class="btn btn-primary mr-2">Questo Mese</button>
                                        <button type="button" @click="setYear" class="btn btn-primary mr-2">Questo Anno</button>
                                    </div>

                                </div>

                                <hr  />

                                <div class="row justify-content-md-between filter-row-multiselect" v-if="active.server" >

                                    <div class="col col-lg-3 col-xl-3 form-group">
                                        <label>User ID</label>
                                        <div class="input-group">
                                            <input class="form-control"
                                                   placeholder="{{ trans('admin.placeholder.search') }}"
                                                   v-model="active.search"
                                                   @keyup.enter="updateListCbk"/>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="updateListCbk"><i
                                                        class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-12">
                                        <label>Dal</label>
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

                                    <div class="col-lg-2 col-md-12">
                                        <label>Al</label>
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

                                    <div class="col-lg-4 col-sm-12 form-group">
                                        <label>Campagna</label>
                                        <multiselect
                                            v-model="active.campaign_id"
                                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                                            :options="campaignsList"
                                            :multiple="true"
                                            track-by="campaign_id"
                                            key="campaign_id"
                                            label="campaign_id"
                                            open-direction="bottom"
                                            @close="updateListCbk"
                                            @remove="updateListCbk"
                                        ></multiselect>
                                    </div>



                                </div>
                            </form>

                            <table class="table table-hover table-listing table-last-normal" v-if="!this.$parent.loading">
                                <thead>
                                <tr>
                                    @if(false)
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox"
                                                   v-model="isClickedAll" v-validate="''" data-vv-name="enabled"
                                                   name="enabled_fake_element"
                                                   @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>
                                    @endif


                                    <th
                                        :column="'full_name'">{{ trans('admin.vicidial-agent-log.columns.full_name') }}</th>

                                    <th
                                        :column="'user'">{{ trans('admin.vicidial-agent-log.columns.user') }}</th>

                                    <th
                                        :column="'calls'"
                                        class="text-center">{{ trans('admin.vicidial-agent-log.columns.calls') }}</th>


                                    <th v-for="status in collection.statuses" :key="status" class="text-center">
                                        @{{ status }}
                                    </th>

                                </tr>
                                @if(false)
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="16">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a
                                                    href="#" class="text-primary"
                                                    @click="onBulkItemsClickedAll('/admin/vicidial-agent-log')"
                                                    v-if="(clickedBulkItemsCount < pagination.state.total)"> <i
                                                        class="fa"
                                                        :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span
                                                    class="text-primary">|</span> <a
                                                    href="#" class="text-primary"
                                                    @click="onBulkItemsClickedAllUncheck()">{{ trans('admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3"
                                                        @click="bulkDelete('/admin/vicidial-agent-log/bulk-destroy')">{{ trans('admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                @endif
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection.rows" :key="index"
                                    :class="bulkItems[index] ? 'bg-bulk' : ''">

                                    @if(false)
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox"
                                                   v-model="bulkItems[item.id]" v-validate="''"
                                                   :data-vv-name="'enabled' + item.id"
                                                   :name="'enabled' + item.id + '_fake_element'"
                                                   @click="onBulkItemClicked(item.id)"
                                                   :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>
                                    @endif


                                    <td>
                                        <strong><i class="icon-user font-weight-bold"></i>
                                            @{{ item.userinfo?.full_name }}
                                        </strong>
                                    </td>
                                    <td><i class="fa fa-id-badge font-weight-bold"></i> @{{ item.user }}</td>

                                    <td class="text-center">
                                        @{{ item.calls }}
                                    </td>

                                    <td v-for="status in collection.statuses" :key="status" class="text-center">
                                        @{{ item.statuses!=null && item.statuses[status] && item.statuses[status] > 0 ?
                                        item.statuses[status] : "" }}
                                    </td>

                                </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!Object.keys(collection.rows).length > 0 || this.$parent.loading">
                                <i class="icon-magnifier"></i>
                                <h3 v-if="!this.$parent.loading">{{ trans('admin.index.no_items') }}</h3>
                                <p v-if="!this.$parent.loading">{{ trans('admin.index.try_changing_items') }}</p>
                                <h2 v-if="this.$parent.loading">{{ trans('admin.index.loading') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vicidial-agent-stat-log-listing>

@endsection
