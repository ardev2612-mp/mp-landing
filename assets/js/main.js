
AOS.init({
    duration: 1000,
    once: true,
    offset: 100
});



// Set Default Language
window.onload = () => changeLang('id');

function changeLang(lang) {
    const allContent = document.querySelectorAll('[lang-content]');
    const btnId = document.getElementById('btn-id');
    const btnEn = document.getElementById('btn-en');
    const navLinks = document.querySelectorAll('[data-id]');

    // Switch content display
    allContent.forEach(el => {
        if (el.getAttribute('lang-content') === lang) {
            el.classList.add('active-lang');
        } else {
            el.classList.remove('active-lang');
        }
    });

    // Update Navigation Text
    navLinks.forEach(link => {
        const idLabels = {
            'nav-features': 'Fitur',
            'nav-why': 'Mengapa Kami',
            'nav-tutorial': 'Tutorial',
            'nav-pricing': 'Harga'
        };
        link.innerText = (lang === 'en') ? link.getAttribute('data-en') : idLabels[link.getAttribute('data-id')];
    });

    // Update Button Styling
    if (lang === 'id') {
        btnId.classList.add('bg-white', 'shadow-sm', 'text-blue-600', 'border', 'border-slate-200');
        btnEn.classList.remove('bg-white', 'shadow-sm', 'text-blue-600', 'border', 'border-slate-200');
        btnEn.classList.add('text-slate-500');
        document.documentElement.lang = "id";
    } else {
        btnEn.classList.add('bg-white', 'shadow-sm', 'text-blue-600', 'border', 'border-slate-200');
        btnId.classList.remove('bg-white', 'shadow-sm', 'text-blue-600', 'border', 'border-slate-200');
        btnId.classList.add('text-slate-500');
        document.documentElement.lang = "en";
    }

    // Sync Billing Labels with current language
    const isActiveYearly = document.getElementById('btn-yearly').classList.contains('active');
    setBilling(isActiveYearly ? 'yearly' : 'monthly');
}

function setBilling(type) {
    const btnMonthly = document.getElementById('btn-monthly');
    const btnYearly = document.getElementById('btn-yearly');
    const prices = document.querySelectorAll('.price-val');
    const labels = document.querySelectorAll('.billing-label');
    const currentLang = document.documentElement.lang;

    if (type === 'monthly') {
        btnMonthly.classList.add('active');
        btnMonthly.classList.remove('inactive');
        btnYearly.classList.add('inactive');
        btnYearly.classList.remove('active');

        prices.forEach(p => p.innerText = p.getAttribute('data-monthly'));
        labels.forEach(l => l.innerText = currentLang === 'id' ? '/bulan' : '/month');
    } else {
        btnYearly.classList.add('active');
        btnYearly.classList.remove('inactive');
        btnMonthly.classList.add('inactive');
        btnMonthly.classList.remove('active');

        prices.forEach(p => p.innerText = p.getAttribute('data-yearly'));
        labels.forEach(l => l.innerText = currentLang === 'id' ? '/tahun (dibayar tahunan)' : '/year (billed annually)');
    }
}



document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookie-banner');
    const btnAccept = document.getElementById('cookie-accept');
    const btnReject = document.getElementById('cookie-reject');

    if (!banner) return;

    // Cek status cookie
    const consent = localStorage.getItem('cookie_consent');
    if (!consent) {
        banner.classList.remove('hidden');
    }

    // Terima cookie
    btnAccept.addEventListener('click', function () {
        localStorage.setItem('cookie_consent', 'accepted');
        banner.classList.add('hidden');
    });

    // Tolak cookie
    btnReject.addEventListener('click', function () {
        localStorage.setItem('cookie_consent', 'rejected');
        banner.classList.add('hidden');
    });
});

