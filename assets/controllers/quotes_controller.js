import { Controller } from '@hotwired/stimulus';
import {QuotesPresenterInput} from "../quotes/quotes_presenter_input.js";
import {QuotesFacade} from "../quotes/quotes_facade.js";

export default class extends Controller {
    static targets = [
        "company_symbol",
        "start_date",
        "end_date",
        "email",
        "company_symbol_error",
        "start_date_error",
        "end_date_error",
        "email_error",
        "submit"
    ]

    // connect() {
    //     this.element.textContent = 'Hello Stimulus!3';
    // }

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
            return;
        }

        this.clearFormValidationErrors()


        // PRESENTATION LOGIC

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
