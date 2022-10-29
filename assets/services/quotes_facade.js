export class QuotesFacade {
    fetch() {
        return {
            status: 'NOK',
            message: 'Invalid Request',
            errors: {
                companySymbol: ['This value should not be blank.'],
                startDate: ['This value should not be blank.'],
                endDate: ['This value should not be blank.'],
                email: ['This value should not be blank.']
            }
        };
    }
}