/**
 * Post Loop 2 — AJAX pagination.
 *
 * Fetches the target page, takes the same Post Loop 2 element out of it and swaps it in.
 * Works without any server endpoint, so the result is always identical to a normal page load.
 * Links stay real <a href> links: without JS (or if a request fails) they just navigate.
 */
(function () {
    if (window.bdoxcePostLoop2) return;

    var cache = new Map();

    function fetchDoc(url) {
        if (!cache.has(url)) {
            var request = fetch(url, { credentials: 'same-origin', headers: { 'X-Requested-With': 'bdoxcePostLoop2' } })
                .then(function (r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.text();
                })
                .then(function (html) {
                    return new DOMParser().parseFromString(html, 'text/html');
                })
                .catch(function (err) {
                    cache.delete(url);
                    throw err;
                });
            cache.set(url, request);
        }
        return cache.get(url);
    }

    function closestLoop(node) {
        return node && node.closest ? node.closest('.bdoxce-post-loop-2') : null;
    }

    function setBusy(loop, busy) {
        loop.classList.toggle('is-pl2-loading', busy);
        loop.setAttribute('aria-busy', busy ? 'true' : 'false');
        loop.querySelectorAll('.bdoxce-pl2-items').forEach(function (items) {
            if (busy) {
                items.style.minHeight = items.offsetHeight + 'px';
                items.style.position = 'relative';
            } else {
                items.style.minHeight = '';
                items.style.position = '';
            }
        });
    }

    function scrollToLoop(loop) {
        var offset = loop.getAttribute('data-pl2-scroll');
        if (offset === null || offset === '') return;
        var top = loop.getBoundingClientRect().top + window.pageYOffset - (parseInt(offset, 10) || 0);
        if (top < window.pageYOffset) {
            var smooth = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            window.scrollTo({ top: top, behavior: smooth ? 'smooth' : 'auto' });
        }
    }

    function focusItems(loop) {
        var items = loop.querySelector('.bdoxce-pl2-items');
        if (!items) return;
        if (!items.hasAttribute('tabindex')) items.setAttribute('tabindex', '-1');
        items.focus({ preventScroll: true });
    }

    function announce(loop, doc) {
        loop.dispatchEvent(new CustomEvent('bdoxce:post-loop-2:loaded', { bubbles: true, detail: { loop: loop, doc: doc } }));
    }

    /** Replace the whole loop with the same loop from page `url`. */
    function goTo(loop, url, push) {
        var selector = loop.__pl2Selector;
        setBusy(loop, true);

        fetchDoc(url)
            .then(function (doc) {
                var fresh = doc.querySelector(selector);
                if (!fresh) throw new Error('Post Loop 2 not found on ' + url);

                loop.innerHTML = fresh.innerHTML;
                setBusy(loop, false);

                if (push && loop.getAttribute('data-pl2-url') !== '0') {
                    history.pushState({ pl2: selector }, '', url);
                }

                scrollToLoop(loop);
                focusItems(loop);
                announce(loop, doc);
            })
            .catch(function () {
                window.location.href = url;
            });
    }

    /** Append the next page's items and swap in the next page's pagination. */
    function loadMore(loop, url, button) {
        var selector = loop.__pl2Selector;
        var label = button.textContent;

        button.classList.add('is-loading');
        button.setAttribute('aria-busy', 'true');
        button.textContent = button.getAttribute('data-loading-text') || 'Loading…';

        fetchDoc(url)
            .then(function (doc) {
                var fresh = doc.querySelector(selector);
                if (!fresh) throw new Error('Post Loop 2 not found on ' + url);

                var items = loop.querySelector('.bdoxce-pl2-items');
                var freshItems = fresh.querySelector('.bdoxce-pl2-items');
                var firstNew = null;

                if (items && freshItems) {
                    var fragment = document.createDocumentFragment();
                    Array.prototype.slice.call(freshItems.childNodes).forEach(function (node) {
                        var imported = document.importNode(node, true);
                        if (!firstNew && imported.nodeType === 1) firstNew = imported;
                        fragment.appendChild(imported);
                    });
                    items.appendChild(fragment);
                }

                var pagination = button.closest('.bdoxce-pl2-pagination');
                var freshPagination = pagination && pagination.className
                    ? fresh.querySelector('.' + pagination.className.trim().split(/\s+/).join('.'))
                    : null;

                if (pagination) {
                    if (freshPagination) pagination.replaceWith(document.importNode(freshPagination, true));
                    else pagination.remove();
                }

                // Move keyboard focus to the first newly loaded item.
                if (firstNew) {
                    var focusTarget = firstNew.matches('a, button') ? firstNew : firstNew.querySelector('a, button');
                    if (focusTarget) focusTarget.focus({ preventScroll: true });
                }

                announce(loop, doc);
            })
            .catch(function () {
                window.location.href = url;
            })
            .finally(function () {
                button.classList.remove('is-loading');
                button.removeAttribute('aria-busy');
                button.textContent = label;
            });
    }

    function paginationLink(event, loop) {
        var link = event.target.closest && event.target.closest('a[href]');
        if (!link) return null;
        var pagination = link.closest('.bdoxce-pl2-pagination');
        if (!pagination || closestLoop(pagination) !== loop) return null;
        return link;
    }

    function bind(loop, selector) {
        if (loop.__pl2Bound) return;
        loop.__pl2Bound = true;
        loop.__pl2Selector = selector;

        loop.addEventListener('click', function (event) {
            if (loop.getAttribute('data-pl2-ajax') !== '1') return;
            if (event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;

            var link = paginationLink(event, loop);
            if (!link || link.getAttribute('aria-disabled') === 'true') return;

            event.preventDefault();

            if (link.hasAttribute('data-pl2-loadmore')) {
                loadMore(loop, link.href, link);
            } else {
                goTo(loop, link.href, true);
            }
        });

        function prefetch(event) {
            if (loop.getAttribute('data-pl2-ajax') !== '1' || loop.getAttribute('data-pl2-prefetch') !== '1') return;
            var link = paginationLink(event, loop);
            if (link && link.getAttribute('aria-disabled') !== 'true') fetchDoc(link.href).catch(function () {});
        }

        loop.addEventListener('mouseover', prefetch);
        loop.addEventListener('focusin', prefetch);
        loop.addEventListener('touchstart', prefetch, { passive: true });
    }

    window.addEventListener('popstate', function (event) {
        var selector = event.state && event.state.pl2;
        var loop = selector && document.querySelector(selector);
        if (loop) goTo(loop, window.location.href, false);
    });

    window.bdoxcePostLoop2 = {
        init: function (selector) {
            document.querySelectorAll(selector).forEach(function (loop) {
                bind(loop, selector);
            });

            if (!history.state || !history.state.pl2) {
                history.replaceState(Object.assign({}, history.state, { pl2: selector }), '', window.location.href);
            }
        }
    };
})();
