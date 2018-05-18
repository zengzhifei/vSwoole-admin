/** @license
 *
 * SoundManager 2: JavaScript Sound for the Web
 * ----------------------------------------------
 * http://schillmania.com/projects/soundmanager2/
 *
 * Copyright (c) 2007, Scott Schiller. All rights reserved.
 * Code provided under the BSD License:
 * http://schillmania.com/projects/soundmanager2/license.txt
 *
 * V2.97a.20130512
 */

(function(e, t) {
    function n(n, r) {
        function i(e) {
            return u.preferFlash && kt && !u.ignoreFlash && u.flash[e] !== t && u.flash[e]
        }
        function s(e) {
            return function(t) {
                var n = this._s;
                return ! n || !n._a ? null: e.call(this, t)
            }
        }
        this.setupOptions = {
            url: n || null,
            flashVersion: 8,
            debugMode: !0,
            debugFlash: !1,
            useConsole: !0,
            consoleOnly: !0,
            waitForWindowLoad: !1,
            bgColor: "#ffffff",
            useHighPerformance: !1,
            flashPollingInterval: null,
            html5PollingInterval: null,
            flashLoadTimeout: 1e3,
            wmode: null,
            allowScriptAccess: "always",
            useFlashBlock: !1,
            useHTML5Audio: !0,
            html5Test: /^(probably|maybe)$/i,
            preferFlash: !0,
            noSWFCache: !1,
            idPrefix: "sound"
        },
        this.defaultOptions = {
            autoLoad: !1,
            autoPlay: !1,
            from: null,
            loops: 1,
            onid3: null,
            onload: null,
            whileloading: null,
            onplay: null,
            onpause: null,
            onresume: null,
            whileplaying: null,
            onposition: null,
            onstop: null,
            onfailure: null,
            onfinish: null,
            multiShot: !0,
            multiShotEvents: !1,
            position: null,
            pan: 0,
            stream: !0,
            to: null,
            type: null,
            usePolicyFile: !1,
            volume: 100
        },
        this.flash9Options = {
            isMovieStar: null,
            usePeakData: !1,
            useWaveformData: !1,
            useEQData: !1,
            onbufferchange: null,
            ondataerror: null
        },
        this.movieStarOptions = {
            bufferTime: 3,
            serverURL: null,
            onconnect: null,
            duration: null
        },
        this.audioFormats = {
            mp3: {
                type: ['audio/mpeg; codecs="mp3"', "audio/mpeg", "audio/mp3", "audio/MPA", "audio/mpa-robust"],
                required: !0
            },
            mp4: {
                related: ["aac", "m4a", "m4b"],
                type: ['audio/mp4; codecs="mp4a.40.2"', "audio/aac", "audio/x-m4a", "audio/MP4A-LATM", "audio/mpeg4-generic"],
                required: !1
            },
            ogg: {
                type: ["audio/ogg; codecs=vorbis"],
                required: !1
            },
            opus: {
                type: ["audio/ogg; codecs=opus", "audio/opus"],
                required: !1
            },
            wav: {
                type: ['audio/wav; codecs="1"', "audio/wav", "audio/wave", "audio/x-wav"],
                required: !1
            }
        },
        this.movieID = "sm2-container",
        this.id = r || "sm2movie",
        this.debugID = "soundmanager-debug",
        this.debugURLParam = /([#?&])debug=1/i,
        this.versionNumber = "V2.97a.20130512",
        this.altURL = this.movieURL = this.version = null,
        this.enabled = this.swfLoaded = !1,
        this.oMC = null,
        this.sounds = {},
        this.soundIDs = [],
        this.didFlashBlock = this.muted = !1,
        this.filePattern = null,
        this.filePatterns = {
            flash8: /\.mp3(\?.*)?$/i,
            flash9: /\.mp3(\?.*)?$/i
        },
        this.features = {
            buffering: !1,
            peakData: !1,
            waveformData: !1,
            eqData: !1,
            movieStar: !1
        },
        this.sandbox = {},
        this.html5 = {
            usingFlash: null
        },
        this.flash = {},
        this.ignoreFlash = this.html5Only = !1;
        var o, u = this,
        a = null,
        f = null,
        c, p = navigator.userAgent,
        d = e.location.href.toString(),
        v = document,
        m,
        g,
        y,
        b,
        w = [],
        E = !1,
        S = !1,
        x = !1,
        T = !1,
        N = !1,
        C,
        k,
        L,
        A,
        O,
        M,
        _,
        D,
        P,
        H,
        B,
        j,
        F,
        I,
        q,
        R,
        U,
        z,
        W,
        X,
        V,
        $,
        J,
        K,
        Q,
        G = null,
        Y = null,
        Z,
        et,
        tt,
        nt,
        rt,
        it,
        st = !1,
        ot = !1,
        ut,
        at,
        ft,
        lt = 0,
        ct = null,
        ht,
        pt = [],
        dt,
        vt = null,
        mt,
        gt,
        yt,
        bt,
        wt,
        Et,
        St,
        xt,
        Tt = Array.prototype.slice,
        Nt = !1,
        Ct,
        kt,
        Lt,
        At,
        Ot,
        Mt,
        _t = 0,
        Dt = p.match(/(ipad|iphone|ipod)/i),
        Pt = p.match(/android/i),
        Ht = p.match(/msie/i),
        Bt = p.match(/webkit/i),
        jt = p.match(/safari/i) && !p.match(/chrome/i),
        Ft = p.match(/opera/i),
        It = p.match(/firefox/i),
        qt = p.match(/(mobile|pre\/|xoom)/i) || Dt || Pt,
        Rt = !d.match(/usehtml5audio/i) && !d.match(/sm2\-ignorebadua/i) && jt && !p.match(/silk/i) && p.match(/OS X 10_6_([3-7])/i),
        Ut = v.hasFocus !== t ? v.hasFocus() : null,
        zt = jt && (v.hasFocus === t || !v.hasFocus()),
        Wt = !zt,
        Xt = /(mp3|mp4|mpa|m4a|m4b)/i,
        Vt = v.location ? v.location.protocol.match(/http/i) : null,
        $t = Vt ? "": "http://",
        Jt = /^\s*audio\/(?:x-)?(?:mpeg4|aac|flv|mov|mp4||m4v|m4a|m4b|mp4v|3gp|3g2)\s*(?:$|;)/i,
        Kt = "mpeg4 aac flv mov mp4 m4v f4v m4a m4b mp4v 3gp 3g2".split(" "),
        Qt = RegExp("\\.(" + Kt.join("|") + ")(\\?.*)?$", "i");
        this.mimePattern = /^\s*audio\/(?:x-)?(?:mp(?:eg|3))\s*(?:$|;)/i,
        this.useAltURL = !Vt;
        var Gt;
        try {
            Gt = Audio !== t && (Ft && opera !== t && 10 > opera.version() ? new Audio(null) : new Audio).canPlayType !== t
        } catch(Yt) {
            Gt = !1
        }
        this.hasHTML5 = Gt,
        this.setup = function(e) {
            var n = !u.url;
            return e !== t && x && vt && u.ok(),
            L(e),
            e && (n && U && e.url !== t && u.beginDelayedInit(), !U && e.url !== t && "complete" === v.readyState && setTimeout(q, 1)),
            u
        },
        this.supported = this.ok = function() {
            return vt ? x && !T: u.useHTML5Audio && u.hasHTML5
        },
        this.getMovie = function(t) {
            return c(t) || v[t] || e[t]
        },
        this.createSound = function(e, n) {
            function r() {
                return i = nt(i),
                u.sounds[i.id] = new o(i),
                u.soundIDs.push(i.id),
                u.sounds[i.id]
            }
            var i, s = null;
            if (!x || !u.ok()) return ! 1;
            n !== t && (e = {
                id: e,
                url: n
            }),
            i = k(e),
            i.url = ht(i.url),
            void 0 === i.id && (i.id = u.setupOptions.idPrefix + _t++);
            if (it(i.id, !0)) return u.sounds[i.id];
            if (gt(i)) s = r(),
            s._setup_html5(i);
            else {
                if (u.html5Only || u.html5.usingFlash && i.url && i.url.match(/data\:/i)) return r();
                8 < b && null === i.isMovieStar && (i.isMovieStar = !!i.serverURL || !!(i.type && i.type.match(Jt) || i.url && i.url.match(Qt))),
                i = rt(i, void 0),
                s = r(),
                8 === b ? f._createSound(i.id, i.loops || 1, i.usePolicyFile) : (f._createSound(i.id, i.url, i.usePeakData, i.useWaveformData, i.useEQData, i.isMovieStar, i.isMovieStar ? i.bufferTime: !1, i.loops || 1, i.serverURL, i.duration || null, i.autoPlay, !0, i.autoLoad, i.usePolicyFile), i.serverURL || (s.connected = !0, i.onconnect && i.onconnect.apply(s))),
                !i.serverURL && (i.autoLoad || i.autoPlay) && s.load(i)
            }
            return ! i.serverURL && i.autoPlay && s.play(),
            s
			
        },
        this.destroySound = function(e, t) {
            if (!it(e)) return ! 1;
            var n = u.sounds[e],
            r;
            n._iO = {},
            n.stop(),
            n.unload();
            for (r = 0; r < u.soundIDs.length; r++) if (u.soundIDs[r] === e) {
                u.soundIDs.splice(r, 1);
                break
            }
            return t || n.destruct(!0),
            delete u.sounds[e],
            !0
        },
        this.load = function(e, t) {
            return it(e) ? u.sounds[e].load(t) : !1
        },
        this.unload = function(e) {
            return it(e) ? u.sounds[e].unload() : !1
        },
        this.onposition = this.onPosition = function(e, t, n, r) {
            return it(e) ? u.sounds[e].onposition(t, n, r) : !1
        },
        this.clearOnPosition = function(e, t, n) {
            return it(e) ? u.sounds[e].clearOnPosition(t, n) : !1
        },
        this.start = this.play = function(e, t) {
            var n = null,
            r = t && !(t instanceof Object);
            if (!x || !u.ok()) return ! 1;
            if (it(e, r)) r && (t = {
                url: t
            });
            else {
                if (!r) return ! 1;
                r && (t = {
                    url: t
                }),
                t && t.url && (t.id = e, n = u.createSound(t).play())
            }
            return null === n && (n = u.sounds[e].play(t)),
            n
        },
        this.setPosition = function(e, t) {
            return it(e) ? u.sounds[e].setPosition(t) : !1
        },
        this.stop = function(e) {
            return it(e) ? u.sounds[e].stop() : !1
        },
        this.stopAll = function() {
            for (var e in u.sounds) u.sounds.hasOwnProperty(e) && u.sounds[e].stop()
        },
        this.pause = function(e) {
            return it(e) ? u.sounds[e].pause() : !1
        },
        this.pauseAll = function() {
            var e;
            for (e = u.soundIDs.length - 1; 0 <= e; e--) u.sounds[u.soundIDs[e]].pause()
        },
        this.resume = function(e) {
            return it(e) ? u.sounds[e].resume() : !1
        },
        this.resumeAll = function() {
            var e;
            for (e = u.soundIDs.length - 1; 0 <= e; e--) u.sounds[u.soundIDs[e]].resume()
        },
        this.togglePause = function(e) {
            return it(e) ? u.sounds[e].togglePause() : !1
        },
        this.setPan = function(e, t) {
            return it(e) ? u.sounds[e].setPan(t) : !1
        },
        this.setVolume = function(e, t) {
            return it(e) ? u.sounds[e].setVolume(t) : !1
        },
        this.mute = function(e) {
            var t = 0;
            e instanceof String && (e = null);
            if (e) return it(e) ? u.sounds[e].mute() : !1;
            for (t = u.soundIDs.length - 1; 0 <= t; t--) u.sounds[u.soundIDs[t]].mute();
            return u.muted = !0
        },
        this.muteAll = function() {
            u.mute()
        },
        this.unmute = function(e) {
            e instanceof String && (e = null);
            if (e) return it(e) ? u.sounds[e].unmute() : !1;
            for (e = u.soundIDs.length - 1; 0 <= e; e--) u.sounds[u.soundIDs[e]].unmute();
            return u.muted = !1,
            !0
        },
        this.unmuteAll = function() {
            u.unmute()
        },
        this.toggleMute = function(e) {
            return it(e) ? u.sounds[e].toggleMute() : !1
        },
        this.getMemoryUse = function() {
            var e = 0;
            return f && 8 !== b && (e = parseInt(f._getMemoryUse(), 10)),
            e
        },
        this.disable = function(n) {
            var r;
            n === t && (n = !1);
            if (T) return ! 1;
            T = !0;
            for (r = u.soundIDs.length - 1; 0 <= r; r--) J(u.sounds[u.soundIDs[r]]);
            return C(n),
            xt.remove(e, "load", _),
            !0
        },
        this.canPlayMIME = function(e) {
            var t;
            return u.hasHTML5 && (t = yt({
                type: e
            })),
            !t && vt && (t = e && u.ok() ? !!(8 < b && e.match(Jt) || e.match(u.mimePattern)) : null),
            t
        },
        this.canPlayURL = function(e) {
            var t;
            return u.hasHTML5 && (t = yt({
                url: e
            })),
            !t && vt && (t = e && u.ok() ? !!e.match(u.filePattern) : null),
            t
        },
        this.canPlayLink = function(e) {
            return e.type !== t && e.type && u.canPlayMIME(e.type) ? !0 : u.canPlayURL(e.href)
        },
        this.getSoundById = function(e, t) {
            return e ? u.sounds[e] : null
        },
        this.onready = function(t, n) {
            if ("function" != typeof t) throw Z("needFunction", "onready");
            return n || (n = e),
            O("onready", t, n),
            M(),
            !0
        },
        this.ontimeout = function(t, n) {
            if ("function" != typeof t) throw Z("needFunction", "ontimeout");
            return n || (n = e),
            O("ontimeout", t, n),
            M({
                type: "ontimeout"
            }),
            !0
        },
        this._wD = this._writeDebug = function(e, t) {
            return ! 0
        },
        this._debug = function() {},
        this.reboot = function(t, n) {
            var r, i, s;
            for (r = u.soundIDs.length - 1; 0 <= r; r--) u.sounds[u.soundIDs[r]].destruct();
            if (f) try {
                Ht && (Y = f.innerHTML),
                G = f.parentNode.removeChild(f)
            } catch(o) {}
            Y = G = vt = f = null,
            u.enabled = U = x = st = ot = E = S = T = Nt = u.swfLoaded = !1,
            u.soundIDs = [],
            u.sounds = {},
            _t = 0;
            if (t) w = [];
            else for (r in w) if (w.hasOwnProperty(r)) {
                i = 0;
                for (s = w[r].length; i < s; i++) w[r][i].fired = !1
            }
            return u.html5 = {
                usingFlash: null
            },
            u.flash = {},
            u.html5Only = !1,
            u.ignoreFlash = !1,
            e.setTimeout(function() {
                I(),
                n || u.beginDelayedInit()
            },
            20),
            u
        },
        this.reset = function() {
            return u.reboot(!0, !0)
        },
        this.getMoviePercent = function() {
            return f && "PercentLoaded" in f ? f.PercentLoaded() : null
        },
        this.beginDelayedInit = function() {
            N = !0,
            q(),
            setTimeout(function() {
                return ot ? !1 : (W(), F(), ot = !0)
            },
            20),
            D()
        },
        this.destruct = function() {
            u.disable(!0)
        },
        o = function(e) {
            var n, r, i = this,
            s, o, l, c, p, d, v = !1,
            m = [],
            g = 0,
            y,
            w,
            E = null,
            S;
            r = n = null,
            this.sID = this.id = e.id,
            this.url = e.url,
            this._iO = this.instanceOptions = this.options = k(e),
            this.pan = this.options.pan,
            this.volume = this.options.volume,
            this.isHTML5 = !1,
            this._a = null,
            S = this.url ? !1 : !0,
            this.id3 = {},
            this._debug = function() {},
            this.load = function(e) {
                var n = null,
                r;
                e !== t ? i._iO = k(e, i.options) : (e = i.options, i._iO = e, E && E !== i.url && (i._iO.url = i.url, i.url = null)),
                i._iO.url || (i._iO.url = i.url),
                i._iO.url = ht(i._iO.url),
                r = i.instanceOptions = i._iO;
                if (!r.url && !i.url) return i;
                if (r.url === i.url && 0 !== i.readyState && 2 !== i.readyState) return 3 === i.readyState && r.onload && Mt(i,
                function() {
                    r.onload.apply(i, [ !! i.duration])
                }),
                i;
                i.loaded = !1,
                i.readyState = 1,
                i.playState = 0,
                i.id3 = {};
                if (gt(r)) n = i._setup_html5(r),
                n._called_load || (i._html5_canplay = !1, i.url !== r.url && (i._a.src = r.url, i.setPosition(0)), i._a.autobuffer = "auto", i._a.preload = "auto", i._a._called_load = !0, r.autoPlay && i.play());
                else {
                    if (u.html5Only || i._iO.url && i._iO.url.match(/data\:/i)) return i;
                    try {
                        i.isHTML5 = !1,
                        i._iO = rt(nt(r)),
                        r = i._iO,
                        8 === b ? f._load(i.id, r.url, r.stream, r.autoPlay, r.usePolicyFile) : f._load(i.id, r.url, !!r.stream, !!r.autoPlay, r.loops || 1, !!r.autoLoad, r.usePolicyFile)
                    } catch(s) {
                        X({
                            type: "SMSOUND_LOAD_JS_EXCEPTION",
                            fatal: !0
                        })
                    }
                }
                return i.url = r.url,
                i
            },
            this.unload = function() {
                return 0 !== i.readyState && (i.isHTML5 ? (c(), i._a && (i._a.pause(), E = wt(i._a))) : 8 === b ? f._unload(i.id, "about:blank") : f._unload(i.id), s()),
                i
            },
            this.destruct = function(e) {
                i.isHTML5 ? (c(), i._a && (i._a.pause(), wt(i._a), Nt || l(), i._a._s = null, i._a = null)) : (i._iO.onfailure = null, f._destroySound(i.id)),
                e || u.destroySound(i.id, !0)
            },
            this.start = this.play = function(e, n) {
                var r, s, o, a, l;
                s = !0,
                s = null,
                n = n === t ? !0 : n,
                e || (e = {}),
                i.url && (i._iO.url = i.url),
                i._iO = k(i._iO, i.options),
                i._iO = k(e, i._iO),
                i._iO.url = ht(i._iO.url),
                i.instanceOptions = i._iO;
                if (!i.isHTML5 && i._iO.serverURL && !i.connected) return i.getAutoPlay() || i.setAutoPlay(!0),
                i;
                gt(i._iO) && (i._setup_html5(i._iO), p()),
                1 === i.playState && !i.paused && (r = i._iO.multiShot, r || (i.isHTML5 && i.setPosition(i._iO.position), s = i));
                if (null !== s) return s;
                e.url && e.url !== i.url && (!i.readyState && !i.isHTML5 && 8 === b && S ? S = !1 : i.load(i._iO)),
                i.loaded || (0 === i.readyState ? (!i.isHTML5 && !u.html5Only ? (i._iO.autoPlay = !0, i.load(i._iO)) : i.isHTML5 ? i.load(i._iO) : s = i, i.instanceOptions = i._iO) : 2 === i.readyState && (s = i));
                if (null !== s) return s; ! i.isHTML5 && 9 === b && 0 < i.position && i.position === i.duration && (e.position = 0);
                if (i.paused && 0 <= i.position && (!i._iO.serverURL || 0 < i.position)) i.resume();
                else {
                    i._iO = k(e, i._iO);
                    if (null !== i._iO.from && null !== i._iO.to && 0 === i.instanceCount && 0 === i.playState && !i._iO.serverURL) {
                        r = function() {
                            i._iO = k(e, i._iO),
                            i.play(i._iO)
                        },
                        i.isHTML5 && !i._html5_canplay ? (i.load({
                            oncanplay: r
                        }), s = !1) : !i.isHTML5 && !i.loaded && (!i.readyState || 2 !== i.readyState) && (i.load({
                            onload: r
                        }), s = !1);
                        if (null !== s) return s;
                        i._iO = w()
                    } (!i.instanceCount || i._iO.multiShotEvents || i.isHTML5 && i._iO.multiShot && !Nt || !i.isHTML5 && 8 < b && !i.getAutoPlay()) && i.instanceCount++,
                    i._iO.onposition && 0 === i.playState && d(i),
                    i.playState = 1,
                    i.paused = !1,
                    i.position = i._iO.position !== t && !isNaN(i._iO.position) ? i._iO.position: 0,
                    i.isHTML5 || (i._iO = rt(nt(i._iO))),
                    i._iO.onplay && n && (i._iO.onplay.apply(i), v = !0),
                    i.setVolume(i._iO.volume, !0),
                    i.setPan(i._iO.pan, !0),
                    i.isHTML5 ? 2 > i.instanceCount ? (p(), s = i._setup_html5(), i.setPosition(i._iO.position), s.play()) : (o = new Audio(i._iO.url), a = function() {
                        xt.remove(o, "onended", a),
                        i._onfinish(i),
                        wt(o),
                        o = null
                    },
                    l = function() {
                        xt.remove(o, "canplay", l);
                        try {
                            o.currentTime = i._iO.position / 1e3
                        } catch(e) {}
                        o.play()
                    },
                    xt.add(o, "ended", a), i._iO.position ? xt.add(o, "canplay", l) : o.play()) : (s = f._start(i.id, i._iO.loops || 1, 9 === b ? i.position: i.position / 1e3, i._iO.multiShot || !1), 9 === b && !s && i._iO.onplayerror && i._iO.onplayerror.apply(i))
                }
                return i
            },
            this.stop = function(e) {
                var t = i._iO;
                return 1 === i.playState && (i._onbufferchange(0), i._resetOnPosition(0), i.paused = !1, i.isHTML5 || (i.playState = 0), y(), t.to && i.clearOnPosition(t.to), i.isHTML5 ? i._a && (e = i.position, i.setPosition(0), i.position = e, i._a.pause(), i.playState = 0, i._onTimer(), c()) : (f._stop(i.id, e), t.serverURL && i.unload()), i.instanceCount = 0, i._iO = {},
                t.onstop && t.onstop.apply(i)),
                i
            },
            this.setAutoPlay = function(e) {
                i._iO.autoPlay = e,
                i.isHTML5 || (f._setAutoPlay(i.id, e), e && !i.instanceCount && 1 === i.readyState && i.instanceCount++)
            },
            this.getAutoPlay = function() {
                return i._iO.autoPlay
            },
            this.setPosition = function(e) {
                e === t && (e = 0);
                var n = i.isHTML5 ? Math.max(e, 0) : Math.min(i.duration || i._iO.duration, Math.max(e, 0));
                i.position = n,
                e = i.position / 1e3,
                i._resetOnPosition(i.position),
                i._iO.position = n;
                if (i.isHTML5) {
                    if (i._a) {
                        if (i._html5_canplay) {
                            if (i._a.currentTime !== e) try {
                                i._a.currentTime = e,
                                (0 === i.playState || i.paused) && i._a.pause()
                            } catch(r) {}
                        } else if (e) return i;
                        i.paused && i._onTimer(!0)
                    }
                } else e = 9 === b ? i.position: e,
                i.readyState && 2 !== i.readyState && f._setPosition(i.id, e, i.paused || !i.playState, i._iO.multiShot);
                return i
            },
            this.pause = function(e) {
                return i.paused || 0 === i.playState && 1 !== i.readyState ? i: (i.paused = !0, i.isHTML5 ? (i._setup_html5().pause(), c()) : (e || e === t) && f._pause(i.id, i._iO.multiShot), i._iO.onpause && i._iO.onpause.apply(i), i)
            },
            this.resume = function() {
                var e = i._iO;
                return i.paused ? (i.paused = !1, i.playState = 1, i.isHTML5 ? (i._setup_html5().play(), p()) : (e.isMovieStar && !e.serverURL && i.setPosition(i.position), f._pause(i.id, e.multiShot)), !v && e.onplay ? (e.onplay.apply(i), v = !0) : e.onresume && e.onresume.apply(i), i) : i
            },
            this.togglePause = function() {
                return 0 === i.playState ? (i.play({
                    position: 9 === b && !i.isHTML5 ? i.position: i.position / 1e3
                }), i) : (i.paused ? i.resume() : i.pause(), i)
            },
            this.setPan = function(e, n) {
                return e === t && (e = 0),
                n === t && (n = !1),
                i.isHTML5 || f._setPan(i.id, e),
                i._iO.pan = e,
                n || (i.pan = e, i.options.pan = e),
                i
            },
            this.setVolume = function(e, n) {
                return e === t && (e = 100),
                n === t && (n = !1),
                i.isHTML5 ? i._a && (i._a.volume = Math.max(0, Math.min(1, e / 100))) : f._setVolume(i.id, u.muted && !i.muted || i.muted ? 0 : e),
                i._iO.volume = e,
                n || (i.volume = e, i.options.volume = e),
                i
            },
            this.mute = function() {
                return i.muted = !0,
                i.isHTML5 ? i._a && (i._a.muted = !0) : f._setVolume(i.id, 0),
                i
            },
            this.unmute = function() {
                i.muted = !1;
                var e = i._iO.volume !== t;
                return i.isHTML5 ? i._a && (i._a.muted = !1) : f._setVolume(i.id, e ? i._iO.volume: i.options.volume),
                i
            },
            this.toggleMute = function() {
                return i.muted ? i.unmute() : i.mute()
            },
            this.onposition = this.onPosition = function(e, n, r) {
                return m.push({
                    position: parseInt(e, 10),
                    method: n,
                    scope: r !== t ? r: i,
                    fired: !1
                }),
                i
            },
            this.clearOnPosition = function(e, t) {
                var n;
                e = parseInt(e, 10);
                if (isNaN(e)) return ! 1;
                for (n = 0; n < m.length; n++) e === m[n].position && (!t || t === m[n].method) && (m[n].fired && g--, m.splice(n, 1))
            },
            this._processOnPosition = function() {
                var e, t;
                e = m.length;
                if (!e || !i.playState || g >= e) return ! 1;
                for (e -= 1; 0 <= e; e--) t = m[e],
                !t.fired && i.position >= t.position && (t.fired = !0, g++, t.method.apply(t.scope, [t.position]));
                return ! 0
            },
            this._resetOnPosition = function(e) {
                var t, n;
                t = m.length;
                if (!t) return ! 1;
                for (t -= 1; 0 <= t; t--) n = m[t],
                n.fired && e <= n.position && (n.fired = !1, g--);
                return ! 0
            },
            w = function() {
                var e = i._iO,
                t = e.from,
                n = e.to,
                r, s;
                return s = function() {
                    i.clearOnPosition(n, s),
                    i.stop()
                },
                r = function() {
                    null !== n && !isNaN(n) && i.onPosition(n, s)
                },
                null !== t && !isNaN(t) && (e.position = t, e.multiShot = !1, r()),
                e
            },
            d = function() {
                var e, t = i._iO.onposition;
                if (t) for (e in t) t.hasOwnProperty(e) && i.onPosition(parseInt(e, 10), t[e])
            },
            y = function() {
                var e, t = i._iO.onposition;
                if (t) for (e in t) t.hasOwnProperty(e) && i.clearOnPosition(parseInt(e, 10))
            },
            p = function() {
                i.isHTML5 && ut(i)
            },
            c = function() {
                i.isHTML5 && at(i)
            },
            s = function(e) {
                e || (m = [], g = 0),
                v = !1,
                i._hasTimer = null,
                i._a = null,
                i._html5_canplay = !1,
                i.bytesLoaded = null,
                i.bytesTotal = null,
                i.duration = i._iO && i._iO.duration ? i._iO.duration: null,
                i.durationEstimate = null,
                i.buffered = [],
                i.eqData = [],
                i.eqData.left = [],
                i.eqData.right = [],
                i.failures = 0,
                i.isBuffering = !1,
                i.instanceOptions = {},
                i.instanceCount = 0,
                i.loaded = !1,
                i.metadata = {},
                i.readyState = 0,
                i.muted = !1,
                i.paused = !1,
                i.peakData = {
                    left: 0,
                    right: 0
                },
                i.waveformData = {
                    left: [],
                    right: []
                },
                i.playState = 0,
                i.position = null,
                i.id3 = {}
            },
            s(),
            this._onTimer = function(e) {
                var t, s = !1,
                o = {};
                if (i._hasTimer || e) return i._a && (e || (0 < i.playState || 1 === i.readyState) && !i.paused) && (t = i._get_html5_duration(), t !== n && (n = t, i.duration = t, s = !0), i.durationEstimate = i.duration, t = 1e3 * i._a.currentTime || 0, t !== r && (r = t, s = !0), (s || e) && i._whileplaying(t, o, o, o, o)),
                s
            },
            this._get_html5_duration = function() {
                var e = i._iO;
                return (e = i._a && i._a.duration ? 1e3 * i._a.duration: e && e.duration ? e.duration: null) && !isNaN(e) && Infinity !== e ? e: null
            },
            this._apply_loop = function(e, t) {
                e.loop = 1 < t ? "loop": ""
            },
            this._setup_html5 = function(e) {
                e = k(i._iO, e);
                var t = Nt ? a: i._a,
                n = decodeURI(e.url),
                r;
                Nt ? n === decodeURI(Ct) && (r = !0) : n === decodeURI(E) && (r = !0);
                if (t) {
                    if (t._s) if (Nt) t._s && t._s.playState && !r && t._s.stop();
                    else if (!Nt && n === decodeURI(E)) return i._apply_loop(t, e.loops),
                    t;
                    r || (s(!1), t.src = e.url, Ct = E = i.url = e.url, t._called_load = !1)
                } else i._a = e.autoLoad || e.autoPlay ? new Audio(e.url) : Ft && 10 > opera.version() ? new Audio(null) : new Audio,
                t = i._a,
                t._called_load = !1,
                Nt && (a = t);
                return i.isHTML5 = !0,
                i._a = t,
                t._s = i,
                o(),
                i._apply_loop(t, e.loops),
                e.autoLoad || e.autoPlay ? i.load() : (t.autobuffer = !1, t.preload = "auto"),
                t
            },
            o = function() {
                if (i._a._added_events) return ! 1;
                var e;
                i._a._added_events = !0;
                for (e in Ot) Ot.hasOwnProperty(e) && i._a && i._a.addEventListener(e, Ot[e], !1);
                return ! 0
            },
            l = function() {
                var e;
                i._a._added_events = !1;
                for (e in Ot) Ot.hasOwnProperty(e) && i._a && i._a.removeEventListener(e, Ot[e], !1)
            },
            this._onload = function(e) {
                var t = !!e || !i.isHTML5 && 8 === b && i.duration;
                return i.loaded = t,
                i.readyState = t ? 3 : 2,
                i._onbufferchange(0),
                i._iO.onload && Mt(i,
                function() {
                    i._iO.onload.apply(i, [t])
                }),
                !0
            },
            this._onbufferchange = function(e) {
                return 0 === i.playState || e && i.isBuffering || !e && !i.isBuffering ? !1 : (i.isBuffering = 1 === e, i._iO.onbufferchange && i._iO.onbufferchange.apply(i), !0)
            },
            this._onsuspend = function() {
                return i._iO.onsuspend && i._iO.onsuspend.apply(i),
                !0
            },
            this._onfailure = function(e, t, n) {
                i.failures++,
                i._iO.onfailure && 1 === i.failures && i._iO.onfailure(i, e, t, n)
            },
            this._onfinish = function() {
                var e = i._iO.onfinish;
                i._onbufferchange(0),
                i._resetOnPosition(0),
                i.instanceCount && (i.instanceCount--, i.instanceCount || (y(), i.playState = 0, i.paused = !1, i.instanceCount = 0, i.instanceOptions = {},
                i._iO = {},
                c(), i.isHTML5 && (i.position = 0)), (!i.instanceCount || i._iO.multiShotEvents) && e && Mt(i,
                function() {
                    e.apply(i)
                }))
            },
            this._whileloading = function(e, t, n, r) {
                var s = i._iO;
                i.bytesLoaded = e,
                i.bytesTotal = t,
                i.duration = Math.floor(n),
                i.bufferLength = r,
                i.durationEstimate = !i.isHTML5 && !s.isMovieStar ? s.duration ? i.duration > s.duration ? i.duration: s.duration: parseInt(i.bytesTotal / i.bytesLoaded * i.duration, 10) : i.duration,
                i.isHTML5 || (i.buffered = [{
                    start: 0,
                    end: i.duration
                }]),
                (3 !== i.readyState || i.isHTML5) && s.whileloading && s.whileloading.apply(i)
            },
            this._whileplaying = function(e, n, r, s, o) {
                var u = i._iO;
                return isNaN(e) || null === e ? !1 : (i.position = Math.max(0, e), i._processOnPosition(), !i.isHTML5 && 8 < b && (u.usePeakData && n !== t && n && (i.peakData = {
                    left: n.leftPeak,
                    right: n.rightPeak
                }), u.useWaveformData && r !== t && r && (i.waveformData = {
                    left: r.split(","),
                    right: s.split(",")
                }), u.useEQData && o !== t && o && o.leftEQ && (e = o.leftEQ.split(","), i.eqData = e, i.eqData.left = e, o.rightEQ !== t && o.rightEQ && (i.eqData.right = o.rightEQ.split(",")))), 1 === i.playState && (!i.isHTML5 && 8 === b && !i.position && i.isBuffering && i._onbufferchange(0), u.whileplaying && u.whileplaying.apply(i)), !0)
            },
            this._oncaptiondata = function(e) {
                i.captiondata = e,
                i._iO.oncaptiondata && i._iO.oncaptiondata.apply(i, [e])
            },
            this._onmetadata = function(e, t) {
                var n = {},
                r, s;
                r = 0;
                for (s = e.length; r < s; r++) n[e[r]] = t[r];
                i.metadata = n,
                i._iO.onmetadata && i._iO.onmetadata.apply(i)
            },
            this._onid3 = function(e, t) {
                var n = [],
                r,
                s;
                r = 0;
                for (s = e.length; r < s; r++) n[e[r]] = t[r];
                i.id3 = k(i.id3, n),
                i._iO.onid3 && i._iO.onid3.apply(i)
            },
            this._onconnect = function(e) {
                e = 1 === e;
                if (i.connected = e) i.failures = 0,
                it(i.id) && (i.getAutoPlay() ? i.play(t, i.getAutoPlay()) : i._iO.autoLoad && i.load()),
                i._iO.onconnect && i._iO.onconnect.apply(i, [e])
            },
            this._ondataerror = function(e) {
                0 < i.playState && i._iO.ondataerror && i._iO.ondataerror.apply(i)
            }
        },
        z = function() {
            return v.body || v._docElement || v.getElementsByTagName("div")[0]
        },
        c = function(e) {
            return v.getElementById(e)
        },
        k = function(e, n) {
            var r = e || {},
            i, s;
            i = n === t ? u.defaultOptions: n;
            for (s in i) i.hasOwnProperty(s) && r[s] === t && (r[s] = "object" != typeof i[s] || null === i[s] ? i[s] : k(r[s], i[s]));
            return r
        },
        Mt = function(t, n) { ! t.isHTML5 && 8 === b ? e.setTimeout(n, 0) : n()
        },
        A = {
            onready: 1,
            ontimeout: 1,
            defaultOptions: 1,
            flash9Options: 1,
            movieStarOptions: 1
        },
        L = function(e, n) {
            var r, i = !0,
            s = n !== t,
            o = u.setupOptions;
            for (r in e) if (e.hasOwnProperty(r)) if ("object" != typeof e[r] || null === e[r] || e[r] instanceof Array || e[r] instanceof RegExp) s && A[n] !== t ? u[n][r] = e[r] : o[r] !== t ? (u.setupOptions[r] = e[r], u[r] = e[r]) : A[r] === t ? i = !1 : u[r] instanceof Function ? u[r].apply(u, e[r] instanceof Array ? e[r] : [e[r]]) : u[r] = e[r];
            else {
                if (A[r] !== t) return L(e[r], r);
                i = !1
            }
            return i
        },
        xt = function() {
            function t(e) {
                e = Tt.call(e);
                var t = e.length;
                return r ? (e[1] = "on" + e[1], 3 < t && e.pop()) : 3 === t && e.push(!1),
                e
            }
            function n(e, t) {
                var n = e.shift(),
                s = [i[t]];
                r ? n[s](e[0], e[1]) : n[s].apply(n, e)
            }
            var r = e.attachEvent,
            i = {
                add: r ? "attachEvent": "addEventListener",
                remove: r ? "detachEvent": "removeEventListener"
            };
            return {
                add: function() {
                    n(t(arguments), "add")
                },
                remove: function() {
                    n(t(arguments), "remove")
                }
            }
        } (),
        Ot = {
            abort: s(function() {}),
            canplay: s(function() {
                var e = this._s,
                n;
                if (e._html5_canplay) return ! 0;
                e._html5_canplay = !0,
                e._onbufferchange(0),
                n = e._iO.position !== t && !isNaN(e._iO.position) ? e._iO.position / 1e3: null;
                if (e.position && this.currentTime !== n) try {
                    this.currentTime = n
                } catch(r) {}
                e._iO._oncanplay && e._iO._oncanplay()
            }),
            canplaythrough: s(function() {
                var e = this._s;
                e.loaded || (e._onbufferchange(0), e._whileloading(e.bytesLoaded, e.bytesTotal, e._get_html5_duration()), e._onload(!0))
            }),
            ended: s(function() {
                this._s._onfinish()
            }),
            error: s(function() {
                this._s._onload(!1)
            }),
            loadeddata: s(function() {
                var e = this._s; ! e._loaded && !jt && (e.duration = e._get_html5_duration())
            }),
            loadedmetadata: s(function() {}),
            loadstart: s(function() {
                this._s._onbufferchange(1)
            }),
            play: s(function() {
                this._s._onbufferchange(0)
            }),
            playing: s(function() {
                this._s._onbufferchange(0)
            }),

            progress: s(function(e) {
                var t = this._s,
                n, r, i = 0,
                i = e.target.buffered;
                n = e.loaded || 0;
                var s = e.total || 1;
                t.buffered = [];
                if (i && i.length) {
                    n = 0;
                    for (r = i.length; n < r; n++) t.buffered.push({
                        start: 1e3 * i.start(n),
                        end: 1e3 * i.end(n)
                    });
                    i = 1e3 * (i.end(0) - i.start(0)),
                    n = Math.min(1, i / (1e3 * e.target.duration))
                }
                isNaN(n) || (t._onbufferchange(0), t._whileloading(n, s, t._get_html5_duration()), n && s && n === s && Ot.canplaythrough.call(this, e))
            }),
            ratechange: s(function() {}),
            suspend: s(function(e) {
                var t = this._s;
                Ot.progress.call(this, e),
                t._onsuspend()
            }),
            stalled: s(function() {}),
            timeupdate: s(function() {
                this._s._onTimer()
            }),
            waiting: s(function() {
                this._s._onbufferchange(1)
            })
        },
        gt = function(e) {
            return ! e || !e.type && !e.url && !e.serverURL ? !1 : e.serverURL || e.type && i(e.type) ? !1 : e.type ? yt({
                type: e.type
            }) : yt({
                url: e.url
            }) || u.html5Only || e.url.match(/data\:/i)
        },
        wt = function(e) {
            var t;
            return e && (t = jt && !Dt ? null: It ? "about:blank": null, e.src = t, void 0 !== e._called_unload && (e._called_load = !1)),
            Nt && (Ct = null),
            t
        },
        yt = function(e) {
            if (!u.useHTML5Audio || !u.hasHTML5) return ! 1;
            var n = e.url || null;
            e = e.type || null;
            var r = u.audioFormats,
            s;
            if (e && u.html5[e] !== t) return u.html5[e] && !i(e);
            if (!bt) {
                bt = [];
                for (s in r) r.hasOwnProperty(s) && (bt.push(s), r[s].related && (bt = bt.concat(r[s].related)));
                bt = RegExp("\\.(" + bt.join("|") + ")(\\?.*)?$", "i")
            }
            return s = n ? n.toLowerCase().match(bt) : null,
            !s || !s.length ? e && (n = e.indexOf(";"), s = ( - 1 !== n ? e.substr(0, n) : e).substr(6)) : s = s[1],
            s && u.html5[s] !== t ? n = u.html5[s] && !i(s) : (e = "audio/" + s, n = u.html5.canPlayType({
                type: e
            }), n = (u.html5[s] = n) && u.html5[e] && !i(e)),
            n
        },
        St = function() {
            function e(e) {
                var t, r, i = t = !1;
                if (!n || "function" != typeof n.canPlayType) return t;
                if (e instanceof Array) {
                    t = 0;
                    for (r = e.length; t < r; t++) if (u.html5[e[t]] || n.canPlayType(e[t]).match(u.html5Test)) i = !0,
                    u.html5[e[t]] = !0,
                    u.flash[e[t]] = !!e[t].match(Xt);
                    t = i
                } else e = n && "function" == typeof n.canPlayType ? n.canPlayType(e) : !1,
                t = !!e && !!e.match(u.html5Test);
                return t
            }
            if (!u.useHTML5Audio || !u.hasHTML5) return vt = u.html5.usingFlash = !0,
            !1;
            var n = Audio !== t ? Ft && 10 > opera.version() ? new Audio(null) : new Audio: null,
            r,
            i,
            s = {},
            o;
            o = u.audioFormats;
            for (r in o) if (o.hasOwnProperty(r) && (i = "audio/" + r, s[r] = e(o[r].type), s[i] = s[r], r.match(Xt) ? (u.flash[r] = !0, u.flash[i] = !0) : (u.flash[r] = !1, u.flash[i] = !1), o[r] && o[r].related)) for (i = o[r].related.length - 1; 0 <= i; i--) s["audio/" + o[r].related[i]] = s[r],
            u.html5[o[r].related[i]] = s[r],
            u.flash[o[r].related[i]] = s[r];
            return s.canPlayType = n ? e: null,
            u.html5 = k(u.html5, s),
            u.html5.usingFlash = mt(),
            vt = u.html5.usingFlash,
            !0
        },
        j = {},
        Z = function() {},
        nt = function(e) {
            return 8 === b && 1 < e.loops && e.stream && (e.stream = !1),
            e
        },
        rt = function(e, t) {
            return e && !e.usePolicyFile && (e.onid3 || e.usePeakData || e.useWaveformData || e.useEQData) && (e.usePolicyFile = !0),
            e
        },
        m = function() {
            return ! 1
        },
        J = function(e) {
            for (var t in e) e.hasOwnProperty(t) && "function" == typeof e[t] && (e[t] = m)
        },
        K = function(e) {
            e === t && (e = !1),
            (T || e) && u.disable(e)
        },
        Q = function(e) {
            var t = null;
            if (e) if (e.match(/\.swf(\?.*)?$/i)) {
                if (t = e.substr(e.toLowerCase().lastIndexOf(".swf?") + 4)) return e
            } else e.lastIndexOf("/") !== e.length - 1 && (e += "/");
            return e = (e && -1 !== e.lastIndexOf("/") ? e.substr(0, e.lastIndexOf("/") + 1) : "./") + u.movieURL,
            u.noSWFCache && (e += "?ts=" + (new Date).getTime()),
            e
        },
        H = function() {
            b = parseInt(u.flashVersion, 10),
            8 !== b && 9 !== b && (u.flashVersion = b = 8);
            var e = u.debugMode || u.debugFlash ? "_debug.swf": ".swf";
            u.useHTML5Audio && !u.html5Only && u.audioFormats.mp4.required && 9 > b && (u.flashVersion = b = 9),
            u.version = u.versionNumber + (u.html5Only ? " (HTML5-only mode)": 9 === b ? " (AS3/Flash 9)": " (AS2/Flash 8)"),
            8 < b ? (u.defaultOptions = k(u.defaultOptions, u.flash9Options), u.features.buffering = !0, u.defaultOptions = k(u.defaultOptions, u.movieStarOptions), u.filePatterns.flash9 = RegExp("\\.(mp3|" + Kt.join("|") + ")(\\?.*)?$", "i"), u.features.movieStar = !0) : u.features.movieStar = !1,
            u.filePattern = u.filePatterns[8 !== b ? "flash9": "flash8"],
            u.movieURL = (8 === b ? "soundmanager2.swf": "soundmanager2_flash9.swf").replace(".swf", e),
            u.features.peakData = u.features.waveformData = u.features.eqData = 8 < b
        },
        V = function(e, t) {
            if (!f) return ! 1;
            f._setPolling(e, t)
        },
        $ = function() {},
        it = this.getSoundById,
        tt = function() {
            var e = [];
            return u.debugMode && e.push("sm2_debug"),
            u.debugFlash && e.push("flash_debug"),
            u.useHighPerformance && e.push("high_performance"),
            e.join(" ")
        },
        et = function() {
            Z("fbHandler");
            var e = u.getMoviePercent(),
            t = {
                type: "FLASHBLOCK"
            };
            if (u.html5Only) return ! 1;
            u.ok() ? u.oMC && (u.oMC.className = [tt(), "movieContainer", "swf_loaded" + (u.didFlashBlock ? " swf_unblocked": "")].join(" ")) : (vt && (u.oMC.className = tt() + " movieContainer " + (null === e ? "swf_timedout": "swf_error")), u.didFlashBlock = !0, M({
                type: "ontimeout",
                ignoreInit: !0,
                error: t
            }), X(t))
        },
        O = function(e, n, r) {
            w[e] === t && (w[e] = []),
            w[e].push({
                method: n,
                scope: r || null,
                fired: !1
            })
        },
        M = function(e) {
            e || (e = {
                type: u.ok() ? "onready": "ontimeout"
            });
            if (!x && e && !e.ignoreInit || "ontimeout" === e.type && (u.ok() || T && !e.ignoreInit)) return ! 1;
            var t = {
                success: e && e.ignoreInit ? u.ok() : !T
            },
            n = e && e.type ? w[e.type] || [] : [],
            r = [],
            i,
            t = [t],
            s = vt && !u.ok();
            e.error && (t[0].error = e.error),
            e = 0;
            for (i = n.length; e < i; e++) ! 0 !== n[e].fired && r.push(n[e]);
            if (r.length) {
                e = 0;
                for (i = r.length; e < i; e++) r[e].scope ? r[e].method.apply(r[e].scope, t) : r[e].method.apply(this, t),
                s || (r[e].fired = !0)
            }
            return ! 0
        },
        _ = function() {
            e.setTimeout(function() {
                u.useFlashBlock && et(),
                M(),
                "function" == typeof u.onload && u.onload.apply(e),
                u.waitForWindowLoad && xt.add(e, "load", _)
            },
            1)
        },
        Lt = function() {
            if (kt !== t) return kt;
            var n = !1,
            r = navigator,
            i = r.plugins,
            s, o = e.ActiveXObject;
            if (i && i.length)(r = r.mimeTypes) && r["application/x-shockwave-flash"] && r["application/x-shockwave-flash"].enabledPlugin && r["application/x-shockwave-flash"].enabledPlugin.description && (n = !0);
            else if (o !== t && !p.match(/MSAppHost/i)) {
                try {
                    s = new o("ShockwaveFlash.ShockwaveFlash")
                } catch(u) {
                    s = null
                }
                n = !!s
            }
            return kt = n
        },
        mt = function() {
            var e, t, n = u.audioFormats;
            Dt && p.match(/os (1|2|3_0|3_1)/i) ? (u.hasHTML5 = !1, u.html5Only = !0, u.oMC && (u.oMC.style.display = "none")) : u.useHTML5Audio && (!u.html5 || !u.html5.canPlayType) && (u.hasHTML5 = !1);
            if (u.useHTML5Audio && u.hasHTML5) for (t in dt = !0, n) n.hasOwnProperty(t) && n[t].required && (u.html5.canPlayType(n[t].type) ? u.preferFlash && (u.flash[t] || u.flash[n[t].type]) && (e = !0) : (dt = !1, e = !0));
            return u.ignoreFlash && (e = !1, dt = !0),
            u.html5Only = u.hasHTML5 && u.useHTML5Audio && !e,
            !u.html5Only
        },
        ht = function(e) {
            var t, n, r = 0;
            if (e instanceof Array) {
                t = 0;
                for (n = e.length; t < n; t++) if (e[t] instanceof Object) {
                    if (u.canPlayMIME(e[t].type)) {
                        r = t;
                        break
                    }
                } else if (u.canPlayURL(e[t])) {
                    r = t;
                    break
                }
                e[r].url && (e[r] = e[r].url),
                e = e[r]
            }
            return e
        },
        ut = function(e) {
            e._hasTimer || (e._hasTimer = !0, !qt && u.html5PollingInterval && (null === ct && 0 === lt && (ct = setInterval(ft, u.html5PollingInterval)), lt++))
        },
        at = function(e) {
            e._hasTimer && (e._hasTimer = !1, !qt && u.html5PollingInterval && lt--)
        },
        ft = function() {
            var e;
            if (null !== ct && !lt) return clearInterval(ct),
            ct = null,
            !1;
            for (e = u.soundIDs.length - 1; 0 <= e; e--) u.sounds[u.soundIDs[e]].isHTML5 && u.sounds[u.soundIDs[e]]._hasTimer && u.sounds[u.soundIDs[e]]._onTimer()
        },
        X = function(n) {
            n = n !== t ? n: {},
            "function" == typeof u.onerror && u.onerror.apply(e, [{
                type: n.type !== t ? n.type: null
            }]),
            n.fatal !== t && n.fatal && u.disable()
        },
        At = function() {
            if (!Rt || !Lt()) return ! 1;
            var e = u.audioFormats,
            t, n;
            for (n in e) if (e.hasOwnProperty(n) && ("mp3" === n || "mp4" === n)) if (u.html5[n] = !1, e[n] && e[n].related) for (t = e[n].related.length - 1; 0 <= t; t--) u.html5[e[n].related[t]] = !1
        },
        this._setSandboxType = function(e) {},
        this._externalInterfaceOK = function(e) {
            if (u.swfLoaded) return ! 1;
            u.swfLoaded = !0,
            zt = !1,
            Rt && At(),
            setTimeout(y, Ht ? 100 : 1)
        },
        W = function(e, n) {
            function r(e, t) {
                return '<param name="' + e + '" value="' + t + '" />'
            }
            if (E && S) return ! 1;
            if (u.html5Only) return H(),
            u.oMC = c(u.movieID),
            y(),
            S = E = !0,
            !1;
            var i = n || u.url,
            s = u.altURL || i,
            o = z(),
            a = tt(),
            f = null,
            f = v.getElementsByTagName("html")[0],
            l,
            d,
            m,
            f = f && f.dir && f.dir.match(/rtl/i);
            e = e === t ? u.id: e,
            H(),
            u.url = Q(Vt ? i: s),
            n = u.url,
            u.wmode = !u.wmode && u.useHighPerformance ? "transparent": u.wmode,
            null !== u.wmode && (p.match(/msie 8/i) || !Ht && !u.useHighPerformance) && navigator.platform.match(/win32|win64/i) && (pt.push(j.spcWmode), u.wmode = null),
            o = {
                name: e,
                id: e,
                src: n,
                quality: "high",
                allowScriptAccess: u.allowScriptAccess,
                bgcolor: u.bgColor,
                pluginspage: $t + "www.macromedia.com/go/getflashplayer",
                title: "JS/Flash audio component (SoundManager 2)",
                type: "application/x-shockwave-flash",
                wmode: u.wmode,
                hasPriority: "true"
            },
            u.debugFlash && (o.FlashVars = "debug=1"),
            u.wmode || delete o.wmode;
            if (Ht) i = v.createElement("div"),
            d = ['<object id="' + e + '" data="' + n + '" type="' + o.type + '" title="' + o.title + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="' + $t + 'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">', r("movie", n), r("AllowScriptAccess", u.allowScriptAccess), r("quality", o.quality), u.wmode ? r("wmode", u.wmode) : "", r("bgcolor", u.bgColor), r("hasPriority", "true"), u.debugFlash ? r("FlashVars", o.FlashVars) : "", "</object>"].join("");
            else for (l in i = v.createElement("embed"), o) o.hasOwnProperty(l) && i.setAttribute(l, o[l]);
            $(),
            a = tt();
            if (o = z()) if (u.oMC = c(u.movieID) || v.createElement("div"), u.oMC.id) m = u.oMC.className,
            u.oMC.className = (m ? m + " ": "movieContainer") + (a ? " " + a: ""),
            u.oMC.appendChild(i),
            Ht && (l = u.oMC.appendChild(v.createElement("div")), l.className = "sm2-object-box", l.innerHTML = d),
            S = !0;
            else {
                u.oMC.id = u.movieID,
                u.oMC.className = "movieContainer " + a,
                l = a = null,
                u.useFlashBlock || (u.useHighPerformance ? a = {
                    position: "fixed",
                    width: "8px",
                    height: "8px",
                    bottom: "0px",
                    left: "0px",
                    overflow: "hidden"
                }: (a = {
                    position: "absolute",
                    width: "6px",
                    height: "6px",
                    top: "-9999px",
                    left: "-9999px"
                },
                f && (a.left = Math.abs(parseInt(a.left, 10)) + "px"))),
                Bt && (u.oMC.style.zIndex = 1e4);
                if (!u.debugFlash) for (m in a) a.hasOwnProperty(m) && (u.oMC.style[m] = a[m]);
                try {
                    Ht || u.oMC.appendChild(i),
                    o.appendChild(u.oMC),
                    Ht && (l = u.oMC.appendChild(v.createElement("div")), l.className = "sm2-object-box", l.innerHTML = d),
                    S = !0
                } catch(g) {
                    throw Error(Z("domError") + " \n" + g.toString())
                }
            }
            return E = !0
        },
        F = function() {
            return u.html5Only ? (W(), !1) : f || !u.url ? !1 : (f = u.getMovie(u.id), f || (G ? (Ht ? u.oMC.innerHTML = Y: u.oMC.appendChild(G), G = null, E = !0) : W(u.id, u.url), f = u.getMovie(u.id)), "function" == typeof u.oninitmovie && setTimeout(u.oninitmovie, 1), !0)
        },
        D = function() {
            setTimeout(P, 1e3)
        },
        P = function() {
            var t, n = !1;
            if (!u.url || st) return ! 1;
            st = !0,
            xt.remove(e, "load", D);
            if (zt && !Ut) return ! 1;
            x || (t = u.getMoviePercent(), 0 < t && 100 > t && (n = !0)),
            setTimeout(function() {
                t = u.getMoviePercent();
                if (n) return st = !1,
                e.setTimeout(D, 1),
                !1; ! x && Wt && (null === t ? u.useFlashBlock || 0 === u.flashLoadTimeout ? u.useFlashBlock && et() : !u.useFlashBlock && dt ? e.setTimeout(function() {
                    u.setup({
                        preferFlash: !1
                    }).reboot(),
                    u.didFlashBlock = !0,
                    u.beginDelayedInit()
                },
                1) : M({
                    type: "ontimeout",
                    ignoreInit: !0
                }) : 0 !== u.flashLoadTimeout && K(!0))
            },
            u.flashLoadTimeout)
        },
        B = function() {
            return Ut || !zt ? (xt.remove(e, "focus", B), !0) : (Ut = Wt = !0, st = !1, D(), xt.remove(e, "focus", B), !0)
        },
        C = function(t) {
            if (x) return ! 1;
            if (u.html5Only) return x = !0,
            _(),
            !0;
            var n = !0,
            r;
            if (!u.useFlashBlock || !u.flashLoadTimeout || u.getMoviePercent()) x = !0,
            T && (r = {
                type: !kt && vt ? "NO_FLASH": "INIT_TIMEOUT"
            });
            if (T || t) u.useFlashBlock && u.oMC && (u.oMC.className = tt() + " " + (null === u.getMoviePercent() ? "swf_timedout": "swf_error")),
            M({
                type: "ontimeout",
                error: r,
                ignoreInit: !0
            }),
            X(r),
            n = !1;
            return T || (u.waitForWindowLoad && !N ? xt.add(e, "load", _) : _()),
            n
        },
        g = function() {
            var e, n = u.setupOptions;
            for (e in n) n.hasOwnProperty(e) && (u[e] === t ? u[e] = n[e] : u[e] !== n[e] && (u.setupOptions[e] = u[e]))
        },
        y = function() {
            if (x) return ! 1;
            if (u.html5Only) return x || (xt.remove(e, "load", u.beginDelayedInit), u.enabled = !0, C()),
            !0;
            F();
            try {
                f._externalInterfaceTest(!1),
                V(!0, u.flashPollingInterval || (u.useHighPerformance ? 10 : 50)),
                u.debugMode || f._disableDebug(),
                u.enabled = !0,
                u.html5Only || xt.add(e, "unload", m)
            } catch(t) {
                return X({
                    type: "JS_TO_FLASH_EXCEPTION",
                    fatal: !0
                }),
                K(!0),
                C(),
                !1
            }
            return C(),
            xt.remove(e, "load", u.beginDelayedInit),
            !0
        },
        q = function() {
            return U ? !1 : (U = !0, g(), $(), !kt && u.hasHTML5 && u.setup({
                useHTML5Audio: !0,
                preferFlash: !1
            }), St(), !kt && vt && (pt.push(j.needFlash), u.setup({
                flashLoadTimeout: 1
            })), v.removeEventListener && v.removeEventListener("DOMContentLoaded", q, !1), F(), !0)
        },
        Et = function() {
            return "complete" === v.readyState && (q(), v.detachEvent("onreadystatechange", Et)),
            !0
        },
        R = function() {
            N = !0,
            xt.remove(e, "load", R)
        },
        I = function() {
            qt && (u.setupOptions.useHTML5Audio = !0, u.setupOptions.preferFlash = !1, Dt || Pt && !p.match(/android\s2\.3/i)) && (Dt && (u.ignoreFlash = !0), Nt = !0)
        },
        I(),
        Lt(),
        xt.add(e, "focus", B),
        xt.add(e, "load", D),
        xt.add(e, "load", R),
        v.addEventListener ? v.addEventListener("DOMContentLoaded", q, !1) : v.attachEvent ? v.attachEvent("onreadystatechange", Et) : X({
            type: "NO_DOM2_EVENTS",
            fatal: !0
        })
    }
    var r = null;
    if (void 0 === e.SM2_DEFER || !SM2_DEFER) r = new n;
    e.SoundManager = n,
    e.soundManager = r
})(window);