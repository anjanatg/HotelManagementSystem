document.addEventListener('DOMContentLoaded', function () {

    const contentWrapper = document.querySelector('.content-wrapper');

    if (!contentWrapper) return;

    const fullReloadPaths = [
        '/users/list',
    ];

    function bindSidebarLinks() {
        document.querySelectorAll('.nav-sidebar a.nav-link').forEach(function (link) {

            const href = link.getAttribute('href');

            if (!href || href === '#' || link.classList.contains('ajax-bound')) {
                return;
            }


            if (fullReloadPaths.some(p => href.indexOf(p) !== -1)) {
                return;
            }

            link.classList.add('ajax-bound');

            link.addEventListener('click', function (e) {
                e.preventDefault();
                loadContent(href);

                // update active state
                document.querySelectorAll('.nav-sidebar .nav-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                window.history.pushState({ ajaxUrl: href }, '', href);
            });
        });
    }

    function loadContent(url) {
        contentWrapper.style.opacity = '0.5';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.querySelector('.content-wrapper');

            if (newContent) {
                contentWrapper.innerHTML = newContent.innerHTML;
            } else {
                contentWrapper.innerHTML = html;
            }

            contentWrapper.style.opacity = '1';

            bindSidebarLinks();
            bindFormSubmits();
        })
        .catch(() => {
            contentWrapper.style.opacity = '1';
            alert('Failed to load page.');
        });
    }

    window.addEventListener('popstate', function (e) {
        if (e.state && e.state.ajaxUrl) {
            loadContent(e.state.ajaxUrl);
        }
    });

    function bindFormSubmits() {
        contentWrapper.querySelectorAll('form').forEach(function (form) {
            if (form.classList.contains('ajax-bound')) return;

            const action = form.getAttribute('action');
            if (!action || form.hasAttribute('data-no-ajax-nav')) {
                return;
            }

            form.classList.add('ajax-bound');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const method = form.querySelector('input[name="_method"]')
                    ? form.querySelector('input[name="_method"]').value
                    : form.getAttribute('method');

                fetch(action, {
                    method: 'POST', 
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.content-wrapper');

                    if (newContent) {
                        contentWrapper.innerHTML = newContent.innerHTML;
                    } else {
                        contentWrapper.innerHTML = html;
                    }

                    bindSidebarLinks();
                    bindFormSubmits();
                })
                .catch(() => alert('Action failed.'));
            });
        });
    }

    bindSidebarLinks();
    bindFormSubmits();
});