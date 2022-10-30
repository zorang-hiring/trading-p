import { Controller } from '@hotwired/stimulus';
import {QuotesPresenterInput} from "../quotes/quotes_presenter_input.js";
import {QuotesFacade} from "../quotes/quotes_facade.js";
import {ChartGenerator} from "../quotes/quotes_clart";
import {Chart} from "chart.js";
import 'jquery-ui-bundle';
import 'jquery-ui-bundle/jquery-ui.css';
import $ from 'jquery';

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
        "submitSpinner",
        "submitText",
        "data",
        "tableBody",
        "chart",
        "noDataNotification",
    ]

    STYLE_CLASS_HIDE = 'style-hidden';

    /**
     * @type {Chart}
     */
    chart = undefined;

    connect() {
        this.initDateElements()
    }

    /**
     * Main method to submit the form
     */
    async fetch() {

        this.clearFormValidationErrors()
        hideNoDataNotification.call(this)

        this.disableForm()
        let output = await (new QuotesFacade()).fetch(buildInput.call(this))
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

        fillDataAndShow.call(this, output)
    }

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

    getSubmitButtonSpinner() {
        return this.submitSpinnerTarget;
    }

    getSubmitButtonText() {
        return this.submitTextTarget;
    }

    getChartDomElement() {
        return this.chartTarget;
    }

    getDataDomElement() {
        return this.dataTarget;
    }

    getNoDataNotificationDomElement() {
        return this.noDataNotificationTarget;
    }

    initDateElements() {
        const options = {dateFormat: "yy-mm-dd", maxDate: 0};
        $('#start_date').datepicker(options)
        $('#end_date').datepicker(options)
    }

    disableForm() {
        this.getSubmitButton().disabled = "disabled"
        this.getSubmitButtonSpinner().classList.remove(this.STYLE_CLASS_HIDE);
        this.getSubmitButtonText().textContent = 'Loading...'
    }

    enableForm() {
        this.getSubmitButton().disabled = false
        this.getSubmitButtonSpinner().classList.add(this.STYLE_CLASS_HIDE);
        this.getSubmitButtonText().textContent = 'Get'
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

    const formatError = function (dataArray) {
        return dataArray ? dataArray.join('. ') : ''
    }

    this.company_symbol_errorTarget.textContent = formatError(output.errors.companySymbol);
    this.start_date_errorTarget.textContent = formatError(output.errors.startDate);
    this.end_date_errorTarget.textContent = formatError(output.errors.endDate);
    this.email_errorTarget.textContent = formatError(output.errors.email);
}

/**
 * @param {QuotesPresenterOutput} output
 */
function fillDataAndShow(output) {
    hideNoDataNotification.call(this)
    this.getDataDomElement().classList.remove(this.STYLE_CLASS_HIDE)
    fillChart.call(this, output)
    fillTableData.call(this, output);
}

/**
 * @param {QuotesPresenterOutput} output
 */
function fillChart(output) {
    if (this.chart) {
        this.chart.destroy()
    }
    this.chart = (new ChartGenerator()).generate(this.getChartDomElement(), output);
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
    return '<tr scope="row">' +
        '<td>' + item.dateFormatted() + '</td>' +
        '<td>' + item.openFormatted() + '</td>' +
        '<td>' + item.highFormatted() + '</td>' +
        '<td>' + item.lowFormatted() + '</td>' +
        '<td>' + item.closeFormatted() + '</td>' +
        '<td>' + item.volumeFormatted() + '</td>' +
        '</tr>';
}

function showNoData() {
    showNoDataNotification.call(this)
    this.getDataDomElement().classList.add(this.STYLE_CLASS_HIDE)
    if (this.chart) {
        this.chart.destroy();
    }
    this.tableBodyTarget.innerHTML = '';
}

function showNoDataNotification()
{
    this.getNoDataNotificationDomElement().classList.remove(this.STYLE_CLASS_HIDE)
}
function hideNoDataNotification()
{
    this.getNoDataNotificationDomElement().classList.add(this.STYLE_CLASS_HIDE)
}
