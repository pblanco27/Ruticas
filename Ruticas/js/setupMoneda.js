var divisaActual = document.getElementById("divisa").checked;
$.getJSON(
    // NB: using Open Exchange Rates here, but you can use any source!
    'https://openexchangerates.org/api/latest.json?app_id=d25fb2be91354e7b9dde0cbd2df33c8e',
    function(data) {
        // Check money.js has finished loading:
        if (typeof fx !== "undefined" && fx.rates) {
            fx.rates = data.rates;
            fx.base = data.base;
        } else {
            // If not, apply to fxSetup global:
            var fxSetup = {
                rates: data.rates,
                base: data.base
            }
        }
    }
);