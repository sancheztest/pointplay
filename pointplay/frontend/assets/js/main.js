const points = document.getElementById('points');
const coupons = document.getElementById('coupons');
const coupons_prices = document.getElementById('coupons_prices');

const getInfo = () => {
    fetch("http://localhost/pointplay/api/game")
        .then(res => res.json())
        .then(data => {
            points.textContent = data['points'];
            coupons.textContent = data['coupons'];
        })
        .catch(err => console.log(err));
}

const getCouponsPrice = () => {
    fetch("http://localhost/pointplay/api/coupons/get", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: {}
    })
        .then(res => res.json())
        .then(data => {


            data.forEach(c => {
                const card = document.createElement('div');
                card.className = "card"
                const div = document.createElement('div');

                const price = document.createElement('p');
                price.textContent = `Price: ${c.price}`;

                const amount = document.createElement('p');
                amount.textContent = `Amount: ${c.amount}`;

                const btn = document.createElement('button');
                btn.textContent = "Buy";
                btn.style.width = '100%';

                div.appendChild(price);
                div.appendChild(amount);
                div.appendChild(btn);

                card.appendChild(div);
                coupons_prices.appendChild(card);

                btn.addEventListener('click', () => { buyCoupons(c.id) })
            });

        })
        .catch(err => console.log(err));
}

const spendCoupon = () => {
    fetch("http://localhost/pointplay/api/game", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: {

        }
    })
        .then(res => res.json())
        .then(data => {
            points.textContent = data['points'];
            coupons.textContent = data['coupons'];
        })
        .catch(err => console.log(err));
}

const buyCoupons = (id) => {
    fetch("http://localhost/pointplay/api/coupons/buy", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: { id: Number(id) }
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            getInfo();
        })
        .catch(err => console.log(err));
}

window.addEventListener('load', () => {
    getInfo();
    getCouponsPrice();
})