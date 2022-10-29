import {QuotesFacade} from "../../services/quotes_facade.js";

test('if request quotes without params return frontend validation errors', () => {
    let quotes = new QuotesFacade();
    expect(quotes.fetch()).toEqual({
        status: 'NOK',
        message: 'Invalid Request',
        errors: {
            companySymbol: ['This value should not be blank.'],
            startDate: ['This value should not be blank.'],
            endDate: ['This value should not be blank.'],
            email: ['This value should not be blank.']
        }
    });
});