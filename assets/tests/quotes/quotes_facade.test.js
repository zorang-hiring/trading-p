import {QuotesFacade} from "../../quotes/quotes_facade.js";
import {QuotesPresenterInput} from "../../quotes/quotes_presenter_input.js";
import {QuotesPresenterOutput} from "../../quotes/quotes_presenter_output.js";


test('if request quotes without params return frontend validation errors', () => {
    let quotes = new QuotesFacade();
    let input =  new QuotesPresenterInput();
    let expectedOutput =  new QuotesPresenterOutput();
    expectedOutput.status = 'NOK'
    expectedOutput.errors = {
        companySymbol: ['This value should not be blank.'],
        startDate: ['This value should not be blank.'],
        endDate: ['This value should not be blank.'],
        email: ['This value should not be blank.']
    }
    expect(quotes.fetch(input)).toEqual(expectedOutput);
})