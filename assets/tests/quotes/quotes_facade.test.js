import {QuotesFacade} from "../../quotes/quotes_facade.js";
import {QuotesPresenterInput} from "../../quotes/quotes_presenter_input.js";
import {QuotesPresenterOutput} from "../../quotes/quotes_presenter_output.js";

describe('for wrong input return errors', () => {

    test('no any input', () => {
        // GIVEN
        let quotes = new QuotesFacade();
        let input = new QuotesPresenterInput();
        let expectedOutput = new QuotesPresenterOutput();

        // WHEN, THEN
        expectedOutput.status = 'NOK'
        expectedOutput.errors = {
            companySymbol: ['Company symbol can\'t be blank'],
            startDate: ['Start date can\'t be blank'],
            endDate: ['End date can\'t be blank'],
            email: ['Email can\'t be blank']
        }
        expect(quotes.fetch(input)).toEqual(expectedOutput);
    })

    test('invalid format', () => {
        // GIVEN
        let quotes = new QuotesFacade();
        let input = new QuotesPresenterInput();
        input.companySymbol = 'AAIT'
        input.startDate = 'a'
        input.endDate = 'b'
        input.email = 'c'

        // WHEN, THEN
        let expectedOutput = new QuotesPresenterOutput();
        expectedOutput.status = 'NOK'
        expectedOutput.errors = {
            startDate: ['Start date accepted date format is YYYY-MM-DD.'],
            endDate: ['End date accepted date format is YYYY-MM-DD.'],
            email: ['Email is not a valid email address.']
        }
        expect(quotes.fetch(input)).toEqual(expectedOutput);
    })
})