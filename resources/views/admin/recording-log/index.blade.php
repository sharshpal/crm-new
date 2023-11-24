@extends('ui.layout.app')

@section('title', trans('admin.recording-log.actions.index'))

@section('body')

    <recording-log-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('/recording-log') }}'"
        :rec-server-input="'{{ json_encode($recServer, JSON_HEX_APOS) }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.recording-log.actions.index') }}
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between filter-row-multiselect">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin.placeholder.search') }}"
                                                   v-model="active.search" @keyup.enter="updateList" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary m-0" @click="updateList"><i class="fa fa-search"></i>&nbsp; {{ trans('admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-5 col-sm-12">
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
                                            @input="updateList"
                                        >
                                            <template slot="noResult">
                                                {{ trans('admin.forms.no_result') }}
                                            </template>
                                            <template slot="noOptions">
                                                {{ trans('admin.forms.no_result') }}
                                            </template>
                                        </multiselect>
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

                                        <th is='sortable' :column="'recording_id'">{{ trans('admin.recording-log.columns.recording_id') }}</th>


                                        <th is='sortable' :column="'start_time'">{{ trans('admin.recording-log.columns.start_time') }}</th>
                                        <th is='sortable' :column="'end_time'">{{ trans('admin.recording-log.columns.end_time') }}</th>

                                        <th is='sortable' :column="'campagna'">{{ trans('admin.recording-log.columns.campagna') }}</th>
                                        <th is='sortable' :column="'telefono'">{{ trans('admin.recording-log.columns.telefono') }}</th>

                                        <th is='sortable' :column="'user'">{{ trans('admin.recording-log.columns.user') }}</th>

                                        <th is='sortable' :column="'length_in_sec'">{{ trans('admin.recording-log.columns.length_in_sec') }}</th>
                                        <th is='sortable' :column="'length_in_min'">{{ trans('admin.recording-log.columns.length_in_min') }}</th>
                                        <th class="text-center">Ascolta</th>
                                        <th class="text-center">Scarica</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.recording_id" :class="bulkItems[item.recording_id] ? 'bg-bulk' : ''">

                                    <td>@{{ item.recording_id }}</td>

                                        <td>@{{ item.start_time | datetime }}</td>
                                        <td>@{{ item.end_time | datetime }}</td>

                                        <td>@{{ item.campagna }}</td>
                                        <td>@{{ item.telefono }}</td>
                                        <td>@{{ item.user }}</td>



                                        <td>@{{ item.length_in_sec }}</td>
                                        <td>@{{ item.length_in_min }}</td>


                                        <td>
                                            <div class="row no-gutters"  v-if="item.rewrite_location">
                                                <div class="col-12 text-center">
                                                    <audio controls class="audio-player">
                                                        <source :src="item.rewrite_location" type="audio/mpeg">
                                                        Il tuo browser non supporta il Player Audio HTML5
                                                    </audio>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="justify-content-center">
                                            <form method="get" :action="item.rewrite_location" v-if="item.rewrite_location">
                                                <button type="submit" class="btn btn-sm btn-info" title="{{ trans('admin.btn.download') }}">
                                                    <i class="fa fa-download"></i>
                                                </button>
                                            </form>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </recording-log-listing>

@endsection
