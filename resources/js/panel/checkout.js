// This is a public sample test API key.
// Don’t submit any personally identifiable information in requests made with this key.
// Sign in to see your own test API key embedded in code samples.
const stripe = Stripe("pk_live_51Kb2gjEbcoWyHKN3l3NEia0arCA6pLIL4dspFYvGRltsWwAkjNNiv0xgGVodJm4Hlb7UF6bw4k7rkW2RWNucaVnA001522CUBO");

// The items the customer wants to buy
const items = [{id: "xl-tshirt"}];

let elements;

document
    .querySelector("#payment-form")
    .addEventListener("submit", handleSubmit);

let emailAddress = '';

// Fetches a payment intent and captures the client secret
async function initialize() {
    setLoading(true);
    const price = document.getElementById("priceCard");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const {clientSecret} = await fetch("/painel/adicionar-saldo/stripe", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
            "price": price.value
        }),
    }).then((r) => r.json());

    elements = stripe.elements({clientSecret});

    const linkAuthenticationElement = elements.create("linkAuthentication");
    linkAuthenticationElement.mount("#link-authentication-element");

    const paymentElementOptions = {
        layout: "tabs",
    };

    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");
    setLoading(false);
}

async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    const {error} = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: "https://" + window.location.hostname + "/painel/adicionar-saldo/sucess-payment-sripe/",
            receipt_email: emailAddress,
        },
    });

    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
    } else {
        showMessage("An unexpected error occurred.");
    }

    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const {paymentIntent} = await stripe.retrievePaymentIntent(clientSecret);

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("Payment succeeded!");
            break;
        case "processing":
            showMessage("Your payment is processing.");
            break;
        case "requires_payment_method":
            showMessage("Your payment was not successful, please try again.");
            break;
        default:
            showMessage("Something went wrong.");
            break;
    }
}

// ------- UI helpers -------

function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("d-none");
    messageContainer.textContent = messageText;
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("d-none");
        document.querySelector("#button-text").classList.add("d-none");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("d-none");
        document.querySelector("#button-text").classList.remove("d-none");
    }
}
