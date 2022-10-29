export class QuotesPresenterOutput {
    status = undefined
    errors = []
    data = []
    isEmptyData() {
        if (this.data.length === 0) {
            return true;
        }
        return false;
    }
}