import { Controller } from '@hotwired/stimulus';

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
