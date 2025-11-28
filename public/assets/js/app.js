(() => {
    const body = document.documentElement;
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const storedTheme = localStorage.getItem('theme');
    const theme = storedTheme || (prefersDark ? 'dark' : 'light');
    setTheme(theme);

    const toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.addEventListener('click', () => {
            const next = body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            setTheme(next);
        });
    }

    function setTheme(value) {
        body.setAttribute('data-theme', value);
        localStorage.setItem('theme', value);
    }

    // Popup hide for 30 minutes
    const popup = document.getElementById('promoPopup');
    if (popup) {
        const ttl = parseInt(popup.dataset.ttl || '1800', 10) * 1000;
        const hiddenUntil = parseInt(localStorage.getItem('popup_hidden_until') || '0', 10);
        if (Date.now() < hiddenUntil) {
            popup.remove();
        } else {
            popup.querySelector('[data-close]').addEventListener('click', () => {
                localStorage.setItem('popup_hidden_until', Date.now() + ttl);
                popup.remove();
            });
        }
    }

    // Variant price fetch
    const optionInputs = document.querySelectorAll('.option-btn, .option-input');
    if (optionInputs.length) {
        optionInputs.forEach((el) => {
            el.addEventListener('click', handleOptionSelect);
            el.addEventListener('change', handleOptionSelect);
        });
    }

    function handleOptionSelect(event) {
        const target = event.currentTarget;
        const form = target.closest('form');
        if (!form) return;
        if (target.classList.contains('option-btn')) {
            target.classList.toggle('active');
        }
        debounceVariantLookup(form);
    }

    let variantTimer;
    function debounceVariantLookup(form) {
        clearTimeout(variantTimer);
        variantTimer = setTimeout(() => fetchVariant(form), 300);
    }

    function fetchVariant(form) {
        const productId = form.dataset.product;
        const optionIds = Array.from(form.querySelectorAll('.option-btn.active, .option-input'))
            .map((el) => {
                if (el.classList.contains('option-btn')) return el.dataset.value;
                return el.value;
            })
            .filter(Boolean);

        if (!productId || !optionIds.length) return;

        fetch('/variants/price', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({product_id: productId, 'options[]': optionIds}),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    document.getElementById('priceDisplay').textContent = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(data.price);
                    document.getElementById('variantIdField').value = data.variant_id;
                }
            });
    }
})();

