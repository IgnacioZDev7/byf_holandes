(function() {
    function removePreloader() {
        var pre = document.querySelector('.preloader');
        if (pre && pre.parentNode) {
            pre.style.display = 'none';
            pre.parentNode.removeChild(pre);
        }
        document.body.classList.remove('hold-transition');
    }
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        removePreloader();
    } else {
        document.addEventListener('DOMContentLoaded', removePreloader);
    }
})();
