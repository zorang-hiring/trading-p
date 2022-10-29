import {QuotesPresenterOutput} from "./quotes_presenter_output.js";
import {QuoteInputValidator} from "./quotes_validator/quotes_input_validator.js";
import {QuoteFetcherService} from "./quotes_fetcher_service";

/**
 * Contains Client side validator and Server side validator and data fetcher
 */
export class QuotesFacade {

    /**
     * @param {QuotesPresenterInput} presenterInput
     * @returns {Promise<QuotesPresenterOutput>}
     */
    async fetch(presenterInput) {

        // client side validator
        const validator = new QuoteInputValidator();
        const errors = validator.validate(presenterInput)
        if (errors) {
            return new Promise((resolve, reject) => {
                let output = new QuotesPresenterOutput();
                output.status = 'NOK';
                output.errors = errors
                reject(output)
            })
        }

        // server side validator and fetcher
        const fetcher = new QuoteFetcherService();
        return fetcher.fetch(presenterInput);
    }
}