!function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : e.Sweetalert2 = t()
}
(this, function () {
    "use strict";
    var e = {title: "", titleText: "", text: "", html: "", type: null,
        customClass: "",
        target: "body",
        animation: !0, allowOutsideClick: !0, allowEscapeKey: !0, allowEnterKey: !0, showConfirmButton: !0, showCancelButton: !1, preConfirm: null, confirmButtonText: "OK", confirmButtonAriaLabel: "", confirmButtonColor: "#3085d6", confirmButtonClass: null, cancelButtonText: "Cancel", cancelButtonAriaLabel: "", cancelButtonColor: "#aaa", cancelButtonClass: null, buttonsStyling: !0, reverseButtons: !1, focusConfirm: !0, focusCancel: !1, showCloseButton: !1, closeButtonAriaLabel: "Close this dialog", showLoaderOnConfirm: !1, imageUrl: null, imageWidth: null, imageHeight: null, imageAlt: "", imageClass: null, timer: null, width: 500, padding: 20, background: "#fff", input: null, inputPlaceholder: "", inputValue: "", inputOptions: {}, inputAutoTrim: !0, inputClass: null, inputAttributes: {}, inputValidator: null, progressSteps: [], currentProgressStep: null, progressStepsDistance: "40px", onOpen: null, onClose: null, useRejections: !0}, t = function (e) {
        var t = {};
        for (var n in e)
            t[e[n]] = "swal2-" + e[n];
        return t
    }, n = t(["container", "shown", "iosfix", "modal", "overlay", "fade", "show", "hide", "noanimation", "close", "title", "content", "buttonswrapper", "confirm", "cancel", "icon", "image", "input", "file", "range", "select", "radio", "checkbox", "textarea", "inputerror", "validationerror", "progresssteps", "activeprogressstep", "progresscircle", "progressline", "loading", "styled"]), o = t(["success", "warning", "info", "question", "error"]), r = function (e, t) {
        (e = String(e).replace(/[^0-9a-f]/gi, "")).length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]), t = t || 0;
        for (var n = "#", o = 0; o < 3; o++) {
            var r = parseInt(e.substr(2 * o, 2), 16);
            n += ("00" + (r = Math.round(Math.min(Math.max(0, r + r * t), 255)).toString(16))).substr(r.length)
        }
        return n
    }, i = function (e) {
        var t = [];
        for (var n in e)
            -1 === t.indexOf(e[n]) && t.push(e[n]);
        return t
    }, a = {previousWindowKeyDown: null, previousActiveElement: null, previousBodyPadding: null}, l = function (e) {
        var t = u();
        t && t.parentNode.removeChild(t);
        {
            if ("undefined" != typeof document) {
                var o = document.createElement("div");
                o.className = n.container, o.innerHTML = s, ("string" == typeof e.target ? document.querySelector(e.target) : e.target).appendChild(o);
                var r = c(), i = E(r, n.input), a = E(r, n.file), l = r.querySelector("." + n.range + " input"), d = r.querySelector("." + n.range + " output"), p = E(r, n.select), f = r.querySelector("." + n.checkbox + " input"), m = E(r, n.textarea);
                return i.oninput = function () {
                    Y.resetValidationError()
                }, i.onkeydown = function (t) {
                    setTimeout(function () {
                        13 === t.keyCode && e.allowEnterKey && (t.stopPropagation(), Y.clickConfirm())
                    }, 0)
                }, a.onchange = function () {
                    Y.resetValidationError()
                }, l.oninput = function () {
                    Y.resetValidationError(), d.value = l.value
                }, l.onchange = function () {
                    Y.resetValidationError(), l.previousSibling.value = l.value
                }, p.onchange = function () {
                    Y.resetValidationError()
                }, f.onchange = function () {
                    Y.resetValidationError()
                }, m.oninput = function () {
                    Y.resetValidationError()
                }, r
            }
            console.error("SweetAlert2 requires document to initialize")
        }
    }, s = ('\n <div role="dialog" aria-labelledby="' + n.title + '" aria-describedby="' + n.content + '" class="' + n.modal + '" tabindex="-1">\n   <ul class="' + n.progresssteps + '"></ul>\n   <div class="' + n.icon + " " + o.error + '">\n     <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span>\n   </div>\n   <div class="' + n.icon + " " + o.question + '">?</div>\n   <div class="' + n.icon + " " + o.warning + '">!</div>\n   <div class="' + n.icon + " " + o.info + '">i</div>\n   <div class="' + n.icon + " " + o.success + '">\n     <div class="swal2-success-circular-line-left"></div>\n     <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n     <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n     <div class="swal2-success-circular-line-right"></div>\n   </div>\n   <img class="' + n.image + '" />\n   <h2 class="' + n.title + '" id="' + n.title + '"></h2>\n   <div id="' + n.content + '" class="' + n.content + '"></div>\n   <input class="' + n.input + '" />\n   <input type="file" class="' + n.file + '" />\n   <div class="' + n.range + '">\n     <output></output>\n     <input type="range" />\n   </div>\n   <select class="' + n.select + '"></select>\n   <div class="' + n.radio + '"></div>\n   <label for="' + n.checkbox + '" class="' + n.checkbox + '">\n     <input type="checkbox" />\n   </label>\n   <textarea class="' + n.textarea + '"></textarea>\n   <div class="' + n.validationerror + '" id="' + n.validationerror + '"></div>\n   <div class="' + n.buttonswrapper + '">\n     <button type="button" class="' + n.confirm + '">OK</button>\n     <button type="button" class="' + n.cancel + '">Cancel</button>\n   </div>\n   <button type="button" class="' + n.close + '">×</button>\n </div>\n').replace(/(^|\n)\s*/g, ""), u = function () {
        return document.body.querySelector("." + n.container)
    }, c = function () {
        return u() ? u().querySelector("." + n.modal) : null
    }, d = function () {
        return c().querySelectorAll("." + n.icon)
    }, p = function (e) {
        return u() ? u().querySelector("." + e) : null
    }, f = function () {
        return p(n.title)
    }, m = function () {
        return p(n.content)
    }, v = function () {
        return p(n.image)
    }, h = function () {
        return p(n.buttonswrapper)
    }, b = function () {
        return p(n.progresssteps)
    }, y = function () {
        return p(n.validationerror)
    }, g = function () {
        return p(n.confirm)
    }, w = function () {
        return p(n.cancel)
    }, C = function () {
        return p(n.close)
    }, x = function () {
        var e = Array.from(c().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function (e, t) {
            return e = parseInt(e.getAttribute("tabindex")), t = parseInt(t.getAttribute("tabindex")), e > t ? 1 : e < t ? -1 : 0
        }), t = Array.prototype.slice.call(c().querySelectorAll('button, input:not([type=hidden]), textarea, select, a, [tabindex="0"]'));
        return i(e.concat(t))
    }, k = function (e, t) {
        return!!e.classList && e.classList.contains(t)
    }, S = function (e) {
        if (e.focus(), "file" !== e.type) {
            var t = e.value;
            e.value = "", e.value = t
        }
    }, A = function (e, t) {
        e && t && t.split(/\s+/).filter(Boolean).forEach(function (t) {
            e.classList.add(t)
        })
    }, B = function (e, t) {
        e && t && t.split(/\s+/).filter(Boolean).forEach(function (t) {
            e.classList.remove(t)
        })
    }, E = function (e, t) {
        for (var n = 0; n < e.childNodes.length; n++)
            if (k(e.childNodes[n], t))
                return e.childNodes[n]
    }, P = function (e, t) {
        t || (t = "block"), e.style.opacity = "", e.style.display = t
    }, L = function (e) {
        e.style.opacity = "", e.style.display = "none"
    }, T = function (e) {
        for (; e.firstChild; )
            e.removeChild(e.firstChild)
    }, q = function (e) {
        return e.offsetWidth || e.offsetHeight || e.getClientRects().length
    }, V = function (e, t) {
        e.style.removeProperty ? e.style.removeProperty(t) : e.style.removeAttribute(t)
    }, M = function () {
        var e = document.createElement("div"), t = {WebkitAnimation: "webkitAnimationEnd", OAnimation: "oAnimationEnd oanimationend", animation: "animationend"};
        for (var n in t)
            if (t.hasOwnProperty(n) && void 0 !== e.style[n])
                return t[n];
        return!1
    }(), O = function () {
        if (window.onkeydown = a.previousWindowKeyDown, a.previousActiveElement && a.previousActiveElement.focus) {
            var e = window.scrollX, t = window.scrollY;
            a.previousActiveElement.focus(), e && t && window.scrollTo(e, t)
        }
    }, H = function () {
        if ("ontouchstart"in window || navigator.msMaxTouchPoints)
            return 0;
        var e = document.createElement("div");
        e.style.width = "50px", e.style.height = "50px", e.style.overflow = "scroll", document.body.appendChild(e);
        var t = e.offsetWidth - e.clientWidth;
        return document.body.removeChild(e), t
    }, N = function (e, t) {
        var n = void 0;
        return function () {
            clearTimeout(n), n = setTimeout(function () {
                n = null, e()
            }, t)
        }
    }, j = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    }, I = (function () {
        function e(e) {
            this.value = e
        }
        function t(t) {
            function n(r, i) {
                try {
                    var a = t[r](i), l = a.value;
                    l instanceof e ? Promise.resolve(l.value).then(function (e) {
                        n("next", e)
                    }, function (e) {
                        n("throw", e)
                    }) : o(a.done ? "return" : "normal", a.value)
                } catch (e) {
                    o("throw", e)
                }
            }
            function o(e, t) {
                switch (e) {
                    case"return":
                        r.resolve({value: t, done: !0});
                        break;
                    case"throw":
                        r.reject(t);
                        break;
                    default:
                        r.resolve({value: t, done: !1})
                }
                (r = r.next) ? n(r.key, r.arg) : i = null
            }
            var r, i;
            this._invoke = function (e, t) {
                return new Promise(function (o, a) {
                    var l = {key: e, arg: t, resolve: o, reject: a, next: null};
                    i ? i = i.next = l : (r = i = l, n(e, t))
                })
            }, "function" != typeof t.return && (this.return = void 0)
        }
        "function" == typeof Symbol && Symbol.asyncIterator && (t.prototype[Symbol.asyncIterator] = function () {
            return this
        }), t.prototype.next = function (e) {
            return this._invoke("next", e)
        }, t.prototype.throw = function (e) {
            return this._invoke("throw", e)
        }, t.prototype.return = function (e) {
            return this._invoke("return", e)
        }
    }(), Object.assign || function (e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = arguments[t];
            for (var o in n)
                Object.prototype.hasOwnProperty.call(n, o) && (e[o] = n[o])
        }
        return e
    }), R = I({}, e), K = [], W = void 0, D = function (e) {
        ("string" == typeof e.target && !document.querySelector(e.target) || "string" != typeof e.target && !e.target.appendChild) && (console.warn('SweetAlert2: Target parameter is not valid, defaulting to "body"'), e.target = "body");
        var t = void 0, r = c(), i = "string" == typeof e.target ? document.querySelector(e.target) : e.target;
        t = r && i && r.parentNode !== i.parentNode ? l(e) : r || l(e);
        for (var a in e)
            Y.isValidParameter(a) || console.warn('SweetAlert2: Unknown parameter "' + a + '"');
        t.style.width = "number" == typeof e.width ? e.width + "px" : e.width, t.style.padding = e.padding + "px", t.style.background = e.background;
        for (var s = t.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix"), u = 0; u < s.length; u++)
            s[u].style.background = e.background;
        var p = f(), y = m(), x = h(), k = g(), S = w(), E = C();
        if (e.titleText ? p.innerText = e.titleText : p.innerHTML = e.title.split("\n").join("<br />"), e.text || e.html) {
            if ("object" === j(e.html))
                if (y.innerHTML = "", 0 in e.html)
                    for (var q = 0; q in e.html; q++)
                        y.appendChild(e.html[q].cloneNode(!0));
                else
                    y.appendChild(e.html.cloneNode(!0));
            else
                e.html ? y.innerHTML = e.html : e.text && (y.textContent = e.text);
            P(y)
        } else
            L(y);
        e.showCloseButton ? (E.setAttribute("aria-label", e.closeButtonAriaLabel), P(E)) : L(E), t.className = n.modal,
                e.customClass && A(t, e.customClass);
        var M = b(), O = parseInt(null === e.currentProgressStep ? Y.getQueueStep() : e.currentProgressStep, 10);
        e.progressSteps.length ? (P(M), T(M), O >= e.progressSteps.length && console.warn("SweetAlert2: Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"), e.progressSteps.forEach(function (t, o) {
            var r = document.createElement("li");
            if (A(r, n.progresscircle),
                    r.innerHTML = t, o === O && A(r, n.activeprogressstep), M.appendChild(r),
                    o !== e.progressSteps.length - 1) {
                var i = document.createElement("li");
                A(i, n.progressline), i.style.width = e.progressStepsDistance, M.appendChild(i)
            }
        })) : L(M);
        for (var H = d(), N = 0; N < H.length; N++)
            L(H[N]);
        if (e.type) {
            var I = !1;
            for (var R in o)
                if (e.type === R) {
                    I = !0;
                    break
                }
            if (!I)
                return console.error("SweetAlert2: Unknown alert type: " + e.type), !1;
            var K = t.querySelector("." + n.icon + "." + o[e.type]);
            if (P(K), e.animation)
                switch (e.type) {
                    case"success":
                        A(K, "swal2-animate-success-icon"), A(K.querySelector(".swal2-success-line-tip"), "swal2-animate-success-line-tip"), A(K.querySelector(".swal2-success-line-long"), "swal2-animate-success-line-long");
                        break;
                    case"error":
                        A(K, "swal2-animate-error-icon"), A(K.querySelector(".swal2-x-mark"), "swal2-animate-x-mark")
                    }
        }
        var W = v();
        e.imageUrl ? (W.setAttribute("src", e.imageUrl), W.setAttribute("alt", e.imageAlt), P(W), e.imageWidth ? W.setAttribute("width", e.imageWidth) : W.removeAttribute("width"), e.imageHeight ? W.setAttribute("height", e.imageHeight) : W.removeAttribute("height"), W.className = n.image, e.imageClass && A(W, e.imageClass)) : L(W), e.showCancelButton ? S.style.display = "inline-block" : L(S), e.showConfirmButton ? V(k, "display") : L(k), e.showConfirmButton || e.showCancelButton ? P(x) : L(x), k.innerHTML = e.confirmButtonText, S.innerHTML = e.cancelButtonText, k.setAttribute("aria-label", e.confirmButtonAriaLabel), S.setAttribute("aria-label", e.cancelButtonAriaLabel), e.buttonsStyling && (k.style.backgroundColor = e.confirmButtonColor, S.style.backgroundColor = e.cancelButtonColor), k.className = n.confirm, A(k, e.confirmButtonClass), S.className = n.cancel, A(S, e.cancelButtonClass), e.buttonsStyling ? (A(k, n.styled), A(S, n.styled)) : (B(k, n.styled), B(S, n.styled), k.style.backgroundColor = k.style.borderLeftColor = k.style.borderRightColor = "", S.style.backgroundColor = S.style.borderLeftColor = S.style.borderRightColor = ""), !0 === e.animation ? B(t, n.noanimation) : A(t, n.noanimation), e.showLoaderOnConfirm && !e.preConfirm && console.warn("SweetAlert2: showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://limonte.github.io/sweetalert2/#ajax-request")
    }, U = function (e, t) {
        var o = u(), r = c();
        e ? (A(r, n.show), A(o, n.fade), B(r, n.hide)) : B(r, n.fade), P(r), o.style.overflowY = "hidden", M && !k(r, n.noanimation) ? r.addEventListener(M, function e() {
            r.removeEventListener(M, e), o.style.overflowY = "auto"
        }) : o.style.overflowY = "auto", A(document.documentElement, n.shown), A(document.body, n.shown), A(o, n.shown), z(), Z(), a.previousActiveElement = document.activeElement, null !== t && "function" == typeof t && setTimeout(function () {
            t(r)
        })
    }, z = function () {
        null === a.previousBodyPadding && document.body.scrollHeight > window.innerHeight && (a.previousBodyPadding = document.body.style.paddingRight, document.body.style.paddingRight = H() + "px")
    }, _ = function () {
        null !== a.previousBodyPadding && (document.body.style.paddingRight = a.previousBodyPadding, a.previousBodyPadding = null)
    }, Z = function () {
        if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream && !k(document.body, n.iosfix)) {
            var e = document.body.scrollTop;
            document.body.style.top = -1 * e + "px", A(document.body, n.iosfix)
        }
    }, Q = function () {
        if (k(document.body, n.iosfix)) {
            var e = parseInt(document.body.style.top, 10);
            B(document.body, n.iosfix), document.body.style.top = "", document.body.scrollTop = -1 * e
        }
    }, Y = function e() {
        for (var t = arguments.length, o = Array(t), i = 0; i < t; i++)
            o[i] = arguments[i];
        if (void 0 === o[0])
            return console.error("SweetAlert2 expects at least 1 attribute!"), !1;
        var l = I({}, R);
        switch (j(o[0])) {
            case"string":
                l.title = o[0], l.html = o[1], l.type = o[2];
                break;
            case"object":
                I(l, o[0]), l.extraParams = o[0].extraParams, "email" === l.input && null === l.inputValidator && (l.inputValidator = function (e) {
                    return new Promise(function (t, n) {
                        /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(e) ? t() : n("Invalid email address")
                    })
                }), "url" === l.input && null === l.inputValidator && (l.inputValidator = function (e) {
                    return new Promise(function (t, n) {
                        /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)$/.test(e) ? t() : n("Invalid URL")
                    })
                });
                break;
            default:
                return console.error('SweetAlert2: Unexpected type of argument! Expected "string" or "object", got ' + j(o[0])), !1
        }
        D(l);
        var s = u(), d = c();
        return new Promise(function (t, o) {
            l.timer && (d.timeout = setTimeout(function () {
                e.closeModal(l.onClose), l.useRejections ? o("timer") : t({dismiss: "timer"})
            }, l.timer));
            var i = function (e) {
                if (!(e = e || l.input))
                    return null;
                switch (e) {
                    case"select":
                    case"textarea":
                    case"file":
                        return E(d, n[e]);
                    case"checkbox":
                        return d.querySelector("." + n.checkbox + " input");
                    case"radio":
                        return d.querySelector("." + n.radio + " input:checked") || d.querySelector("." + n.radio + " input:first-child");
                    case"range":
                        return d.querySelector("." + n.range + " input");
                    default:
                        return E(d, n.input)
                    }
            }, p = function () {
                var e = i();
                if (!e)
                    return null;
                switch (l.input) {
                    case"checkbox":
                        return e.checked ? 1 : 0;
                    case"radio":
                        return e.checked ? e.value : null;
                    case"file":
                        return e.files.length ? e.files[0] : null;
                    default:
                        return l.inputAutoTrim ? e.value.trim() : e.value
                    }
            };
            l.input && setTimeout(function () {
                var e = i();
                e && S(e)
            }, 0);
            for (var k = function (n) {
                l.showLoaderOnConfirm && e.showLoading(), l.preConfirm ? l.preConfirm(n, l.extraParams).then(function (o) {
                    e.closeModal(l.onClose), t(o || n)
                }, function (t) {
                    e.hideLoading(), t && e.showValidationError(t)
                }) : (e.closeModal(l.onClose), t(l.useRejections ? n : {value: n}))
            }, T = function (n) {
                var i = n || window.event, a = i.target || i.srcElement, s = g(), u = w(), c = s && (s === a || s.contains(a)), d = u && (u === a || u.contains(a));
                switch (i.type) {
                    case"mouseover":
                    case"mouseup":
                        l.buttonsStyling && (c ? s.style.backgroundColor = r(l.confirmButtonColor, -.1) : d && (u.style.backgroundColor = r(l.cancelButtonColor, -.1)));
                        break;
                    case"mouseout":
                        l.buttonsStyling && (c ? s.style.backgroundColor = l.confirmButtonColor : d && (u.style.backgroundColor = l.cancelButtonColor));
                        break;
                    case"mousedown":
                        l.buttonsStyling && (c ? s.style.backgroundColor = r(l.confirmButtonColor, -.2) : d && (u.style.backgroundColor = r(l.cancelButtonColor, -.2)));
                        break;
                    case"click":
                        if (c && e.isVisible())
                            if (e.disableButtons(), l.input) {
                                var f = p();
                                l.inputValidator ? (e.disableInput(), l.inputValidator(f, l.extraParams).then(function () {
                                    e.enableButtons(), e.enableInput(), k(f)
                                }, function (t) {
                                    e.enableButtons(), e.enableInput(), t && e.showValidationError(t)
                                })) : k(f)
                            } else
                                k(!0);
                        else
                            d && e.isVisible() && (e.disableButtons(), e.closeModal(l.onClose), l.useRejections ? o("cancel") : t({dismiss: "cancel"}))
                    }
            }, V = d.querySelectorAll("button"), M = 0; M < V.length; M++)
                V[M].onclick = T, V[M].onmouseover = T, V[M].onmouseout = T, V[M].onmousedown = T;
            C().onclick = function () {
                e.closeModal(l.onClose), l.useRejections ? o("close") : t({dismiss: "close"})
            }, s.onclick = function (n) {
                n.target === s && l.allowOutsideClick && (e.closeModal(l.onClose), l.useRejections ? o("overlay") : t({dismiss: "overlay"}))
            };
            var O = h(), H = g(), I = w();
            l.reverseButtons ? H.parentNode.insertBefore(I, H) : H.parentNode.insertBefore(H, I);
            var R = function (e, t) {
                for (var n = x(l.focusCancel), o = 0; o < n.length; o++) {
                    (e += t) === n.length ? e = 0 : -1 === e && (e = n.length - 1);
                    var r = n[e];
                    if (q(r))
                        return r.focus()
                }
            }, K = function (n) {
                var r = n || window.event, i = r.keyCode || r.which;
                if (-1 !== [9, 13, 32, 27, 37, 38, 39, 40].indexOf(i)) {
                    for (var a = r.target || r.srcElement, s = x(l.focusCancel), u = -1, c = 0; c < s.length; c++)
                        if (a === s[c]) {
                            u = c;
                            break
                        }
                    9 === i ? (r.shiftKey ? R(u, -1) : R(u, 1), r.stopPropagation(), r.preventDefault()) : 37 === i || 38 === i || 39 === i || 40 === i ? document.activeElement === H && q(I) ? I.focus() : document.activeElement === I && q(H) && H.focus() : 27 === i && !0 === l.allowEscapeKey && (e.closeModal(l.onClose), l.useRejections ? o("esc") : t({dismiss: "esc"}))
                }
            };
            window.onkeydown && window.onkeydown.toString() === K.toString() || (a.previousWindowKeyDown = window.onkeydown, window.onkeydown = K), l.buttonsStyling && (H.style.borderLeftColor = l.confirmButtonColor, H.style.borderRightColor = l.confirmButtonColor), e.hideLoading = e.disableLoading = function () {
                l.showConfirmButton || (L(H), l.showCancelButton || L(h())), B(O, n.loading), B(d, n.loading), d.removeAttribute("aria-busy"), H.disabled = !1, I.disabled = !1
            }, e.getTitle = function () {
                return f()
            }, e.getContent = function () {
                return m()
            }, e.getInput = function () {
                return i()
            }, e.getImage = function () {
                return v()
            }, e.getButtonsWrapper = function () {
                return h()
            }, e.getConfirmButton = function () {
                return g()
            }, e.getCancelButton = function () {
                return w()
            }, e.enableButtons = function () {
                H.disabled = !1, I.disabled = !1
            }, e.disableButtons = function () {
                H.disabled = !0, I.disabled = !0
            }, e.enableConfirmButton = function () {
                H.disabled = !1
            }, e.disableConfirmButton = function () {
                H.disabled = !0
            }, e.enableInput = function () {
                var e = i();
                if (!e)
                    return!1;
                if ("radio" === e.type)
                    for (var t = e.parentNode.parentNode.querySelectorAll("input"), n = 0; n < t.length; n++)
                        t[n].disabled = !1;
                else
                    e.disabled = !1
            }, e.disableInput = function () {
                var e = i();
                if (!e)
                    return!1;
                if (e && "radio" === e.type)
                    for (var t = e.parentNode.parentNode.querySelectorAll("input"), n = 0; n < t.length; n++)
                        t[n].disabled = !0;
                else
                    e.disabled = !0
            }, e.recalculateHeight = N(function () {
                var e = c();
                if (e) {
                    var t = e.style.display;
                    e.style.minHeight = "", P(e), e.style.minHeight = e.scrollHeight + 1 + "px", e.style.display = t
                }
            }, 50), e.showValidationError = function (e) {
                var t = y();
                t.innerHTML = e, P(t);
                var o = i();
                o && (o.setAttribute("aria-invalid", !0), o.setAttribute("aria-describedBy", n.validationerror), S(o), A(o, n.inputerror))
            }, e.resetValidationError = function () {
                var t = y();
                L(t), e.recalculateHeight();
                var o = i();
                o && (o.removeAttribute("aria-invalid"), o.removeAttribute("aria-describedBy"), B(o, n.inputerror))
            }, e.getProgressSteps = function () {
                return l.progressSteps
            }, e.setProgressSteps = function (e) {
                l.progressSteps = e, D(l)
            }, e.showProgressSteps = function () {
                P(b())
            }, e.hideProgressSteps = function () {
                L(b())
            }, e.enableButtons(), e.hideLoading(), e.resetValidationError();
            for (var z = ["input", "file", "range", "select", "radio", "checkbox", "textarea"], _ = void 0, Z = 0; Z < z.length; Z++) {
                var Q = n[z[Z]], Y = E(d, Q);
                if (_ = i(z[Z])) {
                    for (var $ in _.attributes)
                        if (_.attributes.hasOwnProperty($)) {
                            var J = _.attributes[$].name;
                            "type" !== J && "value" !== J && _.removeAttribute(J)
                        }
                    for (var X in l.inputAttributes)
                        _.setAttribute(X, l.inputAttributes[X])
                }
                Y.className = Q, l.inputClass && A(Y, l.inputClass), L(Y)
            }
            var F = void 0;
            switch (l.input) {
                case"text":
                case"email":
                case"password":
                case"number":
                case"tel":
                case"url":
                    (_ = E(d, n.input)).value = l.inputValue, _.placeholder = l.inputPlaceholder, _.type = l.input, P(_);
                    break;
                case"file":
                    (_ = E(d, n.file)).placeholder = l.inputPlaceholder, _.type = l.input, P(_);
                    break;
                case"range":
                    var G = E(d, n.range), ee = G.querySelector("input"), te = G.querySelector("output");
                    ee.value = l.inputValue, ee.type = l.input, te.value = l.inputValue, P(G);
                    break;
                case"select":
                    var ne = E(d, n.select);
                    if (ne.innerHTML = "", l.inputPlaceholder) {
                        var oe = document.createElement("option");
                        oe.innerHTML = l.inputPlaceholder, oe.value = "", oe.disabled = !0, oe.selected = !0, ne.appendChild(oe)
                    }
                    F = function (e) {
                        for (var t in e) {
                            var n = document.createElement("option");
                            n.value = t, n.innerHTML = e[t], l.inputValue === t && (n.selected = !0), ne.appendChild(n)
                        }
                        P(ne), ne.focus()
                    };
                    break;
                case"radio":
                    var re = E(d, n.radio);
                    re.innerHTML = "", F = function (e) {
                        for (var t in e) {
                            var o = document.createElement("input"), r = document.createElement("label"), i = document.createElement("span");
                            o.type = "radio", o.name = n.radio, o.value = t, l.inputValue === t && (o.checked = !0), i.innerHTML = e[t], r.appendChild(o), r.appendChild(i), r.for = o.id, re.appendChild(r)
                        }
                        P(re);
                        var a = re.querySelectorAll("input");
                        a.length && a[0].focus()
                    };
                    break;
                case"checkbox":
                    var ie = E(d, n.checkbox), ae = i("checkbox");
                    ae.type = "checkbox", ae.value = 1, ae.id = n.checkbox, ae.checked = Boolean(l.inputValue);
                    var le = ie.getElementsByTagName("span");
                    le.length && ie.removeChild(le[0]), (le = document.createElement("span")).innerHTML = l.inputPlaceholder, ie.appendChild(le), P(ie);
                    break;
                case"textarea":
                    var se = E(d, n.textarea);
                    se.value = l.inputValue, se.placeholder = l.inputPlaceholder, P(se);
                    break;
                case null:
                    break;
                default:
                    console.error('SweetAlert2: Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "' + l.input + '"')
            }
            "select" !== l.input && "radio" !== l.input || (l.inputOptions instanceof Promise ? (e.showLoading(), l.inputOptions.then(function (t) {
                e.hideLoading(), F(t)
            })) : "object" === j(l.inputOptions) ? F(l.inputOptions) : console.error("SweetAlert2: Unexpected type of inputOptions! Expected object or Promise, got " + j(l.inputOptions))), U(l.animation, l.onOpen), l.allowEnterKey ? l.focusCancel && q(I) ? I.focus() : l.focusConfirm && q(H) ? H.focus() : R(-1, 1) : document.activeElement && document.activeElement.blur(), u().scrollTop = 0, "undefined" == typeof MutationObserver || W || (W = new MutationObserver(e.recalculateHeight)).observe(d, {childList: !0, characterData: !0, subtree: !0})
        })
    };
    return Y.isVisible = function () {
        return!!c()
    }, Y.queue = function (e) {
        K = e;
        var t = function () {
            K = [], document.body.removeAttribute("data-swal2-queue-step")
        }, n = [];
        return new Promise(function (e, o) {
            !function r(i, a) {
                i < K.length ? (document.body.setAttribute("data-swal2-queue-step", i), Y(K[i]).then(function (e) {
                    n.push(e), r(i + 1, a)
                }, function (e) {
                    t(), o(e)
                })) : (t(), e(n))
            }(0)
        })
    }, Y.getQueueStep = function () {
        return document.body.getAttribute("data-swal2-queue-step")
    }, Y.insertQueueStep = function (e, t) {
        return t && t < K.length ? K.splice(t, 0, e) : K.push(e)
    }, Y.deleteQueueStep = function (e) {
        void 0 !== K[e] && K.splice(e, 1)
    }, Y.close = Y.closeModal = function (e) {
        var t = u(), o = c();
        if (o) {
            B(o, n.show), A(o, n.hide), clearTimeout(o.timeout), O();
            var r = function () {
                t.parentNode && t.parentNode.removeChild(t), B(document.documentElement, n.shown), B(document.body, n.shown), _(), Q()
            };
            M && !k(o, n.noanimation) ? o.addEventListener(M, function e() {
                o.removeEventListener(M, e), k(o, n.hide) && r()
            }) : r(), null !== e && "function" == typeof e && setTimeout(function () {
                e(o)
            })
        }
    }, Y.clickConfirm = function () {
        return g().click()
    }, Y.clickCancel = function () {
        return w().click()
    }, Y.showLoading = Y.enableLoading = function () {
        var e = c();
        e || Y(""), e = c();
        var t = h(), o = g(), r = w();
        P(t), P(o, "inline-block"), A(t, n.loading), A(e, n.loading), o.disabled = !0, r.disabled = !0, e.setAttribute("aria-busy", !0), e.focus()
    }, Y.isValidParameter = function (t) {
        return e.hasOwnProperty(t) || "extraParams" === t
    }, Y.setDefaults = function (e) {
        if (!e || "object" !== (void 0 === e ? "undefined" : j(e)))
            return console.error("SweetAlert2: the argument for setDefaults() is required and has to be a object");
        for (var t in e)
            Y.isValidParameter(t) || (console.warn('SweetAlert2: Unknown parameter "' + t + '"'), delete e[t]);
        I(R, e)
    }, Y.resetDefaults = function () {
        R = I({}, e)
    }, Y.noop = function () {
    }, Y.version = "6.9.1", Y.default = Y, Y
}), window.Sweetalert2 && (window.sweetAlert = window.swal = window.Sweetalert2);