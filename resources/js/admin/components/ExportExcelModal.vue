<template>
    <modal name="export-data" ref="expDataModal"
           class="modal--translation" width="70%" height="auto" :scrollable="true"
           :adaptive="true" :pivot-y="0.25"
    >
        <h4 class="modal-title mb-2">Esportazione Excel Dati Contratti</h4>
        <div class="text-center">
            <form>
                <p class="text-center font-weight-bold mb-2">Stai per esportare tutti i contratti selezionati tramite
                    filtro.</p>
                <p class="text-center font-weight-bold mb-2">Seleziona le colonne da esportare</p>
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary btn-sm" @click="selectAll">Seleziona Tutto</button>
                        <button type="button" class="btn btn-primary btn-sm" @click="clearAll">Pulisci</button>
                    </div>
                </div>
                <div class="form-group" :class="{'has-danger': errors.has('exportCols')}">
                    <input type="hidden" name="exportCols" v-model="exportCols" v-validate="'required'"/>
                    <div class="row justify-content-start align-items-center exp-col-ctn">
                        <div class="btn-exp-col col-lg-4 text-left" v-for="expCol in columnsList">
                            <input class="form-check-input"
                                   :id="expCol.id"
                                   type="checkbox"
                                   :name="expCol.id"
                                   :checked="isChecked(expCol.id)"
                                   @click="toggleExportCol(expCol.id)"
                            >
                            <label class="form-check-label" :for="expCol.id">
                                {{ expCol.label }}
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div v-if="errors.has('exportCols')"
                                 class="alert alert-danger mt-3 mb-0"
                                 v-cloak>Selezionare almeno una colonna
                            </div>
                        </div>
                    </div>

                </div>
                <button
                    @click="onSubmitExport"
                    class="btn btn-primary col-md-2 mt-2"
                    :disabled="exportCols.length==0"
                    type="button">
                    <i class="fa fa-file-excel-o"></i>&nbsp;{{ exportLabel }}
                </button>
            </form>
        </div>
    </modal>
</template>

<script>
export default {
    name: "ExportExcelModal",
    props: {
        exportUrl: String,
        exportableColumns: String,
        exportLabel: String,
        getFiltersFn: Function
    },
    data: function () {
        return {
            exportCols: [],
        }
    },
    computed: {
        columnsList: {
            get: function () {
                return JSON.parse(this.exportableColumns);
            }
        },
    },
    methods: {
        isChecked: function(itemId){
            return this.exportCols.indexOf(itemId) >= 0;
        },
        clearAll: function () {
            this.exportCols = [];
        },
        selectAll: function () {
            this.exportCols = [];
            for (let i of this.columnsList) {
                this.exportCols.push(i.id);
            }
        },
        showExportModal: function () {
            this.$modal.show('export-data');
            this.exportCols = [];
        },
        exportList: function () {
            var params = Object.assign({}, this.getFiltersFn());
            params["columns"] = this.exportCols;
            var url = this.exportUrl + '?' + $.param(params);
            window.location = url;
        },
        toggleExportCol(id) {
            var io = this.exportCols.indexOf(id);
            if (io == -1) {
                this.exportCols.push(id);
            } else {
                this.exportCols.splice(io, 1);
            }
        },
        onSubmitExport: function onSubmitExport() {
            var _this5 = this;

            return this.$validator.validateAll().then(function (result) {
                if (!result) {
                    _this5.$notify({type: 'error', title: 'Error!', text: 'Il form contiene degli errori'});
                    return false;
                }

                _this5.exportList();
                _this5.$modal.hide('export-translation');
            });
        },
    }
}
</script>

<style scoped>

</style>
