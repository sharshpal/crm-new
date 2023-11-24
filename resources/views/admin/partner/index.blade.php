@extends('ui.layout.app')

@section('title', trans('admin.partner.actions.index'))

@section('body')

    <partner-listing
        :data="{{ $data }}"
        :url="'{{ url('admin/partners') }}'"
        :campaigns-input="'{{ json_encode($campaignsList->toArray(), JSON_HEX_APOS) }}'"
        :bulk-assign-campaign-route="'{{$bulkAssignCampagnaRoute}}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.partner.actions.index') }}

                        @if(Auth::user()->hasPermissionTo('admin.partner.create'))
                            <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0"
                               href="{{ url('admin/partners/create') }}" role="button"><i
                                    class="fa fa-plus"></i>&nbsp; {{ trans('admin.partner.actions.create') }}</a>
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

                            <table class="table table-hover table-listing m-3">
                                <thead>


                                <tr>

                                    <th class="bulk-checkbox">
                                        <input class="form-check-input" id="enabled" type="checkbox"
                                               v-model="isClickedAll" v-validate="''" data-vv-name="enabled"
                                               name="enabled_fake_element"
                                               @click="onBulkItemsClickedAllWithPagination()">
                                        <label class="form-check-label" for="enabled">
                                            #
                                        </label>
                                    </th>

                                    <th is='sortable' :column="'id'">{{ trans('admin.partner.columns.id') }}</th>
                                    <th is='sortable' :column="'nome'">{{ trans('admin.partner.columns.nome') }}</th>
                                    <th is='sortable'
                                        :column="'campaigns'">{{ trans('admin.partner.columns.campaigns') }}</th>
                                    <th is='sortable'
                                        :column="'vc_usergroup'">{{ trans('admin.partner.columns.vc_usergroup') }}</th>
                                    <th></th>
                                </tr>


                                <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                    <td class="bg-bulk-info d-table-cell text-left pt-3 pb-3" colspan="6">
                                            <span class="align-middle font-weight-bold text-dark">

                                                <span class="btn btn-success btn-sm text-white">{{ trans('admin.listing.selected_items') }}  [ @{{ clickedBulkItemsCount }} ]</span>

                                                <span class="text-primary ml-2 mr-2">|</span>

                                                <a href="#" class="btn btn-primary btn-sm"
                                                   @click="onBulkItemsClickedAll('/admin/partners')"
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
                                                            @click="openAssignBulkCampagnaModal">
                                                        Assegna Campagna
                                                    </button>
                                                </span>

                                        @if(false)
                                            <span class="pull-right pr-2">
                                                        <button class="btn btn-sm btn-danger pr-3 pl-3"
                                                                @click="bulkDelete('/partner/bulk-destroy')">
                                                            {{ trans('admin.btn.delete') }}
                                                        </button>
                                                    </span>
                                        @endif
                                    </td>
                                </tr>


                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                    <td class="bulk-checkbox">
                                        <input class="form-check-input" :id="'enabled' + item.id" type="checkbox"
                                               v-model="bulkItems[item.id]" v-validate="''"
                                               :data-vv-name="'enabled' + item.id"
                                               :name="'enabled' + item.id + '_fake_element'"
                                               @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                        <label class="form-check-label" :for="'enabled' + item.id">
                                        </label>
                                    </td>

                                    <td>@{{ item.id }}</td>
                                    <td><img :src="item.logo_thumb_url"  v-if="item.logo_thumb_url" class="logo-img mr-2"/> @{{ item.nome }}</td>

                                    <td>
                                        <span class="badge badge-warning p-2 ml-2" v-for="cmp of item.campaigns"
                                              :key="cmp.id">
                                            <img :src="cmp.logo_thumb_url"  v-if="cmp.logo_thumb_url" class="logo-img mr-2"/> @{{ cmp.nome }}
                                        </span>
                                    </td>

                                    <td>@{{ item.vc_usergroup }}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            @if(Auth::user()->hasPermissionTo('admin.partner.edit'))
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info"
                                                       :href="item.resource_url + '/edit'"
                                                       title="{{ trans('admin.btn.edit') }}"
                                                       role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                            @endif
                                            @if(Auth::user()->hasPermissionTo('admin.partner.delete'))
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            title="{{ trans('admin.btn.delete') }}">
                                                        <i
                                                            class="fa fa-trash"></i></button>
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


            <modal name="bulk-assign-campagna-modal" id="bulk-assign-campagna-modal"
                   class="modal--translation" width="50%" height="auto" :scrollable="true"
                   :adaptive="true" :pivot-y="0.25"
                   v-cloak
            >
                <h4 class="modal-title mb-2 mt-3">Assegna Campagna</h4>
                <div class="row mt-5">
                    <div class="col-lg-6 offset-lg-3 col-sm-12">
                        <multiselect
                            v-model="selectedNewBulkCampagna"
                            name="new_bulk_esito"
                            placeholder="{{ trans('admin.forms.select_an_option') }}"
                            :options="campaignsList"
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
                                :disabled="campaignsList.length==0||selectedNewBulkCampagna==null||selectedNewBulkCampagna=={}"
                                @click="bulkAssignCampagna">{{ trans('admin.btn.save') }}</button>
                    </div>
                </div>

            </modal>




        </div>


    </partner-listing>

@endsection
