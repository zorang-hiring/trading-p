import validate from "validate.js";
import moment from "moment/moment.js";

export const quotesInputConstrains = {
    companySymbol: {
        presence: {
            allowEmpty: false
        },
    },
    startDate: {
        presence: {
            allowEmpty: false
        },
        datetime: {
            dateOnly: true,
            message: "accepted date format is YYYY-MM-DD."
        },
        lessOrEqualThanDate: {
            compareToField: "endDate",
            message: 'has to be less or equal then end date'
        }
    },
    endDate: {
        presence: {
            allowEmpty: false
        },
        datetime: {
            dateOnly: true,
            message: "accepted date format is YYYY-MM-DD."
        },
        greaterOrEqualThanDate: {
            compareToField: "startDate",
            message: 'has to be greater or equal then start date'
        }
    },
    email: {
        presence: {
            allowEmpty: false
        },
        email: {
            message: "is not a valid email address."
        }
    }
}

validate.validators.lessOrEqualThanDate = function(value, options, key, attributes) {
    value = moment(value, 'YYYY-MM-DD', true)
    const compareTo = moment(attributes[options.compareToField], 'YYYY-MM-DD', true)
    if (!value.isValid() || !compareTo.isValid()) {
        return;
    }
    if (parseInt(value.format("YYYYMMDD")) > parseInt(compareTo.format("YYYYMMDD"))) {
        return options.message || 'has to be less or equal then ' + options.compareToField;
    }
};

validate.validators.greaterOrEqualThanDate = function(value, options, key, attributes) {
    value = moment(value, 'YYYY-MM-DD', true)
    const compareTo = moment(attributes[options.compareToField], 'YYYY-MM-DD', true)
    if (!value.isValid() || !compareTo.isValid()) {
        return;
    }
    if (parseInt(value.format("YYYYMMDD")) < parseInt(compareTo.format("YYYYMMDD"))) {
        return options.message || 'has to be greater or equal then ' + options.compareToField;
    }
};

validate.extend(validate.validators.datetime, {
    // The value is guaranteed not to be null or undefined but otherwise it
    // could be anything.
    parse: function(value, options) {
        // return moment.utc(value);
        return moment(value, 'YYYY-MM-DD');
    },
    // Input is a unix timestamp
    format: function(value, options) {
        let format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
        // return moment.utc(value).format(format);
        return moment(value).format(format);
    }
});