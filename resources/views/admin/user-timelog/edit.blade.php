@extends('ui.layout.app')

@section('title', trans('admin.user-timelog.actions.edit', ['name' => $userTimelog->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <user-timelog-form
                :action="'{{ $userTimelog->resource_url }}'"
                :data="{{ $userTimelog->toJson() }}"
                :search-user-route="'{{$searchUserRoute}}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.user-timelog.actions.edit', ['name' => $userTimelog->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.user-timelog.components.form-elements')
                    </div>


                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </user-timelog-form>

        </div>

</div>

@endsection
