<script>

    function getCookie(name) {
        const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
        return match ? decodeURIComponent(match[2]) : null;
    }

    function setCookie(name, value, days = 30) {
        const expires = new Date();
        expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires.toUTCString()}; path=/`;
    }

    function getOrSetLang(defaultLang = 'en') {
        let lang = getCookie('lang');

        if (!lang) {
            lang = defaultLang;
            setCookie('lang', lang, 30);
        }

        return lang;
    }

    const userLang = getOrSetLang();
    const body = document.getElementById('app');
    body.setAttribute('lang', userLang);
    body.setAttribute('dir', userLang === 'en' ? 'ltr' : 'rtl');

    window.core = {
        APP_URL: '{{env('APP_URL')}}',
        enJson: {!! json_encode($enJson) !!},
        arJson: {!! json_encode($arJson) !!},
        lang: getOrSetLang(),
    };

    document.addEventListener('DOMContentLoaded', () => {
        const preloader = document.querySelector('#preloader');
        const app = document.querySelector('#app');
        app.classList.add('hidden');
        preloader.classList.add('flex');
        window.addEventListener('load', () => {
            preloader.classList.replace('flex', 'hidden');
            app.classList.remove('hidden');
        });
    });

</script>
