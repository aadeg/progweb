function nextElementSibling(el){
    var rv = el.nextSibling;
    if (rv) return rv.nextSibling;
    return null;
}

function hasClass(el, cl){
    return el.classList.contains(cl);
}
