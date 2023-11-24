@extends('ui.layout.app')

@section('title', trans('admin.user-timelog.actions.index'))

@section('body')

    <user-timelog-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('user-timelog') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">

                        <div class="row">

                            <div class="col-lg-3 col-md-12 d-flex align-items-center">
                                <i class="fa fa-align-justify mr-3"></i> {{ trans('admin.user-timelog.actions.index') }}
                            </div>

                            <div class="col-lg-9 col-md-12 text-right">
                                <button type="button" @click="setToday" class="btn btn-primary ml-3">Oggi</button>
                                <button type="button" @click="setWeek" class="btn btn-primary ml-3">Questa Settimana</button>
                                <button type="button" @click="setMonth" class="btn btn-primary ml-3">Questo Mese</button>
                                <button type="button" @click="setYear" class="btn btn-primary ml-3">Questo Anno</button>
                                <a class="btn btn-primary btn-spinner ml-3" href="{{ url('user-timelog/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.user-timelog.actions.create') }}</a>
                            </div>

                        </div>

                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-5 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary m-0" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
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
                                                    <button type="button" class="btn btn-sm btn-primary m-0"
                                                            @click="clearStartFilter"><i class="now-ui-icons ui-1_simple-remove"></i></button>
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
                                                    <button type="button" class="btn btn-sm btn-primary m-0"
                                                            @click="clearEndFilter"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing m-3">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.user-timelog.columns.id') }}</th>
                                        <th is='sortable' :column="'user'">{{ trans('admin.user-timelog.columns.id_user') }}</th>
                                        <th is='sortable' :column="'user'">{{ trans('admin.user-timelog.columns.user') }}</th>
                                        <th is='sortable' :column="'period'">{{ trans('admin.user-timelog.columns.period') }}</th>
                                        <th is='sortable' :column="'ore'" class="text-center">{{ trans('admin.user-timelog.columns.ore') }}</th>


                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/user-timelog')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('user-timelog/bulk-destroy')">{{ trans('admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.user?.email }}</td>
                                        <td>@{{ item.user?.full_name }}</td>
                                        <td>@{{ item.period | formatDate}}</td>
                                        <td class="text-center">@{{ item.ore }}</td>


                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
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

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin.index.no_items') }}</h3>
                                <p>{{ trans('admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('user-timelog/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.user-timelog.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </user-timelog-listing>

@endsection
