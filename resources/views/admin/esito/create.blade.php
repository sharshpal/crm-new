@extends('ui.layout.app')

@section('title', trans('admin.esito.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <esito-form
            :action="'{{ url('admin/esito') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.esito.actions.create') }}
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
