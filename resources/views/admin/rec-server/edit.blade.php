@extends('ui.layout.app')

@section('title', trans('admin.rec-server.actions.edit', ['name' => $recServer->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <rec-server-form
                :action="'{{ $recServer->resource_url }}'"
                :data="{{ $recServer->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.rec-server.actions.edit', ['name' => $recServer->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.rec-server.components.form-elements')
                    </div>


                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </rec-server-form>

        </div>

</div>

@endsection
