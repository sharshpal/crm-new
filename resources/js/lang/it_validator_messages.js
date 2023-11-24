export default {

    _default: function (field) {
        return ("Il campo " + field + " non è valido");
    },
    after: function (field, ref) {
        var target = ref[0];
        var inclusion = ref[1];

        return ("Il campo dev'essere dopo di " + (inclusion ? 'o uguale a ' : '') + target);
    },
    alpha: function (field) {
        return ("Il campo può contenere solo lettere");
    },
    alpha_dash: function (field) {
        return ("Il campo può contenere solo caratteri alfanumerici (includendo trattini e underscore)");
    },
    alpha_num: function (field) {
        return ("Il campo può contenere solo lettere e numeri");
    },
    alpha_spaces: function (field) {
        return ("Il campo può contenere solo lettere e spazi");
    },
    before: function (field, ref) {
        var target = ref[0];
        var inclusion = ref[1];

        return ("Il campo dev'essere prima di " + (inclusion ? 'o uguale a ' : '') + target);
    },
    between: function (field, ref) {
        var min = ref[0];
        var max = ref[1];

        return ("The " + field + " field must be between " + min + " and " + max);
    },
    confirmed: function (field) {
        return ("Il campo non corrisponde con l'altro");
    },
    credit_card: function (field) {
        return ("The " + field + " field is invalid");
    },
    date_between: function (field, ref) {
        var min = ref[0];
        var max = ref[1];

        return ("La data dev'essere compresa tra " + min + " e " + max);
    },
    date_format: function (field, ref) {
        var format = ref[0];

        return ("La data dev'essere nel formato " + format);
    },
    decimal: function (field, ref) {
        if (ref === void 0) ref = [];
        var decimals = ref[0];
        if (decimals === void 0) decimals = '*';

        return ("Il campo " + field + " deve essere un numero - Usare il punto (.) in caso di decimali " + (!decimals || decimals === '*' ? '' : ' (max: ' + decimals+' cifre decimali)'));
    },
    digits: function (field, ref) {
        var length = ref[0];

        return ("The " + field + " field must be numeric and contains exactly " + length + " digits");
    },
    dimensions: function (field, ref) {
        var width = ref[0];
        var height = ref[1];

        return ("The " + field + " field must be " + width + " pixels by " + height + " pixels");
    },
    email: function (field) {
        return ("Inserire un indirizzo email valido");
    },
    excluded: function (field) {
        return ("The " + field + " field must be a valid value");
    },
    ext: function (field) {
        return ("The " + field + " field must be a valid file");
    },
    image: function (field) {
        return ("The " + field + " field must be an image");
    },
    included: function (field) {
        return ("The " + field + " field must be a valid value");
    },
    integer: function (field) {
        return ("Il campo dev'essere un numero intero");
    },
    ip: function (field) {
        return ("The " + field + " field must be a valid ip address");
    },
    ip_or_fqdn: function (field) {
        return ("The " + field + " field must be a valid ip address or FQDN");
    },
    length: function (field, ref) {
        var length = ref[0];
        var max = ref[1];

        if (max) {
            return ("La lunghezza dev'essere compresa tra " + length + " e " + max);
        }

        return ("La lunghezza dev'essere: " + length);
    },
    max: function (field, ref) {
        var length = ref[0];

        return ("Il campo non può essere più lungo di " + length + " caratteri");
    },
    max_value: function (field, ref) {
        var max = ref[0];
        return ("Il campo non può essere superiore a " + max);
        //return ("The " + field + " field must be " + max + " or less");
    },
    mimes: function (field) {
        return ("Il tipo file non è valido");
    },
    min: function (field, ref) {
        var length = ref[0];

        return ("Il campo dev'essere lungo almeno " + length + " caratteri");
    },
    min_value: function (field, ref) {
        var min = ref[0];
        return ("Il campo non può essere inferiore a " + min);
        //return ("The " + field + " field must be " + min + " or more");
    },
    numeric: function (field) {
        return ("Il campo può contenere solo numeri");
        //return ("The " + field + " field may only contain numeric characters");
    },
    regex: function (field) {
        if(field == 'password') {
            return ("La password dev'essere lunga almeno 8 caratteri e contenere sia numeri che lettere.");
        }
        return ("Il formato non è valido");
    },
    required: function (field) {
        return ("Il campo è obbligatorio");
    },
    required_if: function (field, ref) {
        var target = ref[0];

        return ("Il campo è richiesto quando il campo " + target + " ha questo valore");
    },
    size: function (field, ref) {
        var size = ref[0];

        return ("La grandezza dev'essere inferiore a " + (formatFileSize(size)));
    },
    url: function (field) {
        return ("Inserisci un URL valido");
    }

};
