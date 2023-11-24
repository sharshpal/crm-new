import {BaseForm} from 'craftable';
import Utility from '../Utility';

export default {
    mixins: [BaseForm, Utility],
    methods: {
        onSubmit: function onSubmit() {
            var _this4 = this;

            return this.$validator.validateAll().then(function (result) {

                console.log(_this4.$validator.errors);


                var msg = "<div class='mb-2'>Il form contiene degli errori!</div>";
                if (_this4.$validator.errors && _this4.$validator.errors.items) {
                    msg += "<br/>";
                    for (let item of _this4.$validator.errors.items) {
                        var fname = item.field
                            .replace("owner_az","dati_azienda")
                            .replace("owner","intestatario")
                            .replace("dob","data_nascita")
                            .replace("pob","luogo_nascita")
                            .replace(/_/g, " ");
                        msg += "<div><span class='text-capitalize'>[" + fname + "]: " + item.msg + "</div>";
                    }
                }


                if (!result) {
                    _this4.$notify({
                        type: 'error',
                        title: 'Errore!',
                        text: msg
                    });
                    return false;
                }

                var data = _this4.form;
                if (!_this4.sendEmptyLocales) {
                    data = _.omit(_this4.form, _this4.locales.filter(function (locale) {
                        return _.isEmpty(_this4.form[locale]);
                    }));
                }

                _this4.submiting = true;

                axios.post(_this4.action, _this4.getPostData()).then(function (response) {
                    return _this4.onSuccess(response.data);
                }).catch(function (errors) {
                    return _this4.onFail(errors.response.data);
                });
            });
        },
    }
};
