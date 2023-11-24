@extends('ui.layout.app')

@section('title', trans('admin.esito.actions.index'))

@section('body')

    <esito-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/esito') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.esito.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0"
                           href="{{ url('admin/esito/create') }}" role="button"><i
                                class="fa fa-plus"></i>&nbsp; {{ trans('admin.esito.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control"
                                                   placeholder="{{ trans('admin.placeholder.search') }}"
                                                   v-model="search"
                                                   @keyup.enter="filter('search', $event.target.value)"/>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary m-0"
                                                        @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
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

                            <table class="table table-hover table-listing">
                                <thead>
                                <tr>


                                    <th is='sortable' :column="'id'">{{ trans('admin.esito.columns.id') }}</th>
                                    <th is='sortable' :column="'nome'">{{ trans('admin.esito.columns.nome') }}</th>
                                    <th :column="'is_new'"
                                        class="text-center">{{ trans('admin.esito.columns.is_new') }}</th>
                                    <th :column="'is_final'"
                                        class="text-center">{{ trans('admin.esito.columns.is_final') }}</th>

                                    <th :column="'is_ok'"
                                        class="text-center">{{ trans('admin.esito.columns.is_ok') }}</th>

                                    <th :column="'is_not_ok'"
                                        class="text-center">{{ trans('admin.esito.columns.is_not_ok') }}</th>

                                    <th :column="'is_recover'"
                                        class="text-center">{{ trans('admin.esito.columns.is_recover') }}</th>

                                    <th></th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.nome }}</td>
                                    <td class="text-center"><i v-if="item.is_new"
                                                               class="fa fa-check text-success font-2xl"></i></td>

                                    <td class="text-center"><i v-if="item.is_final"
                                                               class="fa fa-check text-success font-2xl"></i></td>

                                    <td class="text-center"><i v-if="item.is_ok"
                                                               class="fa fa-check text-success font-2xl"></i></td>

                                    <td class="text-center"><i v-if="item.is_not_ok"
                                                               class="fa fa-check text-success font-2xl"></i></td>

                                    <td class="text-center"><i v-if="item.is_recover"
                                                               class="fa fa-check text-success font-2xl"></i></td>

                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-auto mr-2">
                                                <a class="btn btn-sm btn-info"
                                                   :href="item.resource_url + '/edit'"
                                                   title="{{ trans('admin.btn.edit') }}"
                                                   role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                            <form v-if="!item.is_new && !item.is_recover" class="col"
                                                  @submit.prevent="deleteItem(item.resource_url)">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        title="{{ trans('admin.btn.delete') }}"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/esito/create') }}"
                                   role="button"><i
                                        class="fa fa-plus"></i>&nbsp; {{ trans('admin.esito.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </esito-listing>

@endsection
