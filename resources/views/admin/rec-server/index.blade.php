@extends('ui.layout.app')

@section('title', trans('admin.rec-server.actions.index'))

@section('body')

    <rec-server-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/rec-server') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.rec-server.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/rec-server/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.rec-server.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary m-0" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
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

                                        <th is='sortable' :column="'id'">{{ trans('admin.rec-server.columns.id') }}</th>
                                        <th is='sortable' :column="'name'">{{ trans('admin.rec-server.columns.name') }}</th>
                                        <th is='sortable' :column="'type'" class="text-center">{{ trans('admin.rec-server.columns.type') }}</th>
                                        <th is='sortable' :column="'db_driver'" class="text-center">{{ trans('admin.rec-server.columns.db_driver') }}</th>
                                        <th is='sortable' :column="'db_host'" class="text-center">{{ trans('admin.rec-server.columns.db_host') }}</th>
                                        <th is='sortable' :column="'db_port'" class="text-center">{{ trans('admin.rec-server.columns.db_port') }}</th>
                                        <th is='sortable' :column="'db_name'" class="text-center">{{ trans('admin.rec-server.columns.db_name') }}</th>
                                        <th is='sortable' :column="'db_user'" class="text-center">{{ trans('admin.rec-server.columns.db_user') }}</th>
                                        <th is='sortable' :column="'db_rewrite_host'" class="text-center">{{ trans('admin.rec-server.columns.db_rewrite_host') }}</th>
                                        <th is='sortable' :column="'db_rewrite_search'">{{ trans('admin.rec-server.columns.db_rewrite_search') }}</th>
                                        <th is='sortable' :column="'db_rewrite_replace'">{{ trans('admin.rec-server.columns.db_rewrite_replace') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="13">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/rec-server')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/rec-server/bulk-destroy')">{{ trans('admin.btn.delete') }}</button>
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
                                        <td>@{{ item.name }}</td>
                                        <td class="text-center">@{{ item.type }}</td>
                                        <td class="text-center">@{{ item.db_driver }}</td>
                                        <td class="text-center">@{{ item.db_host }}</td>
                                        <td class="text-center">@{{ item.db_port }}</td>
                                        <td class="text-center">@{{ item.db_name }}</td>
                                        <td class="text-center">@{{ item.db_user }}</td>
                                        <td class="text-center"><i v-if="item.db_rewrite_host"
                                                                   class="fa fa-check text-success"></i></td>
                                        <td>@{{ item.db_rewrite_search }}</td>
                                        <td>@{{ item.db_rewrite_replace }}</td>

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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/rec-server/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.rec-server.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </rec-server-listing>

@endsection
