@extends('ui.layout.app')

@section('title', trans('admin.sys-setting.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <sys-setting-form
            :action="'{{ url('admin/sys-settings') }}'"
            :data="{{ json_encode($data, JSON_HEX_APOS) }}"
            :color-names-input="'{{ json_encode($colorNames) }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.sys-setting.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.sys-setting.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('admin.btn.save') }}
                    </button>
                </div>

            </form>

        </sys-setting-form>

        </div>

        </div>


@endsection
