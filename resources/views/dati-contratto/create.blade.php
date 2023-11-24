@extends($isApi ? 'ui.layout.empty_default' : 'ui.layout.app')

@section('title', trans('admin.dati-contratto.actions.create'))

@section('body')

    <div class="container-xl">

        <div>
            <dati-contratto-form
                :action="'{{ url('dati-contratto') }}'"
                :data="{{ $datiContratto->toJson()}}"
                :campaigns-input="'{{ json_encode($campaignsList, JSON_HEX_APOS) }}'"
                :partners-input="'{{ json_encode($partnersList, JSON_HEX_APOS) }}'"
                :esiti-input="'{{ json_encode($esitiList, JSON_HEX_APOS) }}'"
                :is-edit="{{$isEdit ? 'true' : 'false'}}"
                :is-new="{{$isNew ? 'true' : 'false'}}"
                :is-api="{{$isApi ? 'true' : 'false'}}"
                :show-cp="{{$showCp ? 'true' : 'false'}}"
                :search-user-route="'{{$searchUserRoute}}'"
                :fetch-recall-url="'{{$fetchRecallUrl}}'"
                :set-created-at="{{Auth::user()->hasPermissionTo("dati-contratto.edit-create-date") ? 'true' : 'false'}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action"
                      novalidate>

                    <div class="card-header">
                        <i class="fa fa-plus"></i> {{ trans('admin.dati-contratto.actions.create') }}
                    </div>

                    <div class="card-body p-0 mt-3">
                        @include('dati-contratto.components.form-elements')
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary w-25" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-upload'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

            </dati-contratto-form>

        </div>

    </div>


@endsection
