@extends('ui.layout.app')

@section('title', trans('admin.campagna.actions.edit', ['name' => $campagna->id]))

@section('body')

    <div class="container-xl">

        <div class="card">

            <campagna-form
            :action="'{{ route('admin/campaign/update', ['campagna' => $campagna]) }}'"
            :data="{{ $campagna->toJson() }}"
            v-cloak
            inline-template>

                <form class="form-horizontal" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header">
                        <i class="fa fa-plus"></i> {{ trans('admin.campagna.actions.edit', ['name' => $campagna->id]) }}
                    </div>

                    <div class="card-body">

                        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('nome'), 'has-success': fields.nome && fields.nome.valid }">
    <label for="nome" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.campagna.columns.nome') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nome" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nome'), 'form-control-success': fields.nome && fields.nome.valid}" id="nome" name="nome" placeholder="{{ trans('admin.campagna.columns.nome') }}">
        <div v-if="errors.has('nome')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nome') }}</div>
    </div>
</div>



                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.btn.save') }}
                        </button>
                    </div>

                </form>

            </campagna-form>

        </div>

    </div>

@endsection
