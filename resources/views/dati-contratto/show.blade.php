@extends('ui.layout.app')

@section('title', trans('admin.dati-contratto.actions.show', ['name' => $datiContratto->id]))

@section('body')

    <div class="container-xl">
        <div>

            <dati-contratto-form
                :action="'{{ $datiContratto->resource_url }}'"
                :data="{{ $datiContratto->toJson()}}"
                :campaigns-input="'{{ json_encode($campaignsList, JSON_HEX_APOS) }}'"
                :esiti-input="'{{ json_encode($esitiList, JSON_HEX_APOS) }}'"
                :partners-input="'{{ json_encode($partnersList, JSON_HEX_APOS) }}'"
                :is-edit="{{$isEdit ? 'true' : 'false'}}"
                :is-new="{{$isNew ? 'true' : 'false'}}"
                :is-api="{{$isApi ? 'true' : 'false'}}"
                :show-cp="{{$showCp ? 'true' : 'false'}}"
                :search-user-route="'{{$searchUserRoute}}'"
                :fetch-recall-url="'{{$fetchRecallUrl}}'"
                :set-created-at="{{Auth::user()->hasPermissionTo("dati-contratto.edit-create-date") ? 'true' : 'false'}}"
                v-cloak
                inline-template>

                <div>

                    <div class="card-header">
                        <i class="fa fa-eye"></i> {{ trans('admin.dati-contratto.actions.show', ['name' => $datiContratto->id]) }}
                    </div>

                    <div class="card-body p-0 mt-3">
                        @include('dati-contratto.components.form-elements')
                    </div>

                    @if(Auth::user()->hasPermissionTo("dati-contratto.edit") || (Auth::user()->hasPermissionTo("dati-contratto.set-recovered") && $datiContratto->esito()->first()->is_final))
                        <div class="card-footer text-center">

                            @can("dati-contratto.edit")
                                <a :href="data.resource_url + '/edit'" class="btn btn-primary w-25"
                                   :disabled="submiting">
                                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-pencil'"></i>
                                    {{ trans('admin.btn.edit') }}
                                </a>
                            @endcan

                            @if (Auth::user()->hasPermissionTo("dati-contratto.set-recovered") && $datiContratto->esito()->first()->is_final)
                                <a :href="data.resource_url + '/recover'" class="btn btn-primary w-25"
                                   v-if="data.esito.is_final"
                                   :disabled="submiting">
                                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-pencil'"></i>
                                    {{ trans('admin.btn.recover') }}
                                </a>
                            @endif

                        </div>
                    @endif

                </div>

            </dati-contratto-form>

        </div>

    </div>

@endsection
