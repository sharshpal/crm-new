@extends('ui.layout.app')

@section('title', trans('admin.vicidial-agent-log.actions.index'))

@section('body')

    <vicidial-agent-log-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('agent-log') }}'"
        :rec-server-input="'{{ json_encode($recServer, JSON_HEX_APOS) }}'"
        :export-url="'{{$exportUrl}}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.vicidial-agent-log.actions.index') }}

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
                                <div class="row justify-content-md-start filter-row-multiselect  align-items-center mb-4">

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

                                <hr v-if="active.server" />

                                <div class="row justify-content-md-between filter-row-multiselect" v-if="active.server">

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


                            <div class="table-responsive">

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


                                    <th is='sortable'
                                        :column="'user_group'">{{ trans('admin.vicidial-agent-log.columns.user_group') }}</th>

                                    <th
                                        :column="'full_name'">{{ trans('admin.vicidial-agent-log.columns.full_name') }}</th>
                                    <th is='sortable'
                                        :column="'user'">{{ trans('admin.vicidial-agent-log.columns.user') }}</th>

                                    <th is='sortable'
                                        :column="'pause_sec'"
                                        class="text-center" colspan="2">{{ trans('admin.vicidial-agent-log.columns.pause_sec') }}</th>

                                    <th is='sortable'
                                        :column="'wait_sec'"
                                        class="text-center" colspan="2">{{ trans('admin.vicidial-agent-log.columns.wait_sec') }}</th>

                                    <th is='sortable'
                                        :column="'talk_sec'"
                                        class="text-center" colspan="2">{{ trans('admin.vicidial-agent-log.columns.talk_sec') }}</th>

                                    <th is='sortable'
                                        :column="'after_call_work'"
                                        class="text-center" colspan="2">{{ trans('admin.vicidial-agent-log.columns.after_call_work') }}</th>

                                    <th is='sortable'
                                        :column="'login_time'" class="text-center">{{ trans('admin.vicidial-agent-log.columns.login_time') }}</th>

                                    <th is='sortable'
                                        :column="'effective_time'" class="text-center">{{ trans('admin.vicidial-agent-log.columns.effective_time') }}</th>

                                </tr>
                                @if(false)
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="15">
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
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">

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

                                    <td><i class="icon-people font-weight-bold"></i> @{{ item.user_group }}</td>

                                    <td class="border-left">
                                        <strong><i class="icon-user font-weight-bold"></i>
                                            @{{ item.user?.full_name}}
                                        </strong>
                                    </td>
                                        <td class="border-left">
                                        <i class="fa fa-id-badge font-weight-bold"></i>
                                        @{{ item.user?.user }}
                                    </td>


                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp;@{{ item.pause_sec }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-ghost text-warning font-weight-bold"></i>
                                            @{{ item.pause_hour }}

                                        </div>
                                    </td>
                                    <td><span class="badge badge-warning w-100">@{{ item.pause_perc}}%</span></td>


                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp;@{{ item.wait_sec }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-hourglass text-danger font-weight-bold"></i>
                                            @{{ item.wait_hour }}

                                        </div>
                                    </td>
                                    <td><span class="badge badge-danger w-100">@{{ item.wait_perc}}%</span></td>


                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp; @{{ item.talk_sec }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-microphone text-success font-weight-bold"></i>
                                            @{{ item.talk_hour }}

                                        </div>
                                    </td>
                                    <td><span class="badge badge-success text-white w-100">@{{ item.talk_perc}}%</span></td>


                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp; @{{ item.after_call_work }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-pencil text-info font-weight-bold"></i>
                                            @{{ item.after_call_work_hour }}

                                        </div>
                                    </td>
                                    <td><span class="badge badge-info text-white w-100">@{{ item.after_call_work_perc}}%</span></td>


                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp; @{{ item.login_time }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-login text-primary font-weight-bolder"></i> @{{
                                            item.login_time_hour }}
                                        </div>
                                    </td>

                                    <td class="border-left">
                                        <div v-if="showSeconds">&nbsp; @{{ item.effective_time }} sec.</div>
                                        <div v-if="showHours" class="font-weight-bold">&nbsp;<i
                                                class="icon-clock text-success  font-weight-bolder"></i> @{{
                                            item.effective_time_hour }}
                                        </div>
                                    </td>

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

                            <div class="no-items-found" v-if="!collection.length > 0|| this.$parent.loading">
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
    </vicidial-agent-log-listing>

@endsection
