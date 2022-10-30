import moment from "moment/moment";

export class QuotesPresenterOutput {
    status = undefined
    errors = []
    /**
     * @type {Array.<QuotePresenterOutputDataItem>}
     */
    data = []

    isEmptyData() {
        return (this.data.length === 0)
    }

    /**
     * @returns {boolean}
     */
    isNotOk() {
        return (this.status !== 'OK')
    }
}

export class QuotePresenterOutputDataItem {
    date = undefined
    open = undefined
    high = undefined
    low = undefined
    close = undefined
    volume = undefined
    dateFormatted() {
        return moment.unix(this.date).format('L')
    }
    openFormatted() {
        return this.open.toFixed(2).toLocaleString()
    }
    highFormatted() {
        return this.high.toFixed(2).toLocaleString()
    }
    lowFormatted() {
        return this.low.toFixed(2).toLocaleString()
    }
    closeFormatted() {
        return this.close.toFixed(2).toLocaleString()
    }
    volumeFormatted() {
        return this.volume.toLocaleString()
    }
}