import {QuotesPresenterOutput} from "./quotes_presenter_output.js";
import {QuoteInputValidator} from "./quotes_validator/quotes_input_validator.js";

export class QuotesFacade {

    /**
     * @param {QuotesPresenterInput} presenterInput
     * @returns {QuotesPresenterOutput}
     */
    fetch(presenterInput) {

        let output = new QuotesPresenterOutput();
        var validator = new QuoteInputValidator();

        const errors = validator.validate(presenterInput)
        if (errors) {
            output.status = 'NOK';
            output.errors = errors
        }

        return output;
    }
}