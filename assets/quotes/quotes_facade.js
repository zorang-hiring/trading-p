import {QuotesPresenterOutput} from "./quotes_presenter_output.js";
import validate from "validate.js";
import moment from "moment";

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

export class QuotesFacade {

    /**
     * @param {QuotesPresenterInput} presenterInput
     * @returns {QuotesPresenterOutput}
     */
    fetch(presenterInput) {

        let output = new QuotesPresenterOutput();

        let constrains = {
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
                }
            },
            endDate: {
                presence: {
                    allowEmpty: false
                },
                datetime: {
                    dateOnly: true,
                    message: "accepted date format is YYYY-MM-DD."
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

        const errors = validate.validate(presenterInput, constrains)
        if (errors) {
            output.status = 'NOK';
            output.errors = errors
        }

        return output;
    }
}