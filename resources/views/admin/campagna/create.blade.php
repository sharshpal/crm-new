@extends('ui.layout.app')

@section('title', trans('admin.campagna.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <campagna-form
            :action="'{{ url('admin/campaign') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.campagna.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.campagna.components.form-elements')
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('admin.btn.save') }}
                    </button>
                </div>

            </form>

        </campagna-form>

        </div>

        </div>


@endsection
