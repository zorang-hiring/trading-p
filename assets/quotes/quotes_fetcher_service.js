import axios from "axios";
import {QuotesPresenterOutput} from "./quotes_presenter_output";

export class QuoteFetcherService {
    /**
     * @param {QuotesPresenterInput} input
     * @returns {Promise<unknown>} QuotesPresenterOutput
     */
    async fetch(input) {
        try {
            const response = await getCompanyQuotesFromApi(input)
            console.log('fetcher service success', response);
            return buildPresenterOutput(response.data);
        } catch (error) {
            console.log('fetcher service error', error);
            if (!error.response || error.response.status !== 400 || !error.response.data) {
                console.warn('Unexpected exception triggered')
                throw error
            }
            return buildPresenterOutput(error.response.data)
        }
    }
}

function buildPresenterOutput(responseData) {
    let result = new QuotesPresenterOutput();
    result.status = responseData.status
    result.message = responseData.message
    result.errors = responseData.errors
    result.data = responseData.data
    return result;
}

function getCompanyQuotesFromApi(input) {
    return axios.get('api/company-quotes', {
        params: {
            companySymbol: input.companySymbol,
            startDate: input.startDate,
            endDate: input.endDate,
            email: input.email
        },
        headers: {'Content-Type': 'application/json'}
    });
}