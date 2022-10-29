import { Controller } from '@hotwired/stimulus';
import {QuotesPresenterInput} from "../quotes/quotes_presenter_input.js";
import {QuotesFacade} from "../quotes/quotes_facade.js";

export default class QuotesController extends Controller {
    static targets = [
        "company_symbol",
        "start_date",
        "end_date",
        "email",
        "company_symbol_error",
        "start_date_error",
        "end_date_error",
        "email_error",
        "submit",
        "tableBody"
    ]

    clearFormValidationErrors()
    {
        this.company_symbol_errorTarget.textContent = '';
        this.start_date_errorTarget.textContent = '';
        this.end_date_errorTarget.textContent = '';
        this.email_errorTarget.textContent = '';
    }

    getSubmitButton() {
        return this.submitTarget;
    }

    disableForm() {
        let button = this.getSubmitButton();
        button.disabled = "disabled"
        button.textContent = 'Please Wait ...'
    }

    enableForm() {
        let button = this.getSubmitButton();
        button.disabled = false
        button.textContent = 'Submit'
    }

    async fetch() {

        // todo prevent flooding

        // build input
        let input = buildInput.call(this);

        let handler = new QuotesFacade()

        this.disableForm()
        let output = await handler.fetch(input)
        this.enableForm()

        if (output.isNotOk()) {
            showValidationErrors.call(this, output);
            showNoData.call(this)
            return;
        }

        this.clearFormValidationErrors()

        if (output.isEmptyData()) {
            showNoData.call(this)
            return;
        }

        fillData.call(this, output)
    }
}

/**
 * @returns {QuotesPresenterInput}
 */
function buildInput() {
    let input = new QuotesPresenterInput();
    input.companySymbol = this.company_symbolTarget.value;
    input.startDate = this.start_dateTarget.value;
    input.endDate = this.end_dateTarget.value;
    input.email = this.emailTarget.value;
    return input;
}

/**
 * @param {QuotesPresenterOutput} output
 */
function showValidationErrors(output) {
    this.company_symbol_errorTarget.textContent = output.errors.companySymbol;
    this.start_date_errorTarget.textContent = output.errors.startDate;
    this.end_date_errorTarget.textContent = output.errors.endDate;
    this.email_errorTarget.textContent = output.errors.email;
}

/**
 * @param {QuotesPresenterOutput} output
 */
function fillData(output) {
    fillTableData.call(this, output);
    // build chart
}

/**
 * @param {QuotesPresenterOutput} output
 */
function fillTableData(output) {
    let tBodyHtml = '';
    output.data.forEach(item => {
        tBodyHtml += generateTableRowView(item)
    })
    this.tableBodyTarget.innerHTML = tBodyHtml;
}

/**
 *
 * @param {QuotePresenterOutputDataItem} item
 * @returns {string}
 */
function generateTableRowView(item)
{
    return '<tr>' +
        '<td>' + item.dateFormatted() + '</td>' +
        '<td>' + item.openFormatted() + '</td>' +
        '<td>' + item.highFormatted() + '</td>' +
        '<td>' + item.lowFormatted() + '</td>' +
        '<td>' + item.closeFormatted() + '</td>' +
        '<td>' + item.volumeFormatted() + '</td>' +
        '</tr>';
}

function showNoData() {
    this.tableBodyTarget.innerHTML = '';
}
