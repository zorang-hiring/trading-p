import {QuotesPresenterOutput} from "./quotes_presenter_output.js";

export class QuotesFacade {
    fetch() {

        let output = new QuotesPresenterOutput();
        output.status = 'NOK';
        output.errors = {
            companySymbol: ['This value should not be blank.'],
            startDate: ['This value should not be blank.'],
            endDate: ['This value should not be blank.'],
            email: ['This value should not be blank.']
        };
        return output;
    }
}