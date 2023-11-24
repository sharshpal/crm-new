@extends('ui.layout.app')

@section('title', trans('admin.partner.actions.edit', ['name' => $partner->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <partner-form
                :action="'{{ $partner->resource_url }}'"
                :data="{{ $partner->toJson() }}"
                :campaigns-input="'{{ json_encode($campaigns->toArray(), JSON_HEX_APOS) }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.partner.actions.edit', ['name' => $partner->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.partner.components.form-elements')
                    </div>


                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </partner-form>

        </div>

</div>

@endsection
