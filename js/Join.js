const paymentRadios = document.getElementsByName('paymentMethodes');
const creditCard = document.getElementById('creditCardFields');
const paypal = document.getElementById('paypalFields');
const cash = document.getElementById('cashFields');

paymentRadios.forEach(radio => {
    radio.addEventListener('change', handlePaymentChange);
});




function handlePaymentChange() {
    const radio = this;
    console.log(radio.value);
    if (radio.checked) {
        if (radio.value === 'creditCard') {
            creditCard.style.display = 'block';
            paypal.style.display = 'none';
            cash.style.display = 'none';
        } else if (radio.value === 'paypal') {
            creditCard.style.display = 'none';
            paypal.style.display = 'block';
            cash.style.display = 'none';
        } else if (radio.value === 'cash') {
            creditCard.style.display = 'none';
            paypal.style.display = 'none';
            cash.style.display = 'block';
        }
    }else {
        creditCard.style.display = 'none';
        paypal.style.display = 'none';
        cash.style.display = 'none';
    }
};