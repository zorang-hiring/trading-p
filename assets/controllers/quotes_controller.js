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

        // BUSINESS LOGIC

        // build input
        let input = new QuotesPresenterInput();
        input.companySymbol = this.company_symbolTarget.value;
        input.startDate = this.start_dateTarget.value;
        input.endDate = this.end_dateTarget.value;
        input.email = this.emailTarget.value;

        let handler = new QuotesFacade()

        this.disableForm()
        let output = await handler.fetch(input)
        this.enableForm()

        if (output.status !== 'OK') {
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

        // if not valid
            // show errors
        // else
            // continue

        // draw table
        // draw chart
    }
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
function fillTableData(output) {
    let tBodyHtml = '';
    output.data.forEach(item => {
        tBodyHtml += generateTableRowView(item)
    })
    this.tableBodyTarget.innerHTML = tBodyHtml;
}

/**
 * @param {QuotesPresenterOutput} output
 */
function fillData(output) {
    fillTableData.call(this, output);
    // build chart
}

function showNoData() {
    this.tableBodyTarget.innerHTML = '';
}

function generateTableRowView(rowData)
{
    return '<tr>' +
        '<td>' + rowData.date + '</td>' +
        '<td>' + rowData.open + '</td>' +
        '<td>' + rowData.high + '</td>' +
        '<td>' + rowData.low + '</td>' +
        '<td>' + rowData.close + '</td>' +
        '<td>' + rowData.volume + '</td>' +
        '</tr>';
}
