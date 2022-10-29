import {QuotesPresenterOutput} from "./quotes_presenter_output.js";
import {QuoteInputValidator} from "./quotes_validator/quotes_input_validator.js";
import {QuoteFetcherService} from "./quotes_fetcher_service";

export class QuotesFacade {

    /**
     * @param {QuotesPresenterInput} presenterInput
     * @returns {QuotesPresenterOutput}
     */
    fetch(presenterInput) {

        let output = new QuotesPresenterOutput();
        const validator = new QuoteInputValidator();

        const errors = validator.validate(presenterInput)
        if (errors) {
            output.status = 'NOK';
            output.errors = errors
        }

        const fatcher = new QuoteFetcherService();
        // todo await
        fatcher.fetch(presenterInput);

        return output;
    }
}