@extends('ui.layout.app')

@section('title', trans('admin.rec-server.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <rec-server-form
            :action="'{{ url('admin/rec-server') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.rec-server.actions.create') }}
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
