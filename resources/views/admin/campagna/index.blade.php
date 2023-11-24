@extends('ui.layout.app')

@section('title', trans('admin.campagna.actions.index'))

@section('body')

    <campagna-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/campaign') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.campagna.actions.index') }}
                        @if(Auth::user()->hasPermissionTo('admin.campaign.create'))
                            <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0"
                               href="{{ url('admin/campaign/create') }}" role="button"><i
                                    class="fa fa-plus"></i>&nbsp; {{ trans('admin.campagna.actions.create') }}</a>
                        @endif
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
                                    <th is='sortable' :column="'id'">{{ trans('admin.campagna.columns.id') }}</th>
                                    <th is='sortable' :column="'nome'">{{ trans('admin.campagna.columns.nome') }}</th>
                                    <th is='sortable' :column="'tipo'">{{ trans('admin.campagna.columns.tipo') }}</th>

                                    <th></th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                    <td>@{{ item.id }}</td>
                                    <td> <img :src="item.logo_thumb_url"  v-if="item.logo_thumb_url" class="logo-img mr-2"/> @{{ item.nome }}</td>
                                    <td>@{{ item.tipo }}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            @if(Auth::user()->hasPermissionTo('admin.campaign.edit'))
                                                <div class="col-auto mr-2" >
                                                    <a class="btn btn-sm btn-spinner btn-info"
                                                       :href="item.resource_url + '/edit'"
                                                       title="{{ trans('admin.btn.edit') }}"
                                                       role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                            @endif
                                            @if(Auth::user()->hasPermissionTo('admin.campaign.delete'))
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            title="{{ trans('admin.btn.delete') }}">
                                                            <i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endif
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </campagna-listing>

@endsection
