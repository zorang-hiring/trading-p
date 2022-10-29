import axios from "axios";
import {QuotesPresenterOutput} from "./quotes_presenter_output";

export class QuoteFetcherService {
    /**
     * @param {QuotesPresenterInput} input
     * @returns {Promise<void>}
     */
    fetch(input) {
        axios.get('api/company-quotes', {
            params: {
                companySymbol: input.companySymbol,
                startDate: input.startDate,
                endDate: input.endDate,
                email: input.email
            },
            headers: {'Content-Type': 'application/json'}
        })
            .then(function (response) {
                // handle success
                console.log('success', response);
            })
            .catch(function (error) {
                const response = error.response;
                if (response.status !== 400) {
                    throw error
                }
                let result = new QuotesPresenterOutput();
                result.status = response.data.status
                result.message = response.data.message
                result.errors = response.data.errors
                console.log('error', result);
            })
            .then(function () {
                // todo
                console.log('done');
            });
    }
}