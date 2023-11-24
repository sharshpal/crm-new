import { BaseUpload } from 'craftable';

Vue.component('media-upload', {
    mixins: [BaseUpload],

    props: {
        thumbnailHeight: {
            type: Number,
            default: 200
        },
        thumbnailWidth: {
            type: Number,
            default: 200
        },
        showRemoveLink: {
            type: Boolean,
            default: false
        },
        clickable: {
            type: [Boolean, String],
            default: false
        },

        language: {
            type: Object,
            default: function () {
                return {
                    dictDefaultMessage: '<br> Trascina qui i file da caricare',
                    dictCancelUpload: 'Annulla',
                    dictCancelUploadConfirmation: 'Are you sure you want to cancel this upload?',
                    dictFallbackMessage: 'Your browser does not support drag and drop file uploads.',
                    dictFallbackText: 'Please use the fallback form below to upload your files like in the olden days.',
                    dictFileTooBig: 'File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.',
                    dictInvalidFileType: `You can't upload files of this type.`,
                    dictMaxFilesExceeded: 'You can not upload any more files. (max: {{maxFiles}})',
                    dictRemoveFile: 'Rimuovi',
                    dictRemoveFileConfirmation: null,
                    dictResponseError: 'Server responded with {{statusCode}} code.',
                }
            }
        },
    },
    template: '<dropzone :id="collection" \n  :clickable="clickable"   :show-remove-link="showRemoveLink"  :language="language"               :url="url" \n                       v-bind:preview-template="template"\n                       v-on:vdropzone-success="onSuccess"\n                       v-on:vdropzone-error="onUploadError"\n                       v-on:vdropzone-removed-file="onFileDelete"\n                       v-on:vdropzone-file-added="onFileAdded"\n                       :useFontAwesome="true" \n                       :ref="collection"\n                       :maxNumberOfFiles="maxNumberOfFiles"\n                       :maxFileSizeInMB="maxFileSizeInMb"\n                       :acceptedFileTypes="acceptedFileTypes"\n                       :thumbnailWidth="thumbnailWidth"\n                       :headers="headers">\n                \n                <input type="hidden" name="collection" :value="collection">\n            </dropzone>',
    data: function data() {
        return {

        }
    },
    mounted () {

    },
    methods:{

        template: function template() {
            return '\n              <div class="dz-preview dz-file-preview">\n                  <div class="dz-image custom">\n                      <img data-dz-thumbnail />\n                  </div>\n                  <div class="dz-details">\n                    <div class="dz-size"><span data-dz-size></span></div>\n                    <div class="dz-filename"></div>\n                  </div>\n                  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n                  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n                  <div class="dz-success-mark"><i class="fa fa-check"></i></div>\n                  <div class="dz-error-mark"><i class="fa fa-close"></i></div>\n              </div>\n          ';
        }
    }
});
