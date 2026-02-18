document.addEventListener('DOMContentLoaded', () => {

    /* AOS */
    if (window.AOS) {
        AOS.init({ duration: 1000, once: true, offset: 100 });
    }

    /* LANGUAGE */
    const langButtons = document.querySelectorAll('[data-lang-btn]');
    const langContents = document.querySelectorAll('[lang-content]');
    const navLinks = document.querySelectorAll('.nav-link');

    function changeLang(lang) {
        langContents.forEach(el => {
            el.classList.toggle('active-lang', el.getAttribute('lang-content') === lang);
        });

        navLinks.forEach(link => {
            link.innerText = lang === 'en' ? link.dataset.en : link.dataset.idLabel;
        });

        langButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.langBtn === lang);
        });

        document.documentElement.lang = lang;
        localStorage.setItem('site_lang', lang);
        syncBillingLabel();
    }

    langButtons.forEach(btn => {
        btn.addEventListener('click', () => changeLang(btn.dataset.langBtn));
    });

    /* BILLING */
    const billingButtons = document.querySelectorAll('[data-billing]');
    const prices = document.querySelectorAll('.price-val');
    const labels = document.querySelectorAll('.billing-label');

    function setBilling(type) {
        billingButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.billing === type);
            btn.classList.toggle('inactive', btn.dataset.billing !== type);
        });

        prices.forEach(p => p.innerText = p.dataset[type]);
        localStorage.setItem('billing_type', type);
        syncBillingLabel();
    }

    function syncBillingLabel() {
        const lang = document.documentElement.lang;
        const billing = localStorage.getItem('billing_type') || 'monthly';

        labels.forEach(label => {
            label.innerText =
                billing === 'monthly'
                    ? (lang === 'id' ? '/bulan' : '/month')
                    : (lang === 'id' ? '/tahun (dibayar tahunan)' : '/year (billed annually)');
        });
    }

    billingButtons.forEach(btn => {
        btn.addEventListener('click', () => setBilling(btn.dataset.billing));
    });

    /* COOKIE */
    const banner = document.getElementById('cookie-banner');
    const accept = document.getElementById('cookie-accept');
    const reject = document.getElementById('cookie-reject');

    if (!localStorage.getItem('cookie_consent')) {
        banner.classList.remove('hidden');
    }

    accept.onclick = () => {
        localStorage.setItem('cookie_consent', 'accepted');
        banner.classList.add('hidden');
    };

    reject.onclick = () => {
        localStorage.setItem('cookie_consent', 'rejected');
        banner.classList.add('hidden');
    };

    /* INIT */
    changeLang(localStorage.getItem('site_lang') || 'id');
    setBilling(localStorage.getItem('billing_type') || 'monthly');

});
