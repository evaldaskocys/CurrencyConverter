'use strict';

/*global Routing */

function clearResultData() {
    $('#result span').html('');
}

function calculate(){
    clearResultData();
    $.ajax({
        type: 'POST',
        url: Routing.generate('convertCurrency'),
        data: {
            date: $('#converter_date').val(),
            amount: $('#converter_amount').val(),
            currencySell: $('#converter_sellCurrency').val(),
            currencyBuy: $('#converter_buyCurrency').val()
        }
    })
        .success(function( data ) {
            if (data.valid) {
                $('#result>#money').html(data.amount);
                $('#result>#currencyCode').html(data.currency);
            } else {
                $('#result>#message').html(data.message);
            }
        });
}

function disableEnter(e){
    var code = e.keyCode || e.which;
    if (code === 13) {
        e.preventDefault();
        return false;
    }
}

function replaceLetters(){
    var amount_input = $('#converter_amount');
    var amount = amount_input.val();
    if (isNaN(amount)) {
        amount = amount.replace(/[^\d.]/g, '');
        while (isNaN(amount)) {
            amount = amount.slice(0, -1);
        }
        amount_input.val(amount);
    } else {
        if (amount < 0) {
            amount = amount.replace(/[^\d.]/g, '');
            amount_input.val(amount);
        }
    }
}

function swapCurrencies(){
    var valueSell = $('#converter_sellCurrency').val();
    $('#converter_sellCurrency').val($('#converter_buyCurrency').val());
    $('#converter_buyCurrency').val(valueSell);
    calculate();
}

$( document ).ready(function() {

    $('.calculate-select').change(function() {
        calculate();
    });
    $('#swapCurrencies').click(function() {
        swapCurrencies();
    });
    $('.disable-enter').on('keydown', function(e) {
        disableEnter(e);
    });
    $('.allow-numbers').on('keyup', function() {
        replaceLetters();
        calculate();
    });
    $('.allow-numbers').bind({
        paste: function () {
            replaceLetters();
            calculate();
        }
    });
});