'use strict';

var _vue = require('vue');

var _vue2 = _interopRequireDefault(_vue);

import { BaseForm } from 'craftable';

var _BaseForm2 = _interopRequireDefault(BaseForm);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
import Utility from '../app-components/Utility';

_vue2.default.component('auth-form', {
    mixins: [_BaseForm2.default, Utility],
    mounted(){
        this.clearAllLists();
    }
});
