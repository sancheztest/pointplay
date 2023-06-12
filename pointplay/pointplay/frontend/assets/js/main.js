const operations = ['+', '-'];
const values = [1, 3, 5];
const types = ['Points', 'Coupons'];

const optionSpan = document.getElementById('op');
const valueSpan = document.getElementById('value');
const typeSpan = document.getElementById('type');

const spinButton = document.getElementById('spin-button');

const cardContainer = document.getElementById("card-container");

const poinst = document.getElementById("points");
const coupons = document.getElementById("coupons");

const paymentButtons = document.querySelectorAll('.buy-button');

let packageId;
function openStripeCheckout(name, description, amount, id) {
    // Abre el formulario de pago de Stripe
    packageId = id
    handler.open({ 
        name: name,
        description: description,
        amount: amount,
    });
}

var handler = StripeCheckout.configure({
    key: 'pk_test_51NGVeZADGAueO9snDyMmSoCN5hjhpJnsKosLd1IVJ6MU6H4WlnoAHDiSjUA1W2cbCF8Y8KzduY5qqIGAT0z0PTFX00PV7JcuCC',
    locale: 'auto',
    token: function (token) {
        buyCoupons(packageId, token);
    }
});


// function processPayment(packageId) {

//     var handler = StripeCheckout.configure({
//         key: 'pk_test_51NGVeZADGAueO9snDyMmSoCN5hjhpJnsKosLd1IVJ6MU6H4WlnoAHDiSjUA1W2cbCF8Y8KzduY5qqIGAT0z0PTFX00PV7JcuCC',
//         locale: 'auto',
//         token: function (token) {
//             buyCoupons(packageId, token);
//         }
//     });

//     return function (e) {
//         // Obtén los datos específicos del botón de pago
//         var name = this.getAttribute('data-name');
//         var description = this.getAttribute('data-description');
//         var amount = parseInt(this.getAttribute('data-amount'));

//         // Abre el formulario de pago de Stripe
//         handler.open({
//             name: name,
//             description: description,
//             amount: amount
//         });

//         e.preventDefault();
//     };
// }

const getUserBalance = () => {
    fetch("http://localhost/pointplay/api/user_balance", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: {}
    })
        .then(res => res.json())
        .then(data => {
            poinst.textContent = data.points;
            coupons.textContent = data.coupons;
        })
        .catch(err => console.log(`Error: ${err}`));
}
const getPurchasePlans = () => {
    fetch("http://localhost/pointplay/api/purchase_plans", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: {}
    })
        .then(res => res.json())
        .then(data => {
            /*
            <div class="card">
                <h3>Plan 1</h3>
                <p>Costo: 50 puntos</p>
                <button class="buy-button" data-cost="50" data-amount="10">Comprar</button>
            </div>
            */
            cardContainer.innerHTML = "";
            data.forEach((p, i) => {
                const card = document.createElement('div');
                card.classList.add("card");

                const title = document.createElement("h3");
                title.textContent = `Package ${i + 1}`;

                const price = document.createElement("p");
                price.textContent = `Price: ${p.price}`;

                const amount = document.createElement("p");
                amount.textContent = `Amount: ${p.amount}`;

                const btn = document.createElement('button');
                btn.classList.add("buy-button");
                btn.textContent = "Buy Package";

                btn.setAttribute("data-name", `Package ${p.id}`);
                btn.setAttribute("data-ampunt", p.price);
                btn.setAttribute("data-description", `Buy Package ${p.id}`);

                btn.addEventListener('click', () => {
                    openStripeCheckout(`Package ${p.id}`, `Buy Coupons Package ${p.id}`, p.price*100, p.id);
                });

                card.appendChild(title);
                card.appendChild(price);
                card.appendChild(amount);
                card.appendChild(btn);

                cardContainer.appendChild(card);

            });
        })
        .catch(err => console.log(`Error: ${err}`));
}
const buyCoupons = (id, token) => {
    fetch("http://localhost/pointplay/api/buy", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id: id,
            token: token
        })
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        })
        .catch(err => console.log(`Error: ${err}`));
}
const spendCoupons = () => {
    fetch("http://localhost/pointplay/api/spend", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: {}
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            const option = data.option;

            const operation = option["operation"];
            const value = option["amount"];
            const type = option["type"];

            spinReels(operation, value, type);
        })
        .catch(err => console.log(`Error: ${err}`));
}
function spinReels(op, value, type) {
    spinButton.disabled = true;

    let spinCount = 0;
    const maxSpinCount = 20;

    const spinInterval = setInterval(() => {
        const randomOp = operations[Math.floor(Math.random() * operations.length)];
        const randomValue = values[Math.floor(Math.random() * values.length)];
        const randomType = types[Math.floor(Math.random() * types.length)];

        optionSpan.textContent = randomOp;
        valueSpan.textContent = randomValue;
        typeSpan.textContent = randomType;

        spinCount++;

        if (spinCount === maxSpinCount) {
            optionSpan.textContent = op;
            valueSpan.textContent = value;
            typeSpan.textContent = type;

            clearInterval(spinInterval);
            spinButton.disabled = false; // Habilitar el botón después del giro
            load();
        }
    }, 100);
}

const load = () => {
    getUserBalance();
    getPurchasePlans();
}

// Cierra el formulario de pago de Stripe cuando el usuario hace clic fuera del formulario
window.addEventListener('popstate', function () {
    handler.close();
});

spinButton.addEventListener('click', spendCoupons);
window.addEventListener('load', load)
