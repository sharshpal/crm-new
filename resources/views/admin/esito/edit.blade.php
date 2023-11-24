@extends('ui.layout.app')

@section('title', trans('admin.esito.actions.edit', ['name' => $esito->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <esito-form
                :action="'{{ $esito->resource_url }}'"
                :data="{{ $esito->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.esito.actions.edit', ['name' => $esito->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.esito.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </esito-form>

        </div>

</div>

@endsection
