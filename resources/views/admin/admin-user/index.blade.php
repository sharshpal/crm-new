@extends('ui.layout.app')

@section('title', trans('admin.admin-user.actions.index'))

@section('body')

    <admin-user-listing
        :data="{{ $data->toJson() }}"
        :activation="!!'{{ $activation }}'"
        :url="'{{ url('admin/users') }}'"
        :u="'{{Auth::user()->id}}'"
        :isAdmin="{{Auth::user()->hasRole("Admin") ? "true" : "false"}}"
        :campaigns-input="'{{ json_encode($campaignsList->toArray(), JSON_HEX_APOS) }}'"
        :bulk-assign-campaign-route="'{{$bulkAssignCampagnaRoute}}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.admin-user.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0"
                           href="{{ url('admin/users/create') }}" role="button"><i
                                class="fa fa-plus"></i>&nbsp; {{ trans('admin.admin-user.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <form @submit.prevent="">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control"
                                               placeholder="{{ trans('admin.placeholder.search') }}"
                                               v-model="search" @keyup.enter="filter('search', $event.target.value)"/>
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

                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-listing">
                                <thead>
                                <tr>

                                    @can("admin.admin-user.bulk-assign-campaign")
                                    <th class="bulk-checkbox">
                                        <input class="form-check-input" id="enabled" type="checkbox"
                                               v-model="isClickedAll" v-validate="''" data-vv-name="enabled"
                                               name="enabled_fake_element"
                                               @click="onBulkItemsClickedAllWithPagination()">
                                        <label class="form-check-label" for="enabled">
                                            #
                                        </label>
                                    </th>
                                    @endcan

                                    <th is='sortable' :column="'id'">{{ trans('admin.admin-user.columns.id') }}</th>

                                    <th is='sortable'
                                        :column="'first_name'">{{ trans('admin.admin-user.columns.first_name') }}</th>

                                    <th is='sortable'
                                        :column="'last_name'">{{ trans('admin.admin-user.columns.last_name') }}</th>

                                    <th is='sortable' :column="'email'">{{ trans('admin.admin-user.columns.email') }}</th>

                                    <th is='sortable'
                                        :column="'roles'">{{ trans('admin.admin-user.columns.roles') }}</th>

                                    <th is='sortable'
                                        :column="'campaigns'">{{ trans('admin.admin-user.columns.campaigns') }}</th>

                                    <th is='sortable'
                                        :column="'partners'">{{ trans('admin.admin-user.columns.partners') }}</th>

                                    <th is='sortable' :column="'activated'"
                                        v-if="activation">{{ trans('admin.admin-user.columns.activated') }}</th>
                                    <th class="text-center" is='sortable'
                                        :column="'forbidden'">{{ trans('admin.admin-user.columns.forbidden') }}</th>

                                    <th class="text-center" is='sortable'
                                        :column="'last_login_at'">{{ trans('admin.admin-user.columns.last_login_at') }}</th>

                                    <th></th>
                                </tr>



                                @can("admin.admin-user.bulk-assign-campaign")
                                <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                    <td class="bg-bulk-info d-table-cell text-left pt-3 pb-3" colspan="12">
                                            <span class="align-middle font-weight-bold text-dark">

                                                <span class="btn btn-success btn-sm text-white">{{ trans('admin.listing.selected_items') }}  [ @{{ clickedBulkItemsCount }} ]</span>

                                                <span class="text-primary ml-2 mr-2">|</span>

                                                <a href="#" class="btn btn-primary btn-sm"
                                                   @click="onBulkItemsClickedAll('/admin/users')"
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


                                    </td>
                                </tr>
                                    @endcan



                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection">

                                    @can("admin.admin-user.bulk-assign-campaign")
                                    <td class="bulk-checkbox" v-if="!hasRole(index,'Admin')">
                                        <input class="form-check-input" :id="'enabled' + item.id" type="checkbox"
                                               v-model="bulkItems[item.id]" v-validate="''"
                                               :data-vv-name="'enabled' + item.id"
                                               :name="'enabled' + item.id + '_fake_element'"
                                               @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                        <label class="form-check-label" :for="'enabled' + item.id">
                                        </label>
                                    </td>

                                    <td v-if="hasRole(index,'Admin')"></td>
                                    @endcan

                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.first_name }}</td>
                                    <td>@{{ item.last_name }}</td>
                                    <td>@{{ item.email }}</td>

                                    <td>
                                    <span
                                        :class="role.name=='Admin' ? 'badge-danger' : 'badge-success'"
                                        class="badge p-2 mr-2 text-white" v-for="role of item.roles"
                                        :key="role.id">
                                        @{{ role.label }}
                                    </span>
                                    </td>

                                    <td>
                                    <span
                                        class="badge badge-warning p-2 mr-2 mb-1" v-for="cp of item.campaigns"
                                        :key="cp.id">
                                        @{{ cp.nome }}
                                    </span>
                                    </td>

                                    <td>
                                    <span
                                        class="badge badge-warning p-2 mr-2 mb-1" v-for="pt of item.partners"
                                        :key="pt.id">
                                        @{{ pt.nome }}
                                    </span>
                                    </td>

                                    <td v-if="activation">
                                        <label class="switch switch-3d switch-success" v-if="item.id!=u">
                                            <input type="checkbox" class="switch-input"
                                                   v-model="collection[index].activated"
                                                   @change="toggleSwitch(item.resource_url, 'activated', collection[index])">
                                            <span class="switch-slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label class="switch switch-3d switch-danger" v-if="item.id!=u">
                                            <input type="checkbox" class="switch-input"
                                                   v-model="collection[index].forbidden"
                                                   @change="toggleSwitch(item.resource_url, 'forbidden', collection[index])">
                                            <span class="switch-slider"></span>
                                        </label>
                                    </td>

                                    <td class="text-center">@{{ item.last_login_at | datetime }}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            @can('admin.admin-user.impersonal-login')
                                                <div class="col-auto" v-if="item.id!=u && !hasRole(index,'Admin')">
                                                    <button class="btn btn-sm btn-success" v-show="item.activated"
                                                            @click="impersonalLogin(item.resource_url + '/impersonal-login', item)"
                                                            title="Impersonal login" role="button"><i
                                                            class="fa fa-user-o"></i></button>
                                                </div>
                                            @endcan
                                            <div class="col-auto">
                                                <button class="btn btn-sm btn-warning" v-if="!item.activated"
                                                        @click="resendActivation(item.resource_url + '/resend-activation')"
                                                        title="Resend activation" role="button"><i
                                                        class="fa fa-envelope-o"></i></button>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                   :href="item.resource_url + '/edit'"
                                                   title="{{ trans('admin.btn.edit') }}" role="button"><i
                                                        class="fa fa-edit"></i></a>
                                            </div>
                                            <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        title="{{ trans('admin.btn.delete') }}"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
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
                            <a class="btn btn-primary btn-spinner" href="{{ url('admin/users/create') }}" role="button"><i
                                    class="fa fa-plus"></i>&nbsp; {{ trans('admin.btn.new') }}
                                AdminUser</a>
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
    </admin-user-listing>

@endsection
