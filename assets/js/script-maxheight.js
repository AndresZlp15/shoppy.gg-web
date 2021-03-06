$(document).ready(function () {
    $("[data-bs-hover-animate]").mouseenter(function () {
        var t = $(this);
        t.addClass("animated " + t.attr("data-bs-hover-animate"))
    }).mouseleave(function () {
        var t = $(this);
        t.removeClass("animated " + t.attr("data-bs-hover-animate"))
    })
}), function (t) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], t) : "undefined" != typeof module && module.exports ? module.exports = t(require("jquery")) : t(jQuery)
}(function (t) {
    /*
    * https://github.com/liabru/jquery-match-height
    * */
    var e = -1, a = -1, n = function (t) {
        return parseFloat(t) || 0
    }, o = function (e) {
        var a = t(e), o = null, i = [];
        return a.each(function () {
            var e = t(this), a = e.offset().top - n(e.css("margin-top")), r = i.length > 0 ? i[i.length - 1] : null;
            null === r ? i.push(e) : Math.floor(Math.abs(o - a)) <= 1 ? i[i.length - 1] = r.add(e) : i.push(e), o = a
        }), i
    }, i = function (e) {
        var a = {byRow: !0, property: "height", target: null, remove: !1};
        return "object" == typeof e ? t.extend(a, e) : ("boolean" == typeof e ? a.byRow = e : "remove" === e && (a.remove = !0), a)
    }, r = t.fn.matchHeight = function (e) {
        var a = i(e);
        if (a.remove) {
            var n = this;
            return this.css(a.property, ""), t.each(r._groups, function (t, e) {
                e.elements = e.elements.not(n)
            }), this
        }
        return this.length <= 1 && !a.target ? this : (r._groups.push({
            elements: this,
            options: a
        }), r._apply(this, a), this)
    };
    r.version = "master", r._groups = [], r._throttle = 80, r._maintainScroll = !1, r._beforeUpdate = null, r._afterUpdate = null, r._rows = o, r._parse = n, r._parseOptions = i, r._apply = function (e, a) {
        var s = i(a), h = t(e), c = [h], l = t(window).scrollTop(), d = t("html").outerHeight(!0),
            p = h.parents().filter(":hidden");
        return p.each(function () {
            var e = t(this);
            e.data("style-cache", e.attr("style"))
        }), p.css("display", "block"), s.byRow && !s.target && (h.each(function () {
            var e = t(this), a = e.css("display");
            "inline-block" !== a && "flex" !== a && "inline-flex" !== a && (a = "block"), e.data("style-cache", e.attr("style")), e.css({
                display: a,
                "padding-top": "0",
                "padding-bottom": "0",
                "margin-top": "0",
                "margin-bottom": "0",
                "border-top-width": "0",
                "border-bottom-width": "0",
                height: "100px",
                overflow: "hidden"
            })
        }), c = o(h), h.each(function () {
            var e = t(this);
            e.attr("style", e.data("style-cache") || "")
        })), t.each(c, function (e, a) {
            var o = t(a), i = 0;
            if (s.target) i = s.target.outerHeight(!1); else {
                if (s.byRow && o.length <= 1) return void o.css(s.property, "");
                o.each(function () {
                    var e = t(this), a = e.attr("style"), n = e.css("display");
                    "inline-block" !== n && "flex" !== n && "inline-flex" !== n && (n = "block");
                    var o = {display: n};
                    o[s.property] = "", e.css(o), e.outerHeight(!1) > i && (i = e.outerHeight(!1)), a ? e.attr("style", a) : e.css("display", "")
                })
            }
            o.each(function () {
                var e = t(this), a = 0;
                s.target && e.is(s.target) || ("border-box" !== e.css("box-sizing") && (a += n(e.css("border-top-width")) + n(e.css("border-bottom-width")), a += n(e.css("padding-top")) + n(e.css("padding-bottom"))), e.css(s.property, i - a + "px"))
            })
        }), p.each(function () {
            var e = t(this);
            e.attr("style", e.data("style-cache") || null)
        }), r._maintainScroll && t(window).scrollTop(l / d * t("html").outerHeight(!0)), this
    }, r._applyDataApi = function () {
        var e = {};
        t("[data-match-height], [data-mh]").each(function () {
            var a = t(this), n = a.attr("data-mh") || a.attr("data-match-height");
            e[n] = n in e ? e[n].add(a) : a
        }), t.each(e, function () {
            this.matchHeight(!0)
        })
    };
    var s = function (e) {
        r._beforeUpdate && r._beforeUpdate(e, r._groups), t.each(r._groups, function () {
            r._apply(this.elements, this.options)
        }), r._afterUpdate && r._afterUpdate(e, r._groups)
    };
    r._update = function (n, o) {
        if (o && "resize" === o.type) {
            var i = t(window).width();
            if (i === e) return;
            e = i
        }
        n ? -1 === a && (a = setTimeout(function () {
            s(o), a = -1
        }, r._throttle)) : s(o)
    }, t(r._applyDataApi);
    var h = t.fn.on ? "on" : "bind";
    t(window)[h]("load", function (t) {
        r._update(!1, t)
    }), t(window)[h]("resize orientationchange", function (t) {
        r._update(!0, t)
    })
}), setTimeout(function(){$(".package>.card").matchHeight();},10);