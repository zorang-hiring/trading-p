import { Controller } from '@hotwired/stimulus';
import {QuotesPresenterInput} from "../quotes/quotes_presenter_input.js";
import {QuotesFacade} from "../quotes/quotes_facade.js";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = [ "company_symbol", "start_date", "end_date", "email", "tmp_output" ]

    // connect() {
    //     this.element.textContent = 'Hello Stimulus!3';
    // }

    fetch() {

        // todo prevent flooding

        // BUSINESS LOGIC

        // pass input
        let input = new QuotesPresenterInput();
        input.companySymbol = this.company_symbolTarget.value;
        input.startDate = this.start_dateTarget.value;
        input.endDate = this.end_dateTarget.value;
        input.email = this.emailTarget.value;

        let service = new QuotesFacade()
        let output = service.fetch(input)

        if (output.status === 'NOK') {
            // show errors
            this.company_symbol_errorTarget.textContent = output.errors.companySymbol;
            this.start_date_errorTarget.textContent = output.errors.startDate;
            this.end_date_errorTarget.textContent = output.errors.endDate;
            this.email_errorTarget.textContent = output.errors.email;
            return;
        }

        // validate
            // validate FE
               // if valid
                   // request BE
               // else
                   // continue

        // PRESENTATION LOGIC

        // if not valid
            // show errors
        // else
            // continue

        // draw table
        // draw chart

        this.tmp_outputTarget.textContent =
            `${this.company_symbolTarget.value} ${this.start_dateTarget.value} ${this.end_dateTarget.value} ${this.emailTarget.value}`
    }
}
