<template>
    <span>
        <modal name="import-file" class="modal--translation" v-cloak height="auto" :scrollable="true"
               :adaptive="true"
               :pivot-y="0.25"
               @before-open="resetModal"
               @before-close="resetModal"
        >
            <h4 class="modal-title">Verifica Invito a Fatturare</h4>
            <form>
                <div class="text-center" v-if="formStep == 1">

                        <p class="text-center">Seleziona il file csv dal tuo pc</p>
                        <hr/>
                        <div class="form-group" :class="{'has-danger': errors.has('file')}">
                            <div class="row">
                                <div class="col-12">
                                     <input
                                         type="file"
                                         accept=".csv"
                                         id="file-upload-button"
                                         class="custom-file-input"
                                         @change="fileChanged"
                                         placholder="Seleziona una file dal tuo pc"
                                     />
                                    <label
                                        class="custom-file-label"
                                    >{{ fileLabelContent }}
                                    </label>
                                </div>
                            </div>
                            <h4 class="text-center mt-3 mb-2">Impostazioni</h4>
                            <div class="form-group row align-items-center ">
                                <label class="col-form-label col-md-4 text-left">Riga Intestazione</label>
                                <div class="col-md-8">
                                    <select class="w-50" v-model="csvConfig.skipFirstLine">
                                        <option :value="true">SI</option>
                                        <option :value="false">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-form-label col-md-4 text-left">Separatore</label>
                                <div class="col-md-8">
                                    <select class="w-50" v-model="csvConfig.delimiter">
                                        <option :value="';'">Punto e Virgola ( ; ) </option>
                                        <option :value="','">Virgola ( , )</option>
                                        <option :value="'\t'">Tab</option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row align-items-center">
                                <label class="col-form-label col-md-4 text-left">Commento</label>
                                <div class="col-md-8">
                                    <input class="w-50 text-center" v-model="csvConfig.comments" maxlength="1"></input>
                                </div>
                            </div>
                        </div>

                        <hr v-if="csvErrors"/>
                        <div v-if="csvErrors" class="alert alert-danger">Il file csv contiene degli errori</div>

                        <hr/>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button
                                    @click="onParserSubmitImport"
                                    class="btn btn-primary"
                                    :disabled="currentSelectedFilepath.length==0"
                                    type="button">
                                    <i class="fa fa-upload"></i>&nbsp;Leggi File
                                </button>
                            </div>
                        </div>

                </div>

                <div class="text-center" v-if="formStep == 2">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group row align-items-center">
                                <label class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova il <b>Codice Pratica?</b></label>
                                <div class="col-md-4">
                                    <select class="w-100" v-model="cod_pr_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('cod_pr_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group row align-items-center">
                                 <label
                                     class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova il <b>Codice Fiscale? </b></label>
                                <div class="col-md-4">
                                    <select class="w-100" name="cf_col" v-model="cf_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('cf_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>

                            <div class="form-group row align-items-center">
                                 <label
                                     class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova il <b>Codice POD? </b></label>
                                <div class="col-md-4">
                                    <select class="w-100" name="pod_col" v-model="pod_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('pod_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>


                            <div class="form-group row align-items-center">
                                 <label
                                     class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova il <b>Codice PDR? </b></label>
                                <div class="col-md-4">
                                    <select class="w-100" name="pdr_col" v-model="pdr_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('pdr_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>


                            <div class="form-group row align-items-center">
                                 <label
                                     class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova l'<b>ID CAMPAGNA? </b></label>
                                <div class="col-md-4">
                                    <select class="w-100" name="campagna_col" v-model="campagna_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('campagna_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>

                            <div class="form-group row align-items-center">
                                 <label class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trovano le <b>Note?</b></label>
                                <div class="col-md-4">
                                    <select class="w-100" v-model="note_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('note_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>

                            <div class="form-group row align-items-center">
                                 <label
                                     class="col-form-label col-md-8 text-left">In quale <b>colonna</b> si trova lo <b>Stato/Esito?</b></label>
                                <div class="col-md-4">
                                    <select class="w-100" v-model="stato_col" @change="selRowChanged">
                                        <option v-for="colItem in availableColList('stato_col')"
                                                :value="colItem">{{
                                                colItem >= 0 ? parseInt(colItem) + 1 : "seleziona colonna"
                                            }}</option>
                                    </select>
                                </div>
                             </div>

                            <hr v-if="sendDataErrors.length"/>
                            <div class="alert alert-danger" v-if="sendDataErrors.length">
                                <p v-for="msg in sendDataErrors">{{ msg }}</p>
                            </div>

                            <hr/>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button
                                        @click="sendData()"
                                        class="btn btn-primary"
                                        type="button"
                                        :disabled="!canSend()"
                                    >
                                        <i class="fa fa-upload"></i>&nbsp;Invia
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </modal>
    </span>
</template>

<script>
import XLSX from 'xlsx';
import axios from 'axios';
import PapaParse from 'papaparse';

export default {
    props: {
        sendDataUrl: String,
        sendCallbackFn: Function
    },
    computed: {
        fileLabelContent: {
            get: function () {
                if (this.currentSelectedFilepath.length == 0) return 'Seleziona File ...';
                let x = this.currentSelectedFilepath.replace(/\\/g, '/').split("/").pop();
                return x;
            }
        },


    },
    data: function () {
        return {
            readData: [],
            formStep: 1,
            csvErrors: false,
            sendDataErrors: [],
            mode: 'csv',
            fileContentJson: {},
            currentSelectedFilepath: '',
            currentSelectedFileBlob: '',
            cod_pr_col: '-1',
            cf_col: '-1',
            pod_col: '-1',
            pdr_col: '-1',
            campagna_col: '-1',
            note_col: '-1',
            stato_col: '-1',
            csvConfig: {
                skipFirstLine: true,
                header: false,
                comments: '#',
                delimiter: ",",
                skipEmptyLines: true,
                complete: this.onCsvReadComplete
            }
        }
    },
    methods: {
        selRowChanged() {
            this.sendDataErrors = [];
        },
        availableColList(colName) {
            let t = [];
            if (this.readData.length > 0) {
                t.push('-1');
                for (let i = 0; i < this.readData[0].length; i++) {
                    if (this[colName] == i || this.notAssigned(i)) {
                        t.push(String(i));
                    }
                }
            }
            return t;
        },
        sendData() {

            this.sendDataErrors = [];

            let sendData = [];
            for (let index in this.readData) {
                let d = this.readData[index];
                let t = {campagna: "", cf: "", cod_pr: "", pod: "", pdr: "", note: "", stato: "", "row": this.csvConfig.skipFirstLine ? parseInt(index)+1 : index};

                if (!isNaN(this.cf_col) && parseInt(this.cf_col) >= 0 && this.cf_col <= d.length && String(d[this.cf_col]).length > 0) {
                    t.cf = d[this.cf_col];
                }

                if (!isNaN(this.cod_pr_col) && parseInt(this.cod_pr_col) >= 0 && this.cod_pr_col <= d.length && String(d[this.cod_pr_col]).length > 0) {
                    t.cod_pr = d[this.cod_pr_col];
                }

                if (!isNaN(this.pod_col) && parseInt(this.pod_col) >= 0 && this.pod_col <= d.length && String(d[this.pod_col]).length > 0) {
                    t.pod = d[this.pod_col];
                }

                if (!isNaN(this.pdr_col) && parseInt(this.pdr_col) >= 0 && this.pdr_col <= d.length && String(d[this.pdr_col]).length > 0) {
                    t.pdr = d[this.pdr_col];
                }

                if (!isNaN(this.campagna_col) && parseInt(this.campagna_col) >= 0 && this.campagna_col <= d.length && String(d[this.campagna_col]).length > 0) {
                    t.campagna = d[this.campagna_col];
                }

                if (!isNaN(this.note_col) && parseInt(this.note_col) >= 0 && this.note_col <= d.length && String(d[this.note_col]).length > 0) {
                    t.note = d[this.note_col];
                }

                if (!isNaN(this.stato_col) && parseInt(this.stato_col) >= 0 && this.stato_col <= d.length && String(d[this.stato_col]).length > 0) {
                    t.stato = d[this.stato_col];
                }

                sendData.push(t);
            }

            var _this = this;

            axios.post(this.sendDataUrl, {verifyData: sendData}, {responseType: 'blob'})
                .then(function (response) {

                    let filename = "check_fatturazione.xlsx";

                    if ("headers" in response && "content-disposition" in response["headers"]) {
                        filename = response["headers"]["content-disposition"]
                            .replace(/ /g, "")
                            .replace("attachment;", "")
                            .replace("filename=", "")
                            .replace(/"/g, "");
                    }

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', filename); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    _this.sendCallbackFn();
                    _this.closeParserModal();
                })
                .catch(error => {

                    let fr = new FileReader();

                    fr.onload = function () {

                        let results = JSON.parse(this.result);
                        let responseError = {};

                        if ("errors" in results) {
                            responseError = results.errors;
                        }

                        let errorKeys = Object.keys(responseError);

                        if (errorKeys.length) {
                            var keys = Object.keys(responseError);
                            var rows = [];
                            for (let key of keys) {
                                let ksplit = key.split(".");
                                if (ksplit.length == 3 && ksplit[0] == "verifyData") {
                                    let rowNum = parseInt(ksplit[1]) + (_this.csvConfig.skipFirstLine ? 2 : 1);
                                    if (ksplit[2] == "stato") {
                                        _this.sendDataErrors.push("Riga (" + rowNum + ") - Lo stato deve essere un numero intero");
                                    } else if (rows.indexOf(rowNum) == -1) {
                                        rows.push(rowNum);
                                    }
                                }
                            }

                            if (rows.length) {
                                var msg = "POD e PDR mancanti alle righe: [ " + rows.join(", ") + " ]";
                                _this.sendDataErrors.push(msg);
                            }

                        } else {
                            _this.sendDataErrors.push("Il file csv contiene degli errori")
                        }


                    };

                    fr.readAsText(error.response.data);


                });

        },
        canSend() {
            return this.cf_col >= 0 || this.pdr_col >= 0 || this.pod_col >= 0 || this.cod_pr_col >= 0;
        },
        resetModal() {
            this.currentSelectedFilepath = '';
            this.currentSelectedFileBlob = '';
            this.formStep = 1;
            this.readData = [];
            this.cod_pr_col = '-1';
            this.cf_col = '-1';
            this.pdr_col = '-1';
            this.pod_col = '-1';
            this.campagna_col = '-1';
            this.note_col = '-1';
            this.stato_col = '-1';
            this.csvErrors = false;
        },
        notAssigned(value) {
            return this.cod_pr_col != value
                && this.cf_col != value
                && this.pod_col != value
                && this.pdr_col != value
                && this.note_col != value
                && this.campagna_col != value
                && this.stato_col != value;
        },
        step1() {
            this.formStep = 1;
        },
        step2() {
            this.formStep = 2;
        },
        fileChanged(event, b, c, d) {
            this.currentSelectedFilepath = event.target.value;
            this.currentSelectedFileBlob = event.target.files.length > 0 ? event.target.files[0] : '';
            this.csvErrors = false;
        },
        openParserModal() {
            this.$modal.show('import-file');
        },
        closeParserModal() {
            this.$modal.hide('import-file');
        },
        onParserSubmitImport() {
            if (this.mode == "csv") {
                this.readCsv();
            } else if (this.mode == "xlsx") {
                this.readExcel();
            }
        },
        readExcel() {
            if (this.currentSelectedFilepath.length == 0) return;
            var reader = new FileReader();
            var _this = this;
            reader.onload = function (e) {
                let data = e.target.result;
                let fixedData = _this.fixdata(data);
                let workbook = XLSX.read(btoa(fixedData), {type: 'base64'});
                let firstSheetName = workbook.SheetNames[0];
                let worksheet = workbook.Sheets[firstSheetName];
                let results = XLSX.utils.sheet_to_json(worksheet);
            }
            reader.readAsArrayBuffer(this.currentSelectedFileBlob);
        },

        get_header_row(sheet) {
            var headers = [], range = XLSX.utils.decode_range(sheet['!ref']);
            var C, R = range.s.r; /* start in the first row */
            for (C = range.s.c; C <= range.e.c; ++C) { /* walk every column in the range */
                var cell = sheet[XLSX.utils.encode_cell({c: C, r: R})] /* find the cell in the first row */
                var hdr = "UNKNOWN " + C; // <-- replace with your desired default
                if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);
                headers.push(hdr);
            }
            return headers;
        },
        fixdata(data) {
            var o = "", l = 0, w = 10240;
            for (; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
            o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
            return o;
        },
        readCsv() {
            PapaParse.parse(this.currentSelectedFileBlob, this.csvConfig);
        },
        onCsvReadComplete(results) {
            this.csvErrors = false;
            if (results.errors.length > 0) {
                this.csvErrors = true;
                //console.log(results.errors);
                return;
            }

            let data = results.data;
            if (this.csvConfig.skipFirstLine) {
                data.splice(0, 1);
            }
            this.readData = data;
            //console.log(this.readData);
            this.step2();
        }
    }
}

</script>
