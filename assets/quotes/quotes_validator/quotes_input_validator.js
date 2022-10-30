import validate from "validate.js";

import {quotesInputConstrains} from "./quote_input_constrains.js";

export class QuoteInputValidator {
    /**
     * @param {QuotesPresenterInput} presenterInput
     * @returns {any} Errors if any
     */
    validate(presenterInput) {
        return validate.validate(presenterInput, quotesInputConstrains)
    }
}