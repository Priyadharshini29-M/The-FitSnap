<?php require __DIR__ . "/lib/bootstrap.php"; header("Cache-Control: no-cache, must-revalidate"); ?>
<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= e('site.title') ?></title>
    <meta name="description" content="<?= e('site.description') ?>" />
    <link rel="icon" type="image/png" href="<?= img('brand.favicon') ?>" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&amp;family=Playfair+Display:ital,wght@0,700;1,700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#B8D9FC",
                        "on-primary": "#ffffff",
                        "primary-container": "#FEB8D7",
                        "on-primary-container": "#111111",
                        "brand-blue": "#B8D9FC",
                        "white": "#2B2440",
                        "background": "#FFF4F9", // soft blush canvas
                        "surface": "#FFE8F2",
                        "on-surface": "#2B2440",
                        "on-surface-variant": "#5C5675",
                        "outline": "#8A84A3",
                        "outline-variant": "#E3DDF0",
                    },
                    "fontFamily": {
                        "manrope": ["Poppins", "sans-serif"],
                        "serif": ["Playfair Display", "serif"]
                    },
                    "spacing": {
                        "margin-desktop": "80px",
                        "margin-mobile": "24px",
                        "gutter": "32px",
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .serif-italic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        .aura-glow {
            background: radial-gradient(circle at 35% 40%, rgba(254,184,215,0.30) 0%, rgba(184,217,252,0.16) 45%, transparent 72%);
            filter: blur(60px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 12px 34px -14px rgba(184, 217, 252, 0.9);
            backdrop-filter: blur(6px);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(254, 184, 215, 0.55);
        }

        .text-balance {
            text-wrap: balance;
        }

        /* Custom scrollbar for feature horizontal scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .editorial-heading {
            letter-spacing: -0.04em;
            line-height: 0.9;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }



        /* Live try-on demo (desktop + mobile loop, 5 steps mirroring the real app) */
        .tryon-demo .layer {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.7s ease, filter 0.7s ease;
        }

        .tryon-demo[data-step="0"] .l-garment,
        .tryon-demo[data-step="1"] .l-shopper,
        .tryon-demo[data-step="2"] .l-shopper,
        .tryon-demo[data-step="3"] .l-result,
        .tryon-demo[data-step="4"] .l-result {
            opacity: 1;
        }

        .tryon-demo[data-step="3"] .l-result {
            filter: blur(14px) saturate(0.8);
            transform: scale(1.05);
        }

        .tryon-demo .only {
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: opacity 0.22s ease, transform 0.22s ease, visibility 0s linear 0.22s;
            pointer-events: none;
        }

        .tryon-demo[data-step="0"] .only-0,
        .tryon-demo[data-step="1"] .only-1,
        .tryon-demo[data-step="2"] .only-2,
        .tryon-demo[data-step="3"] .only-3,
        .tryon-demo[data-step="4"] .only-4 {
            opacity: 1;
            visibility: visible;
            transform: none;
            transition: opacity 0.4s ease 0.25s, transform 0.4s ease 0.25s, visibility 0s linear 0.25s;
        }

        .tryon-demo .scan {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: #FEB8D7;
            box-shadow: 0 0 18px 6px rgba(254, 184, 215, 0.8);
            opacity: 0;
            top: 0;
        }

        .tryon-demo[data-step="2"] .scan {
            opacity: 1;
            animation: scanline 1.1s ease-in-out infinite;
        }

        @keyframes scanline {
            0% { top: 2%; }
            50% { top: 96%; }
            100% { top: 2%; }
        }

        .tryon-demo[data-step="0"] .tap-btn {
            animation: pulse-ring 1.2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.45); }
            100% { box-shadow: 0 0 0 12px rgba(0, 0, 0, 0); }
        }

        .tryon-demo[data-step="1"] .pick-btn {
            animation: pick 2.6s ease both;
        }

        @keyframes pick {
            0%, 35% { background: #fff; color: #111; }
            50%, 100% { background: #111; color: #fff; }
        }

        .tryon-demo[data-step="3"] .unlock-btn {
            animation: pulse-ring 1.2s ease-out infinite;
        }

        .tryon-demo .step-dot {
            opacity: 0.35;
            transition: opacity 0.3s ease;
        }

        .tryon-demo .step-dot i {
            display: block;
            height: 2px;
            background: rgba(43, 36, 64, 0.25);
            margin-bottom: 6px;
        }

        .tryon-demo[data-step="0"] .sd-0,
        .tryon-demo[data-step="1"] .sd-1,
        .tryon-demo[data-step="2"] .sd-2,
        .tryon-demo[data-step="3"] .sd-3,
        .tryon-demo[data-step="4"] .sd-4 {
            opacity: 1;
        }

        .tryon-demo[data-step="0"] .sd-0 i,
        .tryon-demo[data-step="1"] .sd-1 i,
        .tryon-demo[data-step="2"] .sd-2 i,
        .tryon-demo[data-step="3"] .sd-3 i,
        .tryon-demo[data-step="4"] .sd-4 i {
            background: #fff;
        }

        .tryon-demo .ba-handle {
            animation: ba 3.2s ease-in-out infinite alternate;
        }

        @keyframes ba {
            from { left: 25%; }
            to { left: 75%; }
        }

        .tryon-demo .ba-after {
            animation: baclip 3.2s ease-in-out infinite alternate;
        }

        @keyframes baclip {
            from { clip-path: inset(0 0 0 25%); }
            to { clip-path: inset(0 0 0 75%); }
        }


        /* Real-time feel: mouse cursor on the laptop, finger taps on the phone */
        .tryon-demo .cursor {
            position: absolute;
            left: 90%;
            top: 92%;
            width: 20px;
            height: 20px;
            z-index: 30;
            pointer-events: none;
            transition: left 0.9s cubic-bezier(.4, 0, .2, 1), top 0.9s cubic-bezier(.4, 0, .2, 1);
            filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.35));
        }

        .tryon-demo .cursor::after,
        .tryon-demo .tap-dot::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 22px;
            height: 22px;
            margin: -9px 0 0 -9px;
            border-radius: 50%;
            border: 2px solid #111;
            opacity: 0;
        }

        .tryon-demo[data-step="0"] .cursor { left: 72%; top: 60%; }
        .tryon-demo[data-step="1"] .cursor { left: 56%; top: 40%; }
        .tryon-demo[data-step="2"] .cursor { left: 88%; top: 82%; }
        .tryon-demo[data-step="3"] .cursor { left: 72%; top: 88%; }
        .tryon-demo[data-step="4"] .cursor { left: 42%; top: 72%; }

        .tryon-demo[data-step="0"] .cursor::after { animation: click-0 0.5s ease 1.1s both; }
        .tryon-demo[data-step="1"] .cursor::after { animation: click-1 0.5s ease 1.1s both; }
        .tryon-demo[data-step="3"] .cursor::after { animation: click-3 0.5s ease 1.6s both; }
        .tryon-demo[data-step="4"] .cursor::after { animation: click-4 0.5s ease 1.4s both; }

        @keyframes click-0 { 0% { opacity: .9; transform: scale(.4); } 100% { opacity: 0; transform: scale(1.6); } }
        @keyframes click-1 { 0% { opacity: .9; transform: scale(.4); } 100% { opacity: 0; transform: scale(1.6); } }
        @keyframes click-3 { 0% { opacity: .9; transform: scale(.4); } 100% { opacity: 0; transform: scale(1.6); } }
        @keyframes click-4 { 0% { opacity: .9; transform: scale(.4); } 100% { opacity: 0; transform: scale(1.6); } }

        .tryon-demo .tap-dot {
            position: absolute;
            left: 50%;
            top: 88%;
            width: 0;
            height: 0;
            z-index: 30;
            pointer-events: none;
        }

        .tryon-demo[data-step="0"] .tap-dot { left: 50%; top: 87%; }
        .tryon-demo[data-step="1"] .tap-dot { left: 30%; top: 82%; }
        .tryon-demo[data-step="2"] .tap-dot { left: 50%; top: 60%; }
        .tryon-demo[data-step="3"] .tap-dot { left: 50%; top: 91%; }
        .tryon-demo[data-step="4"] .tap-dot { left: 50%; top: 85%; }

        .tryon-demo[data-step="0"] .tap-dot::after { animation: click-0 0.5s ease 0.9s both; }
        .tryon-demo[data-step="1"] .tap-dot::after { animation: click-1 0.5s ease 0.9s both; }
        .tryon-demo[data-step="3"] .tap-dot::after { animation: click-3 0.5s ease 1.5s both; }
        .tryon-demo[data-step="4"] .tap-dot::after { animation: click-4 0.5s ease 1.3s both; }

        .tryon-demo .caret::after {
            content: "";
            display: inline-block;
            width: 1px;
            height: 1em;
            background: currentColor;
            margin-left: 1px;
            vertical-align: -2px;
            animation: blink 0.8s steps(2) infinite;
        }

        @keyframes blink { 50% { opacity: 0; } }


        /* Staggered 3D device arrangement */
        .tryon-demo .laptop-tilt {
            transform: rotateY(9deg) rotateX(1.5deg);
            transform-origin: right center;
        }

        .tryon-demo .phone-tilt {
            transform: rotateY(-10deg) translateY(16px);
            transform-origin: left center;
            animation: phone-float 5s ease-in-out infinite;
            box-shadow: -14px 22px 38px rgba(43, 36, 64, 0.28);
        }

        @keyframes phone-float {
            0%, 100% { transform: rotateY(-10deg) translateY(16px); }
            50% { transform: rotateY(-10deg) translateY(6px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .tryon-demo .phone-tilt { animation: none; }
        }


        /* AI Studio: scroll-driven storytelling */
        .story-step {
            opacity: 0.32;
            transition: opacity 0.4s ease, transform 0.4s ease;
            transform: translateX(-6px);
        }

        .story-step.active {
            opacity: 1;
            transform: none;
        }

        .story-step .num {
            width: 2.25rem;
            height: 2.25rem;
            border: 1px solid rgba(43, 36, 64, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .story-step.active .num,
        .story-step.done .num {
            background: #FEB8D7;
            color: #111;
            border-color: #FEB8D7;
        }

        .story-step.done {
            opacity: 0.7;
            transform: none;
        }

        .stage-layer {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3.5rem 1.5rem 1.5rem;
            opacity: 0;
            transform: translateY(18px) scale(0.98);
            transition: opacity 0.5s ease, transform 0.5s ease;
            pointer-events: none;
        }

        #story-stage[data-step="0"] .L0,
        #story-stage[data-step="1"] .L1,
        #story-stage[data-step="2"] .L2,
        #story-stage[data-step="3"] .L3 {
            opacity: 1;
            transform: none;
        }

        .stage-grid {
            background-image: linear-gradient(rgba(43, 36, 64, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(43, 36, 64, 0.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .model-chip {
            transition: transform 0.4s ease, opacity 0.4s ease, outline-color 0.3s ease;
            opacity: 0.45;
            outline: 2px solid transparent;
            outline-offset: 3px;
        }

        #story-stage[data-step="1"] .model-chip.sel,
        #story-stage[data-step="2"] .model-chip.sel,
        #story-stage[data-step="3"] .model-chip.sel {
            opacity: 1;
            transform: translateY(-8px) scale(1.04);
            outline-color: #fff;
        }

        #story-stage[data-step="0"] .drop-card {
            animation: drop-in 0.9s cubic-bezier(.2, 1.2, .4, 1) both;
        }

        @keyframes drop-in {
            from { opacity: 0; transform: translateY(-50px) rotate(-6deg); }
            to { opacity: 1; transform: rotate(-2deg); }
        }

        .gen-scan {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #FEB8D7;
            box-shadow: 0 0 18px 6px rgba(254, 184, 215, 0.8);
        }

        .pub-pop {
            opacity: 0;
            transform: translateY(14px) scale(0.94);
            transition: opacity 0.5s ease, transform 0.5s cubic-bezier(.2, 1.2, .4, 1);
        }

        #story-stage[data-step="3"] .pub-pop {
            opacity: 1;
            transform: none;
        }

        #story-stage[data-step="3"] .pub-pop:nth-child(2) { transition-delay: 0.15s; }
        #story-stage[data-step="3"] .pub-pop:nth-child(3) { transition-delay: 0.3s; }

        /* AI Studio story v2: every feature */
        .story-step .story-body {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.4s ease;
        }

        .story-step.active .story-body {
            max-height: 8rem;
            opacity: 1;
        }

        .story-step .meta {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            opacity: 0.55;
        }

        #story-stage .Lwf,
        #story-stage .Llib {
            opacity: 0;
            transform: translateY(14px);
            pointer-events: none;
        }

        #story-stage:not([data-step="5"]) .Lwf,
        #story-stage[data-step="5"] .Llib {
            opacity: 1;
            transform: none;
        }

        .feat-chip {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .feat-chip.on {
            opacity: 1;
            transform: none;
        }

        .lib-tile {
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.45s ease, transform 0.45s cubic-bezier(.2, 1.3, .4, 1);
        }

        .lib-tile.on {
            opacity: 1;
            transform: none;
        }

        /* Revenue calculator (light) */
        .calc-range {
            -webkit-appearance: none;
            appearance: none;
            height: 6px;
            border-radius: 3px;
            outline: none;
            --p: 20%;
            background: linear-gradient(to right, #111 var(--p), #e5e5e5 var(--p));
        }

        .calc-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #111;
            border: 4px solid #fff;
            box-shadow: 0 0 0 1.5px #111, 0 4px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .calc-range::-moz-range-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #111;
            border: 4px solid #fff;
            box-shadow: 0 0 0 1.5px #111, 0 4px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .dot {
            background: #e5e5e5;
            transition: background 0.35s ease, transform 0.35s ease, border-color 0.35s ease;
        }

        #dot-grid .dot {
            aspect-ratio: 1 / 1;
            border-radius: 9999px;
        }

        .dot.buy {
            background: #111111;
        }

        .dot.extra {
            background: #ffffff;
            box-shadow: inset 0 0 0 2px #111;
            animation: dot-pulse 1.6s ease-in-out infinite;
        }

        @keyframes dot-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.18); }
        }

        @media (prefers-reduced-motion: reduce) {
            .dot.extra { animation: none; }
        }

        /* Gamified numbers */
        .stat-card .stat-badge {
            opacity: 0;
            transform: scale(0.6) translateY(-6px);
            transition: opacity 0.3s ease, transform 0.4s cubic-bezier(.2, 1.5, .4, 1);
        }

        .stat-card.unlocked {
            border-color: rgba(43, 36, 64, 0.6);
            box-shadow: 0 0 0 1px rgba(43, 36, 64, 0.25), 0 20px 50px -20px rgba(43, 36, 64, 0.25);
        }

        .stat-card.unlocked .stat-badge {
            opacity: 1;
            transform: none;
        }

        .stat-card.pop {
            animation: pop 0.5s ease;
        }

        .stat-ring {
            transition: stroke-dashoffset 0.1s linear;
        }

        /* Live feed + install card */
        .feed-row {
            animation: feed-in 0.55s cubic-bezier(.2, .9, .3, 1) both;
        }

        @keyframes feed-in {
            from { opacity: 0; transform: translateY(-18px); background: rgba(43, 36, 64, 0.18); }
            to { opacity: 1; transform: none; background: transparent; }
        }

        .install-card .ib-btn {
            animation: ib-btn 9s ease-in-out infinite;
        }

        .install-card .ib-block {
            animation: ib-block 9s ease-in-out infinite;
        }

        .install-card .ib-added {
            animation: ib-added 9s ease-in-out infinite;
        }

        .install-card .ib-s {
            opacity: 0.35;
        }

        .install-card .ib-s1 { animation: ib-step 9s ease-in-out infinite; animation-delay: 0s; }
        .install-card .ib-s2 { animation: ib-step 9s ease-in-out infinite; animation-delay: 1.4s; }
        .install-card .ib-s3 { animation: ib-step 9s ease-in-out infinite; animation-delay: 2.8s; }
        .install-card .ib-s4 { animation: ib-step 9s ease-in-out infinite; animation-delay: 4.2s; }

        @keyframes ib-step {
            0%, 8% { opacity: 0.35; }
            14%, 85% { opacity: 1; background: rgba(43, 36, 64, 0.08); }
            95%, 100% { opacity: 0.35; background: transparent; }
        }

        @keyframes ib-block {
            0%, 20% { opacity: 0.25; transform: translateX(-8px); }
            30%, 88% { opacity: 1; transform: none; }
            96%, 100% { opacity: 0.25; transform: translateX(-8px); }
        }

        @keyframes ib-added {
            0%, 32% { opacity: 0; }
            40%, 88% { opacity: 1; }
            96%, 100% { opacity: 0; }
        }

        @keyframes ib-btn {
            0%, 36% { opacity: 0; transform: translateY(10px) scale(0.96); }
            46%, 88% { opacity: 1; transform: none; }
            96%, 100% { opacity: 0; transform: translateY(10px) scale(0.96); }
        }

        @media (prefers-reduced-motion: reduce) {
            .feed-row, .install-card .ib-btn, .install-card .ib-block, .install-card .ib-added, .install-card .ib-s { animation: none; opacity: 1; }
        }

        /* Testimonials: infinite wave slider */
        .wave-mask {
            -webkit-mask-image: linear-gradient(to right, transparent 0, #000 8%, #000 92%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0, #000 8%, #000 92%, transparent 100%);
        }

        .wave-track {
            animation: wave-scroll 55s linear infinite;
        }

        .wave-mask:hover .wave-track,
        .wave-mask:hover .wave-inner {
            animation-play-state: paused;
        }

        .wave-card {
            display: block;
        }

        .wave-inner {
            animation: wave-bob 6s ease-in-out infinite;
            animation-delay: calc(var(--i) * -0.9s);
            min-height: 15rem;
        }

        @keyframes wave-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(calc(-50% - 0.75rem)); }
        }

        @keyframes wave-bob {
            0%, 100% { transform: translateY(-22px) rotate(-1deg); }
            50% { transform: translateY(22px) rotate(1deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .wave-track, .wave-inner { animation: none; }
            .wave-track { overflow-x: auto; }
        }

        /* Try it free */
        .tf-thumb {
            opacity: 0.55;
            outline: 2px solid transparent;
            outline-offset: 3px;
            transition: opacity 0.25s ease, outline-color 0.25s ease, transform 0.25s ease;
        }

        .tf-thumb:hover {
            opacity: 0.9;
            transform: translateY(-3px);
        }

        .tf-thumb.tf-sel {
            opacity: 1;
            outline-color: #FEB8D7;
        }

        .tf-scan {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: #FEB8D7;
            box-shadow: 0 0 18px 6px rgba(254, 184, 215, 0.8);
            animation: tf-scan 2.2s ease-in-out infinite;
        }

        @keyframes tf-scan {
            0%, 100% { top: 2%; }
            50% { top: 97%; }
        }

        .tf-pulse {
            animation: pop 1.4s ease-in-out infinite;
        }

        /* Why section: looping real-time before/after */
        .wipe-loop {
            animation: wipe-loop 7s ease-in-out infinite;
        }

        .scan-loop {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3px;
            left: 0;
            background: #FEB8D7;
            box-shadow: 0 0 18px 6px rgba(254, 184, 215, 0.8);
            animation: scan-x 7s ease-in-out infinite;
        }

        .fit-badge {
            animation: badge-in 7s ease-in-out infinite;
        }

        .doubt {
            animation: doubt-pulse 3.5s ease-in-out infinite;
        }

        .blink {
            animation: blink 1.2s steps(2) infinite;
        }

        @keyframes wipe-loop {
            0%, 8% { clip-path: inset(0 100% 0 0); }
            40%, 92% { clip-path: inset(0 0 0 0); }
            100% { clip-path: inset(0 100% 0 0); }
        }

        @keyframes scan-x {
            0%, 8% { left: 0; opacity: 1; }
            40% { left: calc(100% - 3px); opacity: 1; }
            41%, 100% { left: calc(100% - 3px); opacity: 0; }
        }

        @keyframes badge-in {
            0%, 40% { opacity: 0; transform: translateY(-6px) scale(0.9); }
            46%, 92% { opacity: 1; transform: none; }
            100% { opacity: 0; }
        }

        @keyframes doubt-pulse {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .wipe-loop, .scan-loop, .fit-badge, .doubt, .blink { animation: none; }
            .wipe-loop { clip-path: none; }
            .scan-loop { display: none; }
        }

        /* Scroll reveal + motion */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.8s cubic-bezier(.2, .7, .2, 1), transform 0.8s cubic-bezier(.2, .7, .2, 1);
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0;
            background: linear-gradient(90deg, #FEB8D7, #B8D9FC);
            z-index: 300;
        }

        .shimmer {
            position: relative;
            overflow: hidden;
        }

        .shimmer::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 30%, rgba(255, 255, 255, 0.7) 50%, transparent 70%);
            transform: translateX(-120%);
            animation: shimmer 3.5s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: translateX(-120%); }
            60%, 100% { transform: translateX(120%); }
        }

        @keyframes pop {
            0% { transform: scale(1); }
            40% { transform: scale(1.12); }
            100% { transform: scale(1); }
        }

        .pop {
            animation: pop 0.45s ease;
        }

        .bar-fill {
            transition: width 0.7s cubic-bezier(.2, .7, .2, 1);
        }

        details.faq summary {
            list-style: none;
            cursor: pointer;
        }

        details.faq summary::-webkit-details-marker {
            display: none;
        }

        details.faq[open] .faq-icon {
            transform: rotate(45deg);
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }

        .lift {
            transition: transform 0.4s ease, border-color 0.4s ease;
        }

        .lift:hover {
            transform: translateY(-6px);
            border-color: rgba(43, 36, 64, 0.35);
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
            .shimmer::after, .animate-float, .pop { animation: none; }
        }

        /* Responsive: bigger root size on large monitors, never scroll sideways */
        /* keep overflow on <body> only (html must stay visible, otherwise position:sticky breaks) */
        body { max-width: 100%; }

        /* 12-column grids use a 32px gap; 11 gaps would force 352px of width on phones */
        @media (max-width: 1023px) {
            .grid-cols-12 { column-gap: 0 !important; row-gap: 2rem; }
        }

        @media (min-width: 1920px) { html { font-size: 18px; } }
        @media (min-width: 2560px) { html { font-size: 22px; } }
        @media (min-width: 3200px) { html { font-size: 28px; } }

        @media (min-width: 1536px) {
            html body .max-w-\[1600px\] { max-width: 1840px; }
        }

        @media (min-width: 2560px) {
            html body .max-w-\[1600px\] { max-width: 2200px; }
        }

        /* Navbar turns white once the page is scrolled */
        .fc-card { background: linear-gradient(160deg, #ffffff, #F6FAFF); border: 1px solid rgba(254,184,215,.6); border-radius: 20px; transition: transform .35s, border-color .35s, box-shadow .35s; }
        .fc-card:hover { transform: translateY(-6px); border-color: rgba(43, 36, 64,.35); box-shadow: 0 20px 50px rgba(0,0,0,.5); }
        .fc-icon { transition: transform .35s; }
        .fc-card:hover .fc-icon { transform: rotate(-8deg) scale(1.08); }

        .jr-card { transition: transform .35s, box-shadow .35s, border-color .35s; }
        .jr-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.1); border-color: #111; }

        /* ---- Mobile-only refinements (desktop untouched) ---- */
        @media (max-width: 767px) {
            /* Numbers: 2x2 stat tiles */
            #numbers { padding-top: 3.5rem; padding-bottom: 3.5rem; }
            #numbers .grid { gap: 12px; }
            #numbers .grid > div { border: 1px solid rgba(43, 36, 64,.12); border-radius: 16px; padding: 22px 12px; background: rgba(43, 36, 64,.04); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; }
            #numbers .grid > div > p:first-child { font-size: 2.75rem; }
            #numbers .grid > div > p:last-child { font-size: .875rem; line-height: 1.4; color: rgba(43, 36, 64,.7); }

            /* AI Studio: step cards */
            #story-steps { display: flex; flex-direction: column; gap: 12px; }
            #story-steps .story-step { padding: 16px; border: 1px solid rgba(43, 36, 64,.12); border-radius: 16px; background: rgba(43, 36, 64,.04); align-items: flex-start; gap: 14px; opacity: 1; transform: none; }
            #story-steps .story-body { max-height: none; opacity: 1; }
            #story-steps .story-step .num { flex: 0 0 auto; width: 36px; height: 36px; border-radius: 50%; font-size: 12px; }
            #story-steps .story-step .block.text-lg { font-size: 1.05rem; }
            #story-steps .story-body { font-size: .875rem; }

            /* Product DNA: stacked comparison cards */
            #dna .grid.border-t { border-top: 0; display: flex; flex-direction: column; gap: 14px; }
            #dna .grid.border-t > div { border: 1px solid rgba(43, 36, 64,.12); border-radius: 16px; padding: 16px; grid-template-columns: 1fr 1fr; gap: 10px; background: rgba(43, 36, 64,.03); }
            #dna .grid.border-t > div > div { grid-column: auto; }
            #dna .grid.border-t > div > div:first-child { grid-column: 1 / -1; text-align: left; letter-spacing: .2em; font-size: 11px; padding-bottom: 10px; border-bottom: 1px solid rgba(43, 36, 64,.1); }
            #dna .grid.border-t > div > div:nth-child(n+2) { text-align: left; font-size: .9rem; padding: 10px 12px; border-radius: 10px; }
            #dna .grid.border-t > div > div:nth-child(2) { background: #fff; color: #111; }
            #dna .grid.border-t > div > div:nth-child(3) { background: rgba(43, 36, 64,.06); }
            #dna .grid.border-t > div > div:nth-child(n+2)::before { display: block; font-size: 9px; letter-spacing: .2em; text-transform: uppercase; font-weight: 800; opacity: .55; margin-bottom: 4px; }
            #dna .grid.border-t > div > div:nth-child(2)::before { content: "Brix-Tryon"; }
            #dna .grid.border-t > div > div:nth-child(3)::before { content: "Other apps"; }
        }

        html { scroll-behavior: smooth; scroll-padding-top: 80px; }

        .nav-logo { filter: none; transition: filter .3s; }
        nav.scrolled .nav-logo { filter: none; }

        nav.scrolled {
            background: rgba(255, 245, 250, 0.94);
            backdrop-filter: blur(8px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.08), 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        nav.scrolled>div {
            height: 4.5rem;
        }

        nav.scrolled a,
        nav.scrolled button,
        nav.scrolled span {
            color: #2B2440;
        }

        nav.scrolled a:hover,
        nav.scrolled button:hover {
            color: #6b6b6b;
        }

        nav.scrolled .cta-button {
            background: #6FB3F7;
            color: #ffffff;
            box-shadow: none;
        }

        nav.scrolled .cta-button:hover {
            background: #4FA1F3;
            color: #ffffff;
        }

        /* Sections are compact (each fits within one screen) with tight gaps between them */
        @media (min-width: 1024px) {
            .screen {
                padding-top: 3rem !important;
                padding-bottom: 3rem !important;
            }

            .screen.screen-hero {
                min-height: 100vh;
                padding-top: 6rem !important;
            }
        }
    
        /* ===== Light pastel theme (palette: pink #FEB8D7, blue #B8D9FC) ===== */
        body { background: linear-gradient(180deg, #FFF4F9, #FFE8F2); }
        /* readable pink for text (the pastel itself is too light on white) */
        .text-primary-container, .group:hover .group-hover\:text-primary-container, .hover\:text-primary-container:hover { color: #C93B83 !important; }
        .text-primary-container\/60 { color: rgba(201, 59, 131, .75) !important; }
        /* things that are still dark: keep their text white */
        [class*="bg-black"], [class*="bg-neutral-9"], [class*="bg-neutral-8"], [class*="bg-neutral-7"] { color: #ffffff !important; }
        [class*="bg-black"] [class*="text-white"], [class*="bg-neutral-9"] [class*="text-white"], [class*="bg-neutral-8"] [class*="text-white"] { color: #ffffff !important; }
        .bg-primary-container, .bg-primary-container * { color: #2B2440 !important; }
        .hover\:bg-brand-blue:hover { background-color: #8EC3F8 !important; }
        /* buttons as in the app: solid blue, white text, rounded */
        .cta-button, #tf-go, #tf-cta, #accessForm button[type=submit] {
            border-radius: 12px !important; font-weight: 700; transition: background-color .2s, transform .2s, box-shadow .2s;
        }
        .cta-button.bg-primary-container, nav .cta-button, #accessForm button[type=submit] {
            background: #6FB3F7 !important; color: #ffffff !important; border: 1.5px solid #3F94EC !important; box-shadow: 0 10px 24px -10px rgba(111,179,247,.95) !important;
        }
        .cta-button.bg-primary-container *, #accessForm button[type=submit] * { color: #ffffff !important; }
        .cta-button.bg-primary-container:hover, nav .cta-button:hover, #accessForm button[type=submit]:hover { background: #4FA1F3 !important; transform: translateY(-1px); }
        /* secondary buttons: white with a soft pink border */
        .cta-button.glass-card, .cta-button[class*="border-white"], .cta-button[class*="border-background"] {
            background: #ffffff !important; color: #2B2440 !important; border: 1.5px solid #8EC3F8 !important;
        }
        #tf-go, #tf-cta { background: #6FB3F7 !important; color: #fff !important; border: 1.5px solid #3F94EC !important; }
        #tf-go *, #tf-cta * { color: #fff !important; }
        .cta-button.bg-background { background: #6FB3F7 !important; color: #ffffff !important; border: 1.5px solid #3F94EC !important; box-shadow: 0 10px 24px -10px rgba(111,179,247,.95) !important; }
        .bg-primary-container .select-none { color: rgba(255, 255, 255, .38) !important; }
        /* feature-card preview panels, article headers, picture frames: pastel instead of grey/black */
        .fc-card [class*="bg-black"] { background: linear-gradient(135deg, #FFE3EF, #E3F0FE) !important; border-color: #F3C4DA !important; }
        .fc-card [class*="bg-black"], .fc-card [class*="bg-black"] * { color: #2B2440 !important; }
        .fc-card [class*="bg-white/"] { background: rgba(255,255,255,.9) !important; }
        .fc-icon { background: #B8D9FC !important; }
        .lift .bg-gradient-to-br { background-image: linear-gradient(135deg, #FEB8D7, #B8D9FC) !important; }
        #ai-studio [class*="bg-neutral-8"], #try-free [class*="bg-neutral-9"], #try-free [class*="bg-neutral-8"], #live [class*="bg-neutral-8"] { background: #FFE8F2 !important; }
        #ai-studio [class*="bg-neutral-8"], #try-free [class*="bg-neutral-9"], #try-free [class*="bg-neutral-8"], #live [class*="bg-neutral-8"],
        #ai-studio [class*="bg-neutral-8"] *:not([class*="bg-black"]), #try-free [class*="bg-neutral-9"] *, #try-free [class*="bg-neutral-8"] *, #live [class*="bg-neutral-8"] *:not([class*="bg-black"]) { color: #2B2440 !important; }
        .wave-card .material-symbols-outlined { color: #F5B301; font-variation-settings: 'FILL' 1; }
        main p.text-lg:not(.font-800):not(.font-700):not(.tryon-demo *), main blockquote.text-lg { font-size: .875rem; line-height: 1.7; }
        .screen-hero p.text-lg:not(.tryon-demo *) { font-size: .95rem; }
        .shop-title { white-space: nowrap; font-size: clamp(2rem, 4.6vh, 3.1rem) !important; }
        .shop-title br { display: none; }
        main span.tracking-widest.text-sm { font-size: .75rem; }
        #ai-studio .story-body, #story-steps .story-body { font-size: .8rem; }
        @media (max-width: 1023px) { .shop-title { white-space: normal; } }
        .glass-card, .fc-card, .jr-card, .wave-inner { border-radius: 20px; }
        .glass-card.lift:hover, .fc-card:hover { box-shadow: 0 18px 40px -16px rgba(111,179,247,.55); }
        select, input, textarea { color-scheme: light; }

        /* AI Studio pinned screen: keep breathing room at the bottom, tighten on short screens */
        @media (min-width: 1024px) and (max-height: 900px) {
            #ai-studio h2 { font-size: clamp(2rem, 5.2vh, 3.2rem) !important; }
            #story-steps { gap: 0; }
            #story-steps > li + li { margin-top: .7rem; }
            #ai-studio .story-body { font-size: .8rem; line-height: 1.4; }
        }

        /* ===== Tidy / classic layout: even rhythm, readable headings, centred container ===== */
        .max-w-\[1600px\] { max-width: 1320px; }
        .editorial-heading { line-height: 1.14; letter-spacing: -0.02em; }
        main h2 { font-size: clamp(2rem, 3.3vw, 3.1rem) !important; line-height: 1.18 !important; }
        main h1 { line-height: 1.1 !important; }
        main h1, main h2 { font-weight: 500 !important; }
        main h2 .serif-italic { line-height: 1.1; }
        main h2 + p, main h2 + div { margin-top: .25rem; }
        @media (min-width: 1024px) {
            .screen:not(.screen-hero) { padding-top: 5.5rem !important; padding-bottom: 5.5rem !important; }
            .screen.screen-hero { padding-top: 7rem !important; padding-bottom: 5rem !important; }
        }
        @media (max-width: 1023px) {
            .screen:not(.screen-hero) { padding-top: 3.5rem !important; padding-bottom: 3.5rem !important; }
        }
        /* centred section headers: same distance to the content below */
        main section > div > .text-center[class*="mb-"] { margin-bottom: 3rem !important; }
        main section > div > .text-center > p.mx-auto { max-width: 40rem; }
        /* every card row stretches to one height */
        .grid > .glass-card, .grid > .fc-card, .grid > .jr-card { height: 100%; }

        /* blue buttons: bold white label with a white stroke */
        .cta-button.bg-primary-container, nav .cta-button, nav.scrolled .cta-button, #accessForm button[type=submit], #tf-go, #tf-cta, .cta-button.bg-background,
        .cta-button.bg-primary-container *, #accessForm button[type=submit] *, #tf-go *, #tf-cta * {
            color: #ffffff !important;
            font-weight: 500 !important;
            -webkit-text-stroke: .5px #ffffff;
            text-shadow: 0 1px 2px rgba(31, 111, 203, .45);
            letter-spacing: .14em;
        }
        .cta-button .material-symbols-outlined, #tf-go .material-symbols-outlined { -webkit-text-stroke: 0; text-shadow: none; color: #ffffff !important; }

        /* ===== Hero demo inside the laptop + phone mockup photo ===== */
        .devmock { max-width: 100%; }
        .dm-stage { position: relative; aspect-ratio: 1386 / 792; }
        .dm-frame, .dm-frame-phone { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; user-select: none; z-index: 6; filter: drop-shadow(0 22px 26px rgba(43, 36, 64, .2)); }
        .dm-frame-phone { display: none; }
        .dm-screen { position: absolute; overflow: hidden; background: #ffffff; z-index: 1; }
        .dm-laptop { left: 12.41%; top: 5.30%; width: 66.16%; height: 69.32%; border-radius: 3px; }
        .dm-phone { left: 80.73%; top: 29.55%; width: 17.53%; height: 66.41%; border-radius: 10% / 4.6%; }
        .dm-inner { position: absolute; left: 0; top: 0; transform-origin: 0 0; font-family: 'Poppins', sans-serif; color: #231d38; background: #ffffff; --f: 1; }
        .dm-laptop .dm-inner { --f: 1.15; }
        .dm-phone .dm-inner { --f: 1.6; }
        /* browser bar + store header (laptop) */
        .dm-bar { height: 26px; display: flex; align-items: center; gap: 6px; padding: 0 10px; background: #f6f3fa; border-bottom: 1px solid #e9e4f0; }
        .dm-bar i { width: 8px; height: 8px; border-radius: 50%; background: #d8d3e2; }
        .dm-url { margin-left: 8px; flex: 1; font-size: 10px; color: #6b6480; background: #fff; border-radius: 99px; padding: 2px 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dm-store { height: 26px; display: flex; align-items: center; justify-content: space-between; padding: 0 22px; border-bottom: 1px solid #f1ecf6; font-size: 9.5px; }
        .dm-store b { letter-spacing: .22em; font-weight: 700; }
        .dm-nav { display: flex; gap: 18px; color: #6b6480; font-weight: 500; }
        .dm-nav u { text-decoration: none; }
        .dm-store .material-symbols-outlined { font-size: 15px; }
        .dmp-top { height: 62px; padding-top: 38px; text-align: center; font-size: 11px; font-weight: 700; letter-spacing: .2em; border-bottom: 1px solid #f1ecf6; }
        .dm-body { position: relative; padding: 14px 22px 8px; display: flex; flex-direction: column; gap: 8px; height: calc(100% - 52px); }
        .dm-phone .dm-body { height: calc(100% - 62px); padding: 14px 8px 0; gap: 0; }
        /* the row: your photo + product = result */
        .dm-strip { display: flex; align-items: flex-start; justify-content: center; gap: 16px; }
        .dm-cell { width: 150px; text-align: center; }
        .dm-tile { position: relative; width: 150px; height: 200px; border-radius: 14px; overflow: hidden; background: #FFE8F2; border: 1px solid #F3C4DA; box-shadow: 0 12px 24px -14px rgba(201, 59, 131, .5); }
        .dm-tile .t-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; transition: opacity .6s ease, filter .6s ease, transform .6s ease; }
        .dm-cap { font-size: 9.5px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #6b6480; margin-top: 6px; }
        .dm-op { flex: none; align-self: flex-start; margin-top: 86px; width: 28px; height: 28px; border-radius: 50%; background: #FFE8F2; color: #C93B83; display: flex; align-items: center; justify-content: center; font-size: 18px; line-height: 1; font-weight: 700; }
        /* numbered tiles: 1 photo + 2 product = 3 result */
        .dm-tile::before { position: absolute; z-index: 3; top: 8px; left: 8px; width: 18px; height: 18px; border-radius: 50%; background: #2B2440; color: #fff; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .dm-cell:nth-of-type(1) .dm-tile::before { content: "1"; }
        .dm-cell:nth-of-type(2) .dm-tile::before { content: "2"; }
        .dm-cell:nth-of-type(3) .dm-tile::before { content: "3"; }
        .dm-strip-p .dm-tile::before { width: 14px; height: 14px; font-size: 8px; top: 4px; left: 4px; }
        .dm-strip-p { gap: 4px; }
        .dm-strip-p .dm-cell { width: 78px; }
        .dm-strip-p .dm-tile { width: 78px; height: 104px; border-radius: 10px; }
        .dm-strip-p .dm-cap { font-size: 7.5px; letter-spacing: .04em; }
        .dm-strip-p .dm-op { margin-top: 40px; width: 16px; height: 16px; font-size: 12px; }
        .dm-ph { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; font-size: 10px; color: #a08fb5; border: 1.5px dashed #F3C4DA; border-radius: 14px; background: #fff7fb; opacity: 0; transition: opacity .4s ease; }
        .dm-ph .material-symbols-outlined { font-size: 28px; color: #E58AB6; }
        .dm-strip-p .dm-ph { font-size: 7.5px; }
        .dm-strip-p .dm-ph .material-symbols-outlined { font-size: 20px; }
        .dm-lock { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .4s ease; }
        .dm-lock .material-symbols-outlined { font-size: 34px; color: #fff; text-shadow: 0 2px 8px rgba(43, 36, 64, .5); }
        .dm-strip-p .dm-lock .material-symbols-outlined { font-size: 24px; }
        /* what shows at each step */
        .tryon-demo .t-shopper, .tryon-demo .t-result, .tryon-demo .t-base { opacity: 0; }
        .tryon-demo .t-garment { opacity: 1; }
        .tryon-demo[data-step="1"] .t-shopper, .tryon-demo[data-step="2"] .t-shopper, .tryon-demo[data-step="3"] .t-shopper, .tryon-demo[data-step="4"] .t-shopper { opacity: 1; }
        .tryon-demo[data-step="2"] .t-base { opacity: .55; filter: saturate(.7); }
        .tryon-demo[data-step="3"] .t-result { opacity: 1; filter: blur(9px) saturate(.85); transform: scale(1.08); }
        .tryon-demo[data-step="4"] .t-result { opacity: 1; }
        .tryon-demo[data-step="0"] .ph-before, .tryon-demo[data-step="0"] .ph-result, .tryon-demo[data-step="1"] .ph-result { opacity: 1; }
        .tryon-demo[data-step="3"] .dm-lock { opacity: 1; }
        /* action panel */
        .dm-panel { position: relative; flex: 1; min-height: 0; }
        .dm-pp { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: calc(6px * var(--f, 1)); text-align: center; }
        .dm-name { font-size: calc(13.5px * var(--f, 1)); font-weight: 600; line-height: 1.2; }
        .dm-price { color: #C93B83; margin-left: 4px; font-weight: 700; }
        .dm-sub { font-size: calc(10.5px * var(--f, 1)); color: #6b6480; line-height: 1.35; max-width: 94%; }
        .dm-row { display: flex; gap: 8px; width: 100%; justify-content: center; }
        .dm-between { justify-content: space-between; align-items: center; }
        .dm-btn { display: inline-flex; align-items: center; justify-content: center; gap: 4px; padding: calc(6px * var(--f, 1)) calc(14px * var(--f, 1)); border-radius: 10px; font-size: calc(10.5px * var(--f, 1)); font-weight: 700; border: 1px solid #2B2440; white-space: nowrap; }
        .dm-btn .material-symbols-outlined { font-size: calc(14px * var(--f, 1)); }
        .dm-dark { background: #2B2440; color: #fff; }
        .dm-light { background: #fff; color: #2B2440; border-color: #d9d2e6; }
        .dm-pink { background: #6FB3F7; color: #fff; border-color: #3F94EC; box-shadow: 0 8px 16px -8px rgba(63, 148, 236, .9); }
        .dm-row .dm-btn { flex: 1; }
        .dm-between .dm-btn { flex: 0 0 auto; }
        .dm-full { width: 100%; }
        .dm-field { flex: 1; text-align: left; font-size: calc(10.5px * var(--f, 1)); padding: calc(6px * var(--f, 1)) 10px; min-height: calc(26px * var(--f, 1)); border: 1px solid #ddd6ea; border-radius: 10px; background: #faf8fd; }
        .dm-pill { display: inline-flex; align-items: center; gap: 5px; background: #2B2440; color: #fff; border-radius: 99px; padding: 4px 12px; font-size: calc(10px * var(--f, 1)); font-weight: 600; }
        .dm-pill .material-symbols-outlined { font-size: calc(13px * var(--f, 1)); }
        .dm-barwrap { width: 78%; height: 7px; border-radius: 7px; background: #f1e3ee; overflow: hidden; }
        .dm-barwrap .demo-bar { height: 100%; background: linear-gradient(90deg, #FEB8D7, #6FB3F7); border-radius: 7px; }
        .dm-agree { display: flex; align-items: center; gap: 5px; font-size: calc(9.5px * var(--f, 1)); color: #6b6480; text-align: left; }
        .dm-agree i { font-style: normal; width: 13px; height: 13px; background: #2B2440; color: #fff; font-size: 9px; display: inline-flex; align-items: center; justify-content: center; border-radius: 3px; flex: none; }
        /* phone: product info on top, action sheet at the bottom */
        .dm-info { padding: 14px 8px 0; display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .dm-info .dm-sub b { font-size: calc(12px * var(--f, 1)); }
        .dm-sizes { display: flex; gap: 8px; }
        .dm-sizes span { width: 36px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; border: 1px solid #ddd6ea; border-radius: 8px; color: #6b6480; }
        .dm-sizes span.on { background: #2B2440; border-color: #2B2440; color: #fff; }
        .dm-skel { width: 100%; display: flex; flex-direction: column; gap: 8px; margin-top: 6px; }
        .dm-skel i { display: block; height: 8px; border-radius: 8px; background: #f0eaf6; }
        .dm-skel i:nth-child(2) { width: 86%; }
        .dm-skel i:nth-child(3) { width: 62%; }
        .dm-phone .dm-panel { position: absolute; left: 0; right: 0; bottom: 0; height: 224px; flex: none; background: #fff; border-radius: 24px 24px 0 0; box-shadow: 0 -12px 32px rgba(43, 36, 64, .14); }
        .dm-phone .dm-pp { inset: 18px 16px 30px; gap: 10px; }
        .dm-phone .dm-btn { padding: 12px 16px; border-radius: 14px; }
        .dm-phone .dm-field { min-height: 40px; padding: 10px 12px; border-radius: 14px; }
        .dm-phone .dm-pill { padding: 6px 14px; }
        .dm-phone .dm-barwrap { height: 9px; width: 86%; }
        /* progress steps under the devices */
        .dm-steps { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin: 10px 14% 0 12%; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 800; color: #2B2440; }
        .tryon-demo .dm-steps .step-dot i { height: 3px; border-radius: 3px; background: rgba(43, 36, 64, .16); margin-bottom: 7px; }
        .tryon-demo[data-step="0"] .dm-steps .sd-0 i, .tryon-demo[data-step="1"] .dm-steps .sd-1 i, .tryon-demo[data-step="2"] .dm-steps .sd-2 i,
        .tryon-demo[data-step="3"] .dm-steps .sd-3 i, .tryon-demo[data-step="4"] .dm-steps .sd-4 i { background: #C93B83; }
        /* pointer + finger positions */
        .tryon-demo .cursor, .tryon-demo .tap-dot { z-index: 20; }
        .tryon-demo[data-step="0"] .cursor { left: 57%; top: 91%; }
        .tryon-demo[data-step="1"] .cursor { left: 40%; top: 88%; }
        .tryon-demo[data-step="2"] .cursor { left: 84%; top: 62%; }
        .tryon-demo[data-step="3"] .cursor { left: 83%; top: 90%; }
        .tryon-demo[data-step="4"] .cursor { left: 45%; top: 86%; }
        .tryon-demo[data-step="0"] .tap-dot { left: 50%; top: 86%; }
        .tryon-demo[data-step="1"] .tap-dot { left: 30%; top: 89%; }
        .tryon-demo[data-step="2"] .tap-dot { left: 50%; top: 66%; }
        .tryon-demo[data-step="3"] .tap-dot { left: 50%; top: 90%; }
        .tryon-demo[data-step="4"] .tap-dot { left: 50%; top: 80%; }
        .tryon-demo[data-step="2"] .scan { opacity: 1; }
        /* small screens: one big phone instead of the tiny laptop + phone */
        @media (max-width: 639px) {
            .devmock { width: min(80vw, 310px) !important; margin: 0 auto !important; }
            .dm-stage { aspect-ratio: 292 / 572; }
            .dm-frame { display: none; }
            .dm-frame-phone { display: block; }
            .dm-laptop { display: none; }
            .dm-phone { left: 8.22%; top: 3.85%; width: 83.2%; height: 91.96%; }
            .dm-steps { margin: 14px 0 0; gap: 6px; font-size: 9px; letter-spacing: .08em; }
            .hero-eyebrow { letter-spacing: .2em !important; }
            /* keep the rating pop-up small so it never hides the demo */
            #rating-toast { right: .75rem; bottom: .75rem; }
            #rating-toast .rt-text { display: none; }
            #rating-toast > div { padding: .5rem .75rem; }
        }
        @media (min-width: 640px) and (max-width: 1023px) { .devmock { width: min(100%, 720px) !important; margin: 0 auto !important; } }

        /* ===== Try it free: three-step studio card ===== */
        #try-free .tf-card { background: #ffffff; border: 1px solid #F3C4DA; border-radius: 28px; padding: 28px; box-shadow: 0 30px 60px -34px rgba(201, 59, 131, .45); max-width: 1180px; margin: 0 auto; }
        #try-free .tf-cols { display: grid; grid-template-columns: 1.1fr 1fr 1fr; gap: 28px; }
        #try-free .tf-col { min-width: 0; }
        #try-free .tf-step { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #2B2440; margin-bottom: 14px; }
        #try-free .tf-step b { width: 26px; height: 26px; border-radius: 50%; background: #FEB8D7; color: #2B2440; display: flex; align-items: center; justify-content: center; font-size: 12px; }
        #try-free .tf-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px 10px; }
        #try-free .tf-thumb { opacity: 1; outline: 0; background: transparent; padding: 0; text-align: left; transition: transform .2s ease; }
        #try-free .tf-thumb:hover { transform: translateY(-3px); opacity: 1; }
        #try-free .tf-thumb .tfp { position: relative; display: block; aspect-ratio: 3 / 4; border-radius: 14px; overflow: hidden; border: 2px solid #F3C4DA; background: #FFE8F2; transition: border-color .2s, box-shadow .2s; }
        #try-free .tf-thumb .tfp img { width: 100%; height: 100%; object-fit: cover; object-position: top; display: block; }
        #try-free .tf-thumb.tf-sel .tfp { border-color: #3F94EC; box-shadow: 0 0 0 3px rgba(111, 179, 247, .35); }
        #try-free .tf-thumb.tf-sel .tfp::after { content: "\2713"; position: absolute; top: 6px; right: 6px; width: 20px; height: 20px; border-radius: 50%; background: #3F94EC; color: #fff; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        #try-free .tf-thumb .tfl { display: block; margin-top: 6px; font-size: 11px; font-weight: 600; line-height: 1.25; color: #5C5675; }
        #try-free .tf-thumb.tf-sel .tfl { color: #2B2440; }
        #try-free .tf-frame { position: relative; display: block; width: 100%; aspect-ratio: 3 / 4; max-height: 52vh; border-radius: 20px; overflow: hidden; background: #FFF7FB; border: 1px solid #F3C4DA; }
        #try-free .tf-drop { border: 2px dashed #F3A8CB; cursor: pointer; transition: background .2s, border-color .2s; }
        #try-free .tf-drop:hover { background: #FFEEF6; border-color: #E0609F; }
        #try-free .tf-fill { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; background: #FFF7FB; }
        #try-free .tf-ghost { object-fit: cover; object-position: top; opacity: .22; filter: saturate(.6); }
        #try-free .tf-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 0 20px; text-align: center; }
        #try-free .tf-ico { width: 64px; height: 64px; border-radius: 50%; background: #FFE3EF; display: flex; align-items: center; justify-content: center; }
        #try-free .tf-ico .material-symbols-outlined, #try-free .tf-status .material-symbols-outlined { font-size: 34px; color: #C93B83; }
        #try-free .tf-h { font-size: 15px; font-weight: 700; color: #2B2440; }
        #try-free .tf-s { font-size: 12px; color: #6b6480; line-height: 1.4; }
        #try-free .tf-pick { margin-top: 6px; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; color: #fff; background: #6FB3F7; border: 1.5px solid #3F94EC; }
        #try-free .tf-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-top: 26px; padding-top: 22px; border-top: 1px solid #F8DCE9; }
        #try-free .tf-go, #try-free .tf-dl, #try-free .tf-cta { display: inline-flex; align-items: center; gap: 8px; padding: 14px 26px; border-radius: 12px; font-size: 12px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
        #try-free .tf-go { background: #6FB3F7 !important; color: #fff !important; border: 1.5px solid #3F94EC !important; box-shadow: 0 12px 22px -12px rgba(63, 148, 236, .9); }
        #try-free .tf-go:disabled { opacity: .45; box-shadow: none; cursor: not-allowed; }
        #try-free .tf-dl, #try-free .tf-cta { background: #fff; color: #2B2440; border: 1.5px solid #8EC3F8; }
        #try-free .tf-dl.hidden, #try-free .tf-cta.hidden { display: none; }
        #try-free .tf-msg { flex: 1; min-width: 220px; font-size: 13px; color: #6b6480; line-height: 1.5; margin: 0; }
        #try-free .tf-badge { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 99px; background: #FFE3EF; color: #C93B83; font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; margin: 0; }
        #try-free .tf-badge .material-symbols-outlined { font-size: 16px; }
        @media (max-width: 1023px) {
            #try-free .tf-cols { grid-template-columns: 1fr; gap: 26px; }
            #try-free .tf-card { padding: 20px 16px; border-radius: 22px; }
            #try-free .tf-frame { max-height: none; max-width: 340px; margin: 0 auto; }
            #try-free .tf-bar { flex-direction: column; align-items: stretch; text-align: center; }
            #try-free .tf-go, #try-free .tf-dl, #try-free .tf-cta { justify-content: center; }
            #try-free .tf-badge { align-self: center; }
        }

        /* ===== Built for Shopify: product preview + 4 setup steps ===== */
        .sf-card { display: grid; grid-template-columns: 1fr 1fr; gap: 0; background: #fff; border: 1px solid #F3C4DA; border-radius: 28px; overflow: hidden; box-shadow: 0 30px 60px -34px rgba(201, 59, 131, .45); position: relative; z-index: 2; }
        .sf-preview { display: flex; flex-direction: column; background: #fff; min-width: 0; border-right: 1px solid #F3E4EC; }
        .sf-browser { height: 30px; display: flex; align-items: center; gap: 6px; padding: 0 12px; background: #f6f3fa; border-bottom: 1px solid #ebe6f1; flex: none; }
        .sf-browser i { width: 8px; height: 8px; border-radius: 50%; background: #d8d3e2; }
        .sf-browser span { margin-left: 8px; flex: 1; font-size: 10px; color: #6b6480; background: #fff; border-radius: 99px; padding: 3px 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sf-store { height: 40px; display: flex; align-items: center; justify-content: space-between; padding: 0 18px; border-bottom: 1px solid #f1ecf6; font-size: 11px; flex: none; }
        .sf-store b { letter-spacing: .16em; font-weight: 700; color: #2B2440; white-space: nowrap; }
        .sf-nav { display: flex; gap: 12px; white-space: nowrap; color: #6b6480; font-weight: 500; font-size: 10.5px; }
        .sf-nav u { text-decoration: none; }
        .sf-store .material-symbols-outlined { font-size: 18px; color: #2B2440; }
        .sf-prod { flex: 1; display: grid; grid-template-columns: 46% 1fr; min-height: 0; }
        .sf-img { position: relative; background: #FFE8F2; min-height: 100%; }
        .sf-img img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; }
        .sf-badge { position: absolute; top: 10px; left: 10px; background: #fff; color: #2B2440; font-size: 10px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; padding: 4px 10px; border-radius: 99px; }
        .sf-info { display: flex; flex-direction: column; gap: 7px; padding: 16px 16px 14px; min-width: 0; justify-content: center; }
        .sf-crumb { font-size: 10px; color: #8A84A3; letter-spacing: .04em; }
        .sf-title { font-size: 16px; line-height: 1.2; color: #2B2440; font-weight: 700; }
        .sf-rate { display: flex; align-items: center; gap: 6px; font-size: 10.5px; color: #6b6480; }
        .sf-stars { display: inline-flex; color: #f5b301; }
        .sf-stars .material-symbols-outlined { font-size: 14px; font-variation-settings: 'FILL' 1; }
        .sf-price { font-size: 16px; font-weight: 700; color: #C93B83; }
        .sf-price s { font-size: 12px; font-weight: 500; color: #a8a2bb; margin-left: 4px; }
        .sf-lbl { font-size: 10.5px; font-weight: 700; color: #2B2440; margin-top: 2px; }
        .sf-lbl em { font-style: normal; font-weight: 500; color: #6b6480; margin-left: 4px; }
        .sf-sw { display: flex; gap: 8px; }
        .sf-sw i { width: 20px; height: 20px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 1px #ddd6ea; }
        .sf-sw i.on { box-shadow: 0 0 0 2px #2B2440; }
        .sf-sizes { display: flex; gap: 6px; }
        .sf-sizes i { font-style: normal; min-width: 30px; height: 28px; padding: 0 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; border: 1px solid #ddd6ea; border-radius: 7px; color: #6b6480; }
        .sf-sizes i.on { background: #2B2440; border-color: #2B2440; color: #fff; }
        .sf-buy { display: flex; gap: 8px; margin-top: 4px; }
        .sf-qty { display: inline-flex; align-items: center; border: 1px solid #ddd6ea; border-radius: 10px; font-size: 12px; color: #2B2440; }
        .sf-qty i, .sf-qty b { font-style: normal; padding: 8px 10px; }
        .sf-cart { flex: 1; white-space: nowrap; text-align: center; font-size: 11.5px; font-weight: 700; padding: 10px; border-radius: 10px; background: #2B2440; color: #fff; }
        .sf-now { text-align: center; font-size: 11.5px; font-weight: 700; padding: 9px; border-radius: 10px; border: 1px solid #2B2440; color: #2B2440; }
        .sf-try { position: relative; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 12px; font-weight: 800; padding: 11px; border-radius: 10px; color: #fff; background: #6FB3F7; border: 1.5px solid #3F94EC; animation: sf-ring 2.4s ease-out infinite; margin-top: 2px; }
        .sf-try .material-symbols-outlined { font-size: 16px; }
        .sf-tag { position: absolute; top: -9px; right: 8px; font-style: normal; font-size: 9px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; background: #FEB8D7; color: #2B2440; border-radius: 99px; padding: 2px 8px; }
        .sf-note { display: flex; align-items: center; gap: 6px; font-size: 10.5px; color: #6b6480; margin-top: 2px; }
        .sf-note .material-symbols-outlined { font-size: 16px; color: #C93B83; }
        @keyframes sf-ring { 0% { box-shadow: 0 0 0 0 rgba(111, 179, 247, .55); } 100% { box-shadow: 0 0 0 14px rgba(111, 179, 247, 0); } }
        .sf-steps { list-style: none; margin: 0; padding: 18px 22px; display: flex; flex-direction: column; gap: 10px; }
        .sf-step { flex: 1; position: relative; display: flex; align-items: center; gap: 14px; padding: 12px 14px; border-radius: 16px; border: 1px solid #F3E4EC; background: #fff; animation: sf-active 8s ease-in-out infinite; }
        .sf-s1 { animation-delay: 0s; } .sf-s2 { animation-delay: 2s; } .sf-s3 { animation-delay: 4s; } .sf-s4 { animation-delay: 6s; }
        .sf-num { flex: none; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #EAF3FE; color: #2B2440; }
        .sf-txt { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
        .sf-txt b { font-size: 13.5px; color: #2B2440; }
        .sf-txt small { font-size: 12px; line-height: 1.4; color: #6b6480; }
        .sf-ok { color: #3F94EC; opacity: 0; }
        @keyframes sf-active {
            0%, 24% { border-color: #6FB3F7; background: #F4F9FF; box-shadow: 0 12px 24px -16px rgba(63, 148, 236, .8); transform: translateX(4px); }
            25%, 100% { border-color: #F3E4EC; background: #fff; box-shadow: none; transform: none; }
        }
        .sf-feat { display: flex; align-items: center; gap: 14px; }
        .sf-feat .sf-dot { width: 34px; height: 34px; border-radius: 50%; background: #FFE3EF; color: #C93B83; display: flex; align-items: center; justify-content: center; flex: none; }
        .sf-feat .sf-dot .material-symbols-outlined { font-size: 18px; }
        @media (max-width: 767px) { .sf-card { grid-template-columns: 1fr; border-radius: 22px; } .sf-preview { border-right: 0; border-bottom: 1px solid #F3E4EC; } .sf-prod { grid-template-columns: 42% 1fr; } .sf-img { min-height: 360px; } .sf-nav { display: none; } }
        @media (prefers-reduced-motion: reduce) { .sf-step, .sf-try { animation: none; } }

        /* ===== Desktop scale: the whole page renders like a 90% browser zoom ===== */
        @media (min-width: 1024px) {
            html { zoom: 0.9; }
            .screen.screen-hero { min-height: calc(100vh / 0.9); }
        }
        @media (min-width: 1024px) {
            @supports not (zoom: 1) { html { font-size: 90%; } }
        }

        /* minimal product page */
        .sf-store { height: 48px; padding: 0 22px; border-bottom: 1px solid #f1ecf6; }
        .sf-info { gap: 14px; padding: 24px; }
        .sf-title { font-size: 20px; }
        .sf-price { font-size: 18px; }
        .sf-cart { flex: none; padding: 12px; font-size: 12.5px; }
        .sf-try { padding: 13px; font-size: 13px; margin-top: 0; }

        /* minimal product page v2 */
        .sf-card { grid-template-columns: 1.2fr 1fr; }
        .sf-prod { grid-template-columns: 40% 1fr; }
        .sf-info { gap: 12px; padding: 20px 20px; }
        .sf-title { font-size: 17px; line-height: 1.25; }
        .sf-price { font-size: 16px; }
        .sf-cart { padding: 11px; font-size: 12px; }
        .sf-try { white-space: nowrap; padding: 11px 10px; font-size: 12px; animation: none; box-shadow: 0 10px 18px -10px rgba(63, 148, 236, .9); }
        .sf-pow { font-size: 10px; letter-spacing: .06em; color: #8A84A3; text-align: center; margin-top: -4px; }

        /* ===== Pricing: single plan card ===== */
        .pp-card { display: grid; grid-template-columns: 1fr 1.25fr; max-width: 1040px; margin: 0 auto; background: #fff; border: 1px solid #F3C4DA; border-radius: 28px; overflow: hidden; box-shadow: 0 30px 60px -36px rgba(201, 59, 131, .45); text-align: left; }
        .pp-buy { display: flex; flex-direction: column; gap: 18px; padding: 40px; background: linear-gradient(160deg, #FFE3EF 0%, #FFF7FB 55%, #EAF4FE 100%); border-right: 1px solid #F8DCE9; }
        .pp-tag { align-self: flex-start; font-size: 11px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #C93B83; background: #fff; border: 1px solid #F3C4DA; border-radius: 99px; padding: 6px 14px; }
        .pp-price { display: flex; align-items: flex-end; gap: 8px; color: #2B2440; }
        .pp-price b { font-size: clamp(3.5rem, 6vw, 4.5rem); line-height: .9; font-weight: 700; letter-spacing: -.04em; }
        .pp-price span { font-size: 16px; color: #6b6480; padding-bottom: 6px; }
        .pp-sub { font-size: 15px; line-height: 1.5; color: #5C5675; margin: 0; }
        .pp-btn { margin-top: auto; width: 100%; padding: 16px; font-size: 12px; letter-spacing: .18em; text-transform: uppercase; }
        .pp-fine { font-size: 12px; color: #8a83a0; text-align: center; margin: -6px 0 0; }
        .pp-feat { padding: 40px; }
        .pp-feat h3 { font-size: 12px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #2B2440; margin: 0 0 20px; }
        .pp-feat ul { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 24px; margin: 0; padding: 0; list-style: none; }
        .pp-feat li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; line-height: 1.4; color: #5C5675; }
        .pp-feat li .material-symbols-outlined { flex-shrink: 0; width: 20px; height: 20px; border-radius: 50%; background: #FFE3EF; color: #C93B83; font-size: 14px; display: flex; align-items: center; justify-content: center; }
        @media (max-width: 900px) {
            .pp-card { grid-template-columns: 1fr; border-radius: 22px; }
            .pp-buy { border-right: 0; border-bottom: 1px solid #F8DCE9; padding: 28px 20px; }
            .pp-feat { padding: 28px 20px; }
        }
        @media (max-width: 560px) { .pp-feat ul { grid-template-columns: 1fr; } }

        /* ===== Case study + guides ===== */
        .cs-feature { display: grid; grid-template-columns: 1.4fr 1fr; background: #fff; border: 1px solid #F3C4DA; border-radius: 28px; overflow: hidden; box-shadow: 0 30px 60px -36px rgba(201, 59, 131, .45); }
        .cs-copy { padding: 44px 48px; display: flex; flex-direction: column; align-items: flex-start; gap: 16px; }
        .cs-tag { font-size: 11px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #C93B83; background: #FFE3EF; border-radius: 99px; padding: 6px 14px; }
        .cs-title { font-size: clamp(1.9rem, 3vw, 2.8rem) !important; line-height: 1.15; letter-spacing: -.02em; color: #2B2440; font-weight: 500; margin: 0; }
        .cs-text { font-size: 15px; line-height: 1.7; color: #5C5675; max-width: 34rem; margin: 0; }
        .cs-link { margin-top: 6px; display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 12px; background: #6FB3F7; color: #fff; border: 1.5px solid #3F94EC; font-size: 12px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; box-shadow: 0 10px 20px -12px rgba(63, 148, 236, .9); transition: transform .2s; }
        .cs-link:hover { transform: translateY(-2px); }
        .cs-link .material-symbols-outlined { font-size: 16px; }
        .cs-stat { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; padding: 36px; text-align: center; background: linear-gradient(135deg, #FEB8D7 0%, #B8D9FC 100%); }
        .cs-big { font-size: clamp(4.5rem, 9vw, 7.5rem); line-height: 1; font-weight: 700; letter-spacing: -.04em; color: #2B2440; }
        .cs-cap { font-size: 16px; font-weight: 700; color: #2B2440; }
        .cs-who { margin-top: 12px; font-size: 11px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #2B2440; background: rgba(255, 255, 255, .7); border-radius: 99px; padding: 6px 14px; }
        .cs-guides { margin-top: 40px; }
        .cs-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .cs-head h3 { font-size: 18px; font-weight: 700; color: #2B2440; margin: 0; }
        .cs-all { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: #C93B83; }
        .cs-all .material-symbols-outlined { font-size: 16px; }
        .cs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .cs-card { display: flex; flex-direction: column; align-items: flex-start; gap: 10px; background: #fff; border: 1px solid #F3C4DA; border-radius: 22px; padding: 24px; transition: transform .25s, box-shadow .25s, border-color .25s; }
        .cs-card:hover { transform: translateY(-4px); border-color: #8EC3F8; box-shadow: 0 22px 40px -24px rgba(63, 148, 236, .55); }
        .cs-ico { width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #FFE3EF, #EAF3FE); color: #2B2440; }
        .cs-pill { font-size: 10px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #C93B83; }
        .cs-ctitle { font-size: 16px; line-height: 1.35; color: #2B2440; font-weight: 600; }
        .cs-sum { font-size: 13.5px; line-height: 1.6; color: #6b6480; flex: 1; }
        .cs-foot { width: 100%; display: flex; align-items: center; justify-content: space-between; margin-top: 6px; padding-top: 14px; border-top: 1px solid #F8DCE9; font-size: 12px; color: #8A84A3; }
        .cs-foot .material-symbols-outlined { font-size: 18px; color: #3F94EC; transition: transform .2s; }
        .cs-card:hover .cs-foot .material-symbols-outlined { transform: translateX(4px); }
        @media (max-width: 1023px) {
            .cs-feature { grid-template-columns: 1fr; border-radius: 22px; }
            .cs-copy { padding: 28px 22px; }
            .cs-stat { padding: 28px; }
            .cs-grid { grid-template-columns: 1fr; }
        }

        /* final call-to-action band: slightly shorter */
        @media (min-width: 1024px) { .screen.cta-band { padding-top: 3.25rem !important; padding-bottom: 3.25rem !important; } }
        @media (max-width: 1023px) { .screen.cta-band { padding-top: 2.5rem !important; padding-bottom: 2.5rem !important; } }
        .cta-band .space-y-8 > * + * { margin-top: 1.1rem !important; }

        /* ===== Pop-up form ===== */
        #modalBackdrop { background: rgba(43, 36, 64, .55); backdrop-filter: blur(6px); padding: 16px; }
        .mdl { position: relative; width: 100%; max-width: 920px; max-height: 92vh; overflow-y: auto; display: grid; grid-template-columns: 340px 1fr; background: #fff; border-radius: 28px; box-shadow: 0 40px 90px -30px rgba(43, 36, 64, .65); }
        .mdl-x { position: absolute; top: 14px; right: 14px; z-index: 5; width: 38px; height: 38px; border-radius: 50%; border: 1px solid #F3C4DA; background: #fff; color: #2B2440; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .2s; }
        .mdl-x:hover { background: #FFE3EF; }
        .mdl-x .material-symbols-outlined { font-size: 20px; color: #2B2440; }
        .mdl-side { position: relative; padding: 38px 32px; background: linear-gradient(160deg, #FEB8D7 0%, #E4C6EE 55%, #B8D9FC 100%); display: flex; flex-direction: column; gap: 22px; color: #2B2440; }
        .mdl-logo { height: 46px; width: auto; align-self: flex-start; }
        .mdl-side h4 { font-size: 24px; line-height: 1.25; font-weight: 600; margin: 0; letter-spacing: -.01em; }
        .mdl-side ul { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 14px; }
        .mdl-side li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; line-height: 1.4; font-weight: 500; }
        .mdl-side li .material-symbols-outlined { font-size: 20px; color: #2B2440; flex: none; font-variation-settings: 'FILL' 1; }
        .mdl-quote { margin-top: auto; display: flex; gap: 8px; align-items: flex-start; font-size: 12px; line-height: 1.5; background: rgba(255,255,255,.6); border-radius: 14px; padding: 12px 14px; }
        .mdl-quote .material-symbols-outlined { font-size: 16px; flex: none; color: #C93B83; }
        .mdl-main { padding: 40px 44px 34px; }
        .mdl-head h3 { font-size: 26px; line-height: 1.2; font-weight: 600; margin: 0 40px 6px 0; color: #2B2440; letter-spacing: -.01em; }
        .mdl-head p { font-size: 14px; color: #6b6480; margin: 0 0 24px; line-height: 1.55; }
        .mdl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 18px; }
        .mf label { display: block; font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #5C5675; margin-bottom: 6px; }
        .mf input { width: 100%; padding: 13px 14px; font: inherit; font-size: 14px; color: #2B2440; background: #FFF7FB; border: 1.5px solid #F3C4DA; border-radius: 12px; outline: none; transition: border-color .2s, box-shadow .2s, background .2s; }
        .mf input::placeholder { color: #b3aac2; }
        .mf input:focus { background: #fff; border-color: #6FB3F7; box-shadow: 0 0 0 4px rgba(111, 179, 247, .25); }
        .mdl-actions { display: flex; gap: 12px; margin-top: 26px; justify-content: flex-end; }
        .mdl-cancel, .mdl-submit { padding: 14px 30px; border-radius: 12px; font-size: 12px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; cursor: pointer; transition: transform .2s, background .2s; }
        .mdl-cancel { background: #fff; color: #2B2440; border: 1.5px solid #F3C4DA; }
        .mdl-cancel:hover { background: #FFF1F7; }
        .mdl-submit { background: #6FB3F7 !important; color: #fff !important; border: 1.5px solid #3F94EC !important; box-shadow: 0 12px 22px -12px rgba(63, 148, 236, .9); }
        .mdl-submit:hover { transform: translateY(-1px); }
        .mdl-submit:disabled { opacity: .6; cursor: default; }
        .mdl-thanks { position: relative; width: 100%; max-width: 520px; background: #fff; border-radius: 28px; padding: 48px 40px 40px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 12px; box-shadow: 0 40px 90px -30px rgba(43, 36, 64, .65); }
        .mdl-thanks.hidden { display: none; }
        .mdl-thanks h3 { font-size: 26px; font-weight: 600; color: #2B2440; margin: 0; }
        .mdl-thanks p { font-size: 14px; line-height: 1.6; color: #6b6480; margin: 0 0 12px; }
        .mdl-tick { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #FEB8D7, #B8D9FC); display: flex; align-items: center; justify-content: center; }
        .mdl-tick .material-symbols-outlined { font-size: 36px; color: #2B2440; }
        @media (max-width: 820px) {
            .mdl { grid-template-columns: 1fr; border-radius: 22px; }
            .mdl-side { padding: 26px 24px 22px; gap: 14px; }
            .mdl-side h4 { font-size: 19px; }
            .mdl-side ul, .mdl-quote { display: none; }
            .mdl-main { padding: 24px 20px 22px; }
            .mdl-head h3 { font-size: 21px; margin-right: 44px; }
            .mdl-grid { grid-template-columns: 1fr; }
            .mdl-actions { flex-direction: column-reverse; }
            .mdl-actions button { width: 100%; }
        }

        /* FAQ: each question keeps its own height (a row-equalising rule used to stretch the neighbour when one opened) */
        #faq .grid > details.faq { height: auto !important; align-self: start; }
        details.faq { transition: border-color .25s, box-shadow .25s; }
        details.faq[open] { border-color: #8EC3F8; box-shadow: 0 18px 36px -24px rgba(63, 148, 236, .55); }
        details.faq[open] > summary { color: #C93B83; }
        details.faq > p { animation: faq-in .3s ease; }
        @keyframes faq-in { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: none; } }

        /* FAQ: 2-column grid, questions paired row by row */
        .faq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: start; }
        .faq-grid > details.faq { min-width: 0; }
        @media (max-width: 1023px) { .faq-grid { grid-template-columns: 1fr; } }

        /* responsive safety: decorative glows / watermarks must never create sideways scrolling */
        main section, footer { overflow-x: clip; }
        img, video, svg { max-width: 100%; }

        /* hero heading: never split the accent word, and fit the narrower laptop column */
        .screen-hero h1 .serif-italic { white-space: nowrap; }
        @media (min-width: 1024px) and (max-width: 1279px) { .screen-hero h1 { font-size: 2.9rem !important; } }
    </style>
</head>

<body
    class="bg-background text-on-surface selection:bg-primary-container selection:text-on-primary-container overflow-x-hidden">
    <div id="scroll-progress"></div>
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-[100] transition-all duration-500">
        <div
            class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop h-20 sm:h-24 flex items-center justify-between gap-3 sm:gap-10">
            <a class="flex items-center shrink-0" href="#" aria-label="Brix Try On">
                <img src="<?= img('brand.logo') ?>" alt="Brix Try On" class="nav-logo h-9 sm:h-11 w-auto" />
            </a>
            <div class="hidden xl:flex items-center gap-10 xl:gap-12">
                <a class="text-[11px] uppercase tracking-[0.2em] font-700 text-on-surface/100 hover:text-primary-container transition-colors"
                    href="#features">Collection</a>
                <a class="text-[11px] uppercase tracking-[0.2em] font-700 text-on-surface/100 hover:text-primary-container transition-colors"
                    href="#journey">Technology</a>
                <a class="text-[11px] uppercase tracking-[0.2em] font-700 text-on-surface/100 hover:text-primary-container transition-colors"
                    href="#live">Intelligence</a>
                <a class="text-[11px] uppercase tracking-[0.2em] font-700 text-on-surface/100 hover:text-primary-container transition-colors"
                    href="#pricing">Pricing</a>
                <div class="relative group/res flex items-center">
                    <a class="text-[11px] uppercase tracking-[0.2em] font-700 text-on-surface/100 hover:text-primary-container transition-colors inline-flex items-center gap-1 leading-none"
                        href="#faq">Resources <span class="material-symbols-outlined text-[16px] leading-none">expand_more</span></a>
                    <div class="absolute left-0 top-full pt-4 hidden group-hover/res:block">
                        <div class="bg-[#ffffff] shadow-2xl min-w-[210px] py-3">
                            <a class="block px-5 py-2 text-[11px] uppercase tracking-[0.2em] font-700 text-black hover:bg-neutral-100" href="#journey">How it works</a>
                            <a class="block px-5 py-2 text-[11px] uppercase tracking-[0.2em] font-700 text-black hover:bg-neutral-100" href="#case-studies">Case studies</a>
                            <a class="block px-5 py-2 text-[11px] uppercase tracking-[0.2em] font-700 text-black hover:bg-neutral-100" href="#guides">Guides</a>
                            <a class="block px-5 py-2 text-[11px] uppercase tracking-[0.2em] font-700 text-black hover:bg-neutral-100" href="#faq">FAQ</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 sm:gap-6 xl:gap-8">
                <button
                    class="hidden xl:block whitespace-nowrap text-[11px] uppercase tracking-[0.2em] font-700 hover:text-primary-container transition-colors">Client
                    Login</button>
                <button
                    class="cta-button hidden sm:block px-4 py-2.5 sm:px-8 sm:py-3 bg-primary-container text-on-primary-container text-[10px] sm:text-[11px] uppercase tracking-[0.15em] sm:tracking-[0.2em] font-800 rounded-none hover:bg-[#ffffff] transition-all shadow-[0_10px_30px_-8px_rgba(254,184,215,0.9)] whitespace-nowrap">Get
                    Access</button>
                <button id="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                    class="xl:hidden w-10 h-10 flex items-center justify-center border border-white/25">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
        <div id="nav-panel" class="hidden xl:hidden bg-[#ffffff] text-black border-t border-black/10 shadow-2xl">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop py-3 grid sm:grid-cols-2 gap-x-8">
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#journey">How it works</a>
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#features">Features</a>
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#benefits">Benefits</a>
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#try-free">Try it free</a>
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#pricing">Pricing</a>
                <a class="py-3 text-[11px] uppercase tracking-[0.2em] font-700 border-b border-black/10" href="#faq">FAQ</a>
                <button type="button" class="cta-button sm:hidden mt-3 mb-1 bg-black text-white text-[11px] uppercase tracking-[0.2em] font-800 py-3">Get Access</button>
            </div>
        </div>
    </nav>
    <main>
        <!-- Immersive Hero Section -->
        <section class="screen screen-hero relative py-24 pt-32 flex items-center overflow-hidden">
            <!-- Full-bleed background imagery -->
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FEB8D7]/45 via-[#FFF5FA] to-[#B8D9FC]/55"></div>
                <img alt="Fashion background" class="w-full h-full object-cover opacity-[0.08] scale-110"
                    src="<?= img('hero.bg') ?>" />
                <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent"></div>
                <div class="absolute -top-40 -right-40 w-[800px] h-[800px] aura-glow"></div>
            </div>
            <div class="relative z-10 max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop w-full">
                <div class="grid grid-cols-12 gap-gutter items-center">
                    <div class="col-span-12 lg:col-span-5 mb-4 lg:mb-0 min-w-0">
                        <div class="space-y-5 max-w-4xl">
                            <div class="inline-flex items-center gap-4 text-primary-container">
                                <div class="h-[1px] w-12 bg-primary-container"></div>
                                <span class="hero-eyebrow text-[10px] uppercase tracking-[0.4em] font-800"><?= e('hero.eyebrow') ?></span>
                            </div>
                            <h1 class="editorial-heading text-4xl min-[420px]:text-5xl sm:text-5xl md:text-6xl lg:text-[clamp(2.5rem,7vh,4.75rem)] font-800 text-white">
                                <?= ttl('hero.title') ?>
                            </h1>
                            <p class="text-lg text-on-surface-variant max-w-xl leading-relaxed font-light">
                                <?= e('hero.text') ?>
                            </p>
                            <div class="flex flex-wrap gap-4 pt-2">
                                <button
                                    class="cta-button shimmer group flex items-center gap-4 px-8 py-4 bg-primary-container text-background font-800 uppercase text-xs tracking-widest transition-all hover:bg-brand-blue">
                                    <?= e('hero.cta1') ?>
                                    <span
                                        class="material-symbols-outlined text-sm group-hover:translate-x-2 transition-transform">arrow_forward</span>
                                </button>
                                <button
                                    class="cta-button px-8 py-4 glass-card text-white font-700 uppercase text-xs tracking-widest border border-white/20 hover:bg-white/10 transition-all">
                                    <?= e('hero.cta2') ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Glassmorphic floating control -->
                    <div class="relative col-span-12 lg:col-span-7 flex justify-center lg:justify-end lg:pt-6 min-w-0">
                        <?php if (setting('hero.rating_show') === '1'): $rl = trim(setting('hero.rating_link')); ?>
                        <!-- Shopify rating pop-up: slides in from the right -->
                        <div id="rating-toast" role="status" class="fixed z-[150] right-4 bottom-4 sm:right-6 sm:bottom-6 w-max max-w-[calc(100vw-2rem)] translate-x-[130%] opacity-0 transition-all duration-700 ease-out pointer-events-none">
                            <div class="pointer-events-auto relative flex items-center gap-3 bg-[#ffffff] text-black rounded-xl px-4 py-3 shadow-[0_16px_40px_rgba(0,0,0,0.5)]">
                                <<?= $rl !== '' ? 'a href="' . h($rl) . '" target="_blank" rel="noopener"' : 'div' ?> class="flex items-center gap-3" aria-label="<?= h(setting('hero.rating_score')) ?> out of 5 stars">
                                    <span class="flex shrink-0" style="color:#f5b301">
                                        <?php for ($s = 0; $s < 5; $s++): ?><span class="material-symbols-outlined" style="font-size:18px;font-variation-settings:'FILL' 1">star</span><?php endfor; ?>
                                    </span>
                                    <span style="font-size:12px;line-height:1.25;color:#555"><b style="font-size:14px;color:#000"><?= e('hero.rating_score') ?></b><span class="rt-text"> <?= e('hero.rating_text') ?></span></span>
                                </<?= $rl !== '' ? 'a' : 'div' ?>>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="devmock relative w-full lg:w-[calc(100%+4.5rem)] lg:-mr-16">
                        <div class="tryon-demo" data-step="0" aria-label="Animated demo: a shopper's photo plus the product gives a try-on result on a clothing store product page">
                          <div class="dm-stage">
                            <div class="dm-screen dm-laptop"><div class="dm-inner" data-w="700" style="width:700px;height:419px">
                              <div class="dm-bar"><i></i><i></i><i></i><span class="dm-url"><span data-look-text="url">northlineapparel.com/products/navy-three-piece-suit</span></span></div>
                              <div class="dm-store"><b>NORTHLINE APPAREL</b><span class="dm-nav"><u>New in</u><u>Men</u><u>Women</u><u>Sale</u></span><span class="material-symbols-outlined">shopping_bag</span></div>
                              <div class="dm-body">
              <div class="dm-strip ">
                <div class="dm-cell">
                  <div class="dm-tile">
                    <img class="t-img t-shopper" src="assets/look-m1-person.jpg" data-look="person" alt="Shopper's own photo" />
                    <div class="dm-ph ph-before"><span class="material-symbols-outlined">add_a_photo</span><span>Add photo</span></div>
                  </div>
                  <div class="dm-cap">Your photo</div>
                </div>
                <span class="dm-op">+</span>
                <div class="dm-cell">
                  <div class="dm-tile">
                    <img class="t-img t-garment" src="assets/look-m1-garment.jpg" data-look="garment" alt="Product photo" />
                  </div>
                  <div class="dm-cap">Product</div>
                </div>
                <span class="dm-op">=</span>
                <div class="dm-cell">
                  <div class="dm-tile dm-tile-out">
                    <img class="t-img t-base" src="assets/look-m1-person.jpg" data-look="person" alt="" />
                    <img class="t-img t-result" src="assets/look-m1-result.jpg" data-look="result" alt="Try-on result" />
                    <div class="scan"></div>
                    <div class="dm-ph ph-result"><span class="material-symbols-outlined">auto_awesome</span><span>Your look</span></div>
                    <div class="dm-lock"><span class="material-symbols-outlined">lock</span></div>
                  </div>
                  <div class="dm-cap">Try-on result</div>
                </div>
              </div>
              <div class="dm-panel">
                <div class="only only-0 dm-pp">
                  <div class="dm-name"><span data-look-text="name">Navy Three-Piece Suit</span> <b class="dm-price"><span data-look-text="price">$349</span></b></div>
                  <div class="dm-sub">See how it fits before you buy &middot; free, no account</div>
                  <div class="dm-btn dm-pink tap-btn"><span class="material-symbols-outlined">photo_camera</span>Try On This Look</div>
                </div>
                <div class="only only-1 dm-pp">
                  <div class="dm-name">Upload your photo</div>
                  <div class="dm-sub">A full-length photo gives the best drape. It is processed privately and deleted afterwards.</div>
                  <div class="dm-row"><div class="dm-btn dm-dark pick-btn"><span class="material-symbols-outlined">image</span>Gallery</div><div class="dm-btn dm-light"><span class="material-symbols-outlined">photo_camera</span>Camera</div></div>
                </div>
                <div class="only only-2 dm-pp">
                  <div class="dm-name">Creating your look&hellip;</div>
                  <div class="dm-sub">Matching the fabric, drape and fit to your photo.</div>
                  <div class="dm-barwrap"><div class="demo-bar" style="width:0%"></div></div>
                  <div class="dm-name"><span class="demo-pct">0%</span></div>
                </div>
                <div class="only only-3 dm-pp">
                  <div class="dm-pill"><span class="material-symbols-outlined">schedule</span><span>Your look is ready! Decide in <span class="demo-timer">08:54</span></span></div>
                  <div class="dm-row"><div class="dm-field"><span class="type-email"></span></div><div class="dm-field"><span class="type-phone"></span></div></div>
                  <div class="dm-row dm-between"><div class="dm-agree"><i>&#10003;</i>I agree to the Privacy Policy and Terms</div><div class="dm-btn dm-pink unlock-btn">Unlock My Look</div></div>
                </div>
                <div class="only only-4 dm-pp">
                  <div class="dm-pill"><span class="material-symbols-outlined">schedule</span><span>Your look is ready! Decide in <span class="demo-timer">08:54</span></span></div>
                  <div class="dm-row"><div class="dm-btn dm-pink">Add to cart &bull; <span data-look-text="price">$349</span></div><div class="dm-btn dm-light">Buy Now</div></div>
                  <div class="dm-row"><div class="dm-btn dm-light"><span class="material-symbols-outlined">download</span>Save image</div><div class="dm-btn dm-dark"><span class="material-symbols-outlined">share</span>Share on WhatsApp</div></div>
                </div>
              </div>
                              </div>
                              <span class="cursor"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M3 2l7.5 19 2.7-7.6L21 10.7z" fill="#111" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
                            </div></div>
                            <div class="dm-screen dm-phone"><div class="dm-inner" data-w="300" style="width:300px;height:649px">
                              <div class="dmp-top"><span>NORTHLINE APPAREL</span></div>
                              <div class="dm-body">
              <div class="dm-strip dm-strip-p">
                <div class="dm-cell">
                  <div class="dm-tile">
                    <img class="t-img t-shopper" src="assets/look-m1-person.jpg" data-look="person" alt="Shopper's own photo" />
                    <div class="dm-ph ph-before"><span class="material-symbols-outlined">add_a_photo</span><span>Add photo</span></div>
                  </div>
                  <div class="dm-cap">Your photo</div>
                </div>
                <span class="dm-op">+</span>
                <div class="dm-cell">
                  <div class="dm-tile">
                    <img class="t-img t-garment" src="assets/look-m1-garment.jpg" data-look="garment" alt="Product photo" />
                  </div>
                  <div class="dm-cap">Product</div>
                </div>
                <span class="dm-op">=</span>
                <div class="dm-cell">
                  <div class="dm-tile dm-tile-out">
                    <img class="t-img t-base" src="assets/look-m1-person.jpg" data-look="person" alt="" />
                    <img class="t-img t-result" src="assets/look-m1-result.jpg" data-look="result" alt="Try-on result" />
                    <div class="scan"></div>
                    <div class="dm-ph ph-result"><span class="material-symbols-outlined">auto_awesome</span><span>Your look</span></div>
                    <div class="dm-lock"><span class="material-symbols-outlined">lock</span></div>
                  </div>
                  <div class="dm-cap">Try-on result</div>
                </div>
              </div>
                                <div class="dm-info">
                                  <div class="dm-name"><span data-look-text="name">Navy Three-Piece Suit</span></div>
                                  <div class="dm-sub"><b class="dm-price"><span data-look-text="price2">$349.00</span></b></div>
                                  <div class="dm-sizes"><span>S</span><span class="on">M</span><span>L</span><span>XL</span></div>
                                  <div class="dm-skel"><i></i><i></i><i></i></div>
                                </div>
                                
              <div class="dm-panel">
                <div class="only only-0 dm-pp">
                  <div class="dm-sub">See how it fits before you buy</div>
                  <div class="dm-btn dm-pink dm-full tap-btn"><span class="material-symbols-outlined">photo_camera</span>Try On This Look</div>
                </div>
                <div class="only only-1 dm-pp">
                  <div class="dm-name">Upload your photo</div>
                  <div class="dm-sub">Private &middot; deleted after your try-on</div>
                  <div class="dm-row"><div class="dm-btn dm-dark pick-btn"><span class="material-symbols-outlined">image</span>Gallery</div><div class="dm-btn dm-light"><span class="material-symbols-outlined">photo_camera</span>Camera</div></div>
                </div>
                <div class="only only-2 dm-pp">
                  <div class="dm-name">Creating your look&hellip;</div>
                  <div class="dm-barwrap"><div class="demo-bar" style="width:0%"></div></div>
                  <div class="dm-name"><span class="demo-pct">0%</span></div>
                </div>
                <div class="only only-3 dm-pp">
                  <div class="dm-pill"><span class="material-symbols-outlined">schedule</span><span>Look ready! <span class="demo-timer">08:54</span></span></div>
                  <div class="dm-field dm-full"><span class="type-email"></span></div>
                  <div class="dm-btn dm-pink unlock-btn dm-full">Unlock My Look</div>
                </div>
                <div class="only only-4 dm-pp">
                  <div class="dm-pill"><span class="material-symbols-outlined">schedule</span><span>Look ready! <span class="demo-timer">08:54</span></span></div>
                  <div class="dm-btn dm-pink dm-full">Add to cart &bull; <span data-look-text="price">$349</span></div>
                  <div class="dm-btn dm-light dm-full">Buy Now</div>
                </div>
              </div>
                              </div>
                              <span class="tap-dot"></span>
                            </div></div>
                            <img class="dm-frame" src="assets/device-mockup.png" alt="" width="1386" height="792" />
                            <img class="dm-frame-phone" src="assets/device-phone.png" alt="" width="292" height="572" />
                          </div>
                          <div class="dm-steps">
                            <div class="step-dot sd-0"><i></i>Browse</div>
                            <div class="step-dot sd-1"><i></i>Upload</div>
                            <div class="step-dot sd-2"><i></i>Create</div>
                            <div class="step-dot sd-3"><i></i>Unlock</div>
                            <div class="step-dot sd-4"><i></i>Buy</div>
                          </div>
                        </div>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Brix-Tryon: before / after -->
        <section class="screen py-20 bg-surface">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-12 gap-gutter items-center">
                    <div class="col-span-12 lg:col-span-5 lg:order-2 space-y-5">
                        <div class="inline-flex items-center gap-4 text-primary-container">
                            <div class="h-[1px] w-12 bg-primary-container"></div>
                            <span class="text-xs uppercase tracking-[0.4em] font-800"><?= e('why.eyebrow') ?></span>
                        </div>
                        <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white">
                            <?= ttl('why.title') ?>
                        </h2>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('why.p1') ?>
                        </p>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('why.p2') ?>
                        </p>
                        <p class="text-lg flex items-center gap-3 font-medium"><span class="material-symbols-outlined text-primary-container text-xl">check_circle</span><?= e('why.bullet') ?></p>
                    </div>
                    <div class="col-span-12 lg:col-span-7 lg:order-1 grid grid-cols-1 sm:grid-cols-[1fr_auto_1fr] gap-4 items-center">
                        <!-- Before -->
                        <div class="relative">
                            <span class="absolute -top-3 left-4 z-10 bg-surface border border-white/20 text-[10px] uppercase tracking-[0.2em] font-800 px-3 py-1">Before</span>
                            <div class="glass-card p-4 space-y-3 lift">
                                <div class="flex justify-between text-sm font-700 text-white"><span class="why-name">Navy Three-Piece Suit</span><span class="why-price text-on-surface/60 text-xs">$349</span></div>
                                <div class="relative aspect-[4/5] overflow-hidden bg-neutral-800">
                                    <img src="assets/look-m1-person.jpg" alt="Shopper's own photo" class="why-before-img w-full h-full object-cover object-top" />
                                    <span class="absolute top-2 left-2 bg-black/65 text-[10px] uppercase tracking-widest px-2 py-1">Shopper's photo</span>
                                    <span class="doubt absolute bottom-3 right-3 bg-[#ffffff] text-black text-[11px] font-700 px-3 py-1.5 rounded-full shadow-lg">Will this suit me?</span>
                                </div>
                                <div class="border border-dashed border-white/20 p-2 text-[11px] text-on-surface/60">No try-on &middot; size doubt &middot; returns risk</div>
                                <div class="flex justify-between text-sm"><span class="text-on-surface/60">Add to cart</span><span class="blink text-on-surface/70">Unsure&hellip;</span></div>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-3xl text-primary-container justify-self-center rotate-90 sm:rotate-0">arrow_forward</span>
                        <!-- After -->
                        <div class="relative">
                            <span class="absolute -top-3 left-4 z-10 bg-[#ffffff] text-black text-[10px] uppercase tracking-[0.2em] font-800 px-3 py-1">After</span>
                            <div class="glass-card p-4 space-y-3 border-t-4 border-primary-container lift">
                                <div class="flex justify-between text-sm font-700 text-white"><span class="why-name">Navy Three-Piece Suit</span><span class="why-price text-white text-xs">$349</span></div>
                                <div class="relative aspect-[4/5] overflow-hidden bg-neutral-800">
                                    <img src="assets/look-m1-person.jpg" alt="" class="why-base-img absolute inset-0 w-full h-full object-cover opacity-40" />
                                    <img src="assets/look-m1-result.jpg" alt="Shopper wearing the suit in the try-on preview" class="why-result-img wipe-loop absolute inset-0 w-full h-full object-cover object-top" />
                                    <span class="scan-loop"></span>
                                    <span class="fit-badge absolute top-2 left-2 bg-[#ffffff] text-black text-[10px] uppercase tracking-widest font-800 px-2 py-1">Perfect fit &middot; M</span>
                                    <span class="live-pill absolute bottom-2 left-2 bg-black/70 text-white text-[10px] px-2 py-1 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#ffffff] blink"></span>Live try-on</span>
                                </div>
                                <div class="flex gap-2 text-[11px]">
                                    <span class="bg-white/10 px-3 py-1 font-700">Perfect fit &middot; M</span>
                                    <span class="border border-dashed border-white/30 px-3 py-1 why-color">Navy</span>
                                </div>
                                <div class="flex justify-between text-sm font-700"><span class="text-white">Add to cart</span><span class="text-white">+<span data-count="32" data-suffix="%">0</span> conv.</span></div>
                            </div>
                        </div>
                        <p class="text-lg sm:col-span-3 text-center text-on-surface/70 pt-2">From static page to confident cart: <b class="text-white">+32% conversion</b></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why conversion matters: simple revenue calculator (light) -->
        <section id="conversion" class="screen py-12 bg-[#ffffff] text-black">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-12 gap-gutter items-center">
                    <div class="col-span-12 lg:col-span-5 space-y-4">
                        <p class="text-xs uppercase tracking-[0.4em] font-800 text-black/60"><?= e('conv.eyebrow') ?></p>
                        <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-black">
                            <?= ttl('conv.title', 'serif-italic font-normal') ?>
                        </h2>
                        <p class="text-lg text-black/70 font-light leading-relaxed">
                            <?= e('conv.text') ?>
                        </p>
                    </div>

                    <div class="col-span-12 lg:col-span-7">
                        <div class="bg-[#ffffff] border border-black/10 shadow-[0_24px_60px_-28px_rgba(0,0,0,0.35)] p-4 md:p-5 space-y-4">
                            <!-- step 1: inputs -->
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] font-800 text-black/50 mb-3">1 &middot; Tell us about your store</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <label class="block space-y-1.5">
                                        <span class="block text-xs text-black/70 leading-snug">Monthly visitors</span>
                                        <b id="v-vis" class="block text-2xl font-800 tracking-tight">20,000</b>
                                        <input id="in-vis" type="range" min="1000" max="100000" step="1000" value="20000" class="calc-range w-full" />
                                    </label>
                                    <label class="block space-y-1.5">
                                        <span class="block text-xs text-black/70 leading-snug">Average order value</span>
                                        <b id="v-aov" class="block text-2xl font-800 tracking-tight">$60</b>
                                        <input id="in-aov" type="range" min="10" max="300" step="5" value="60" class="calc-range w-full" />
                                    </label>
                                    <label class="block space-y-1.5">
                                        <span class="block text-xs text-black/70 leading-snug">Current conversion rate</span>
                                        <b id="v-cr" class="block text-2xl font-800 tracking-tight">2.0%</b>
                                        <input id="in-cr" type="range" min="0.5" max="5" step="0.1" value="2" class="calc-range w-full" />
                                    </label>
                                </div>
                            </div>

                            <!-- step 2: result -->
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] font-800 text-black/50 mb-3">2 &middot; What changes with Brix-Tryon</p>
                                <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto_1fr] gap-3 items-stretch">
                                    <div class="border border-black/15 px-4 py-3 flex flex-col">
                                        <p class="text-sm text-black/60 leading-tight">Today you make</p>
                                        <p id="rev-now" class="text-2xl font-800 tracking-tight leading-tight mt-1">$24,000</p>
                                        <div class="grid grid-cols-2 gap-3 border-t border-black/10 mt-auto pt-2">
                                            <div><p class="text-xs text-black/50 leading-tight">Orders a month</p><p id="ord-now" class="text-base font-700 leading-tight">400</p></div>
                                            <div><p class="text-xs text-black/50 leading-tight">Conversion rate</p><p id="cr-now" class="text-base font-700 leading-tight">2.0%</p></div>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined self-center justify-self-center rotate-90 sm:rotate-0">arrow_forward</span>
                                    <div class="border-2 border-black px-4 py-3 flex flex-col">
                                        <p class="text-sm text-black/60 leading-tight">With Brix-Tryon you could make</p>
                                        <p id="rev-new" class="text-2xl font-800 tracking-tight leading-tight mt-1">$42,000</p>
                                        <div class="grid grid-cols-2 gap-3 border-t border-black/10 mt-auto pt-2">
                                            <div><p class="text-xs text-black/50 leading-tight">Orders a month</p><p id="ord-new" class="text-base font-700 leading-tight">700</p></div>
                                            <div><p class="text-xs text-black/50 leading-tight">Conversion rate</p><p class="text-base font-700 leading-tight"><span id="cr-new">3.5%</span> <span class="inline-block bg-black text-white text-[10px] font-700 px-1.5 py-0.5 align-middle">+1.5%</span></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-black text-white px-5 py-3 mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-0">
                                    <div class="sm:pr-5">
                                        <p class="text-xs text-white/60 leading-tight">Extra revenue every month</p>
                                        <p class="text-2xl font-800 tracking-tight leading-tight">+<span id="gain">$18,000</span></p>
                                    </div>
                                    <div class="sm:pl-5 sm:border-l border-white/20">
                                        <p class="text-xs text-white/60 leading-tight">Shopper logins every month</p>
                                        <p class="text-2xl font-800 tracking-tight leading-tight">+<span id="logins">1,000</span> <span class="text-xs font-400 text-white/60 tracking-normal">leads to follow up</span></p>
                                    </div>
                                </div>
                                <p class="text-xs text-black/40 mt-2">Assumes conversion rises 1.5 points and 5% of visitors log in to try on. Results vary.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Trust Bar: Minimalist -->
<!-- TRUST BAR HIDDEN FOR NOW
        <section class="py-6 border-y border-white/5">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                    <span class="text-[10px] uppercase tracking-[0.3em] text-on-surface/90 font-800">Trusted by growing
                        fashion brands</span>
                    <div
                        class="flex flex-wrap justify-center items-center gap-16 opacity-30 hover:opacity-60 transition-opacity">
                        <span class="text-lg font-700 tracking-tighter serif-italic">FashionNova</span>
                        <span class="text-lg font-700 tracking-widest uppercase">Urban Thread</span>
                        <span class="text-lg font-700 tracking-tight">Minimal Mode</span>
                        <span
                            class="text-lg font-700 tracking-tighter serif-text-primary-container opacity-100">Studio
                            Wear</span>
                        <span class="text-lg font-700 tracking-[0.2em] uppercase">VogueFit</span>
                    </div>
                </div>
            </div>
        </section>
-->
        <!-- Interactive Features: two-up layout, one screen -->
        <section class="screen py-20 relative">
            <div class="absolute -left-40 top-1/2 w-[600px] h-[600px] aura-glow opacity-30"></div>
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-12 gap-gutter mb-8 items-end">
                    <div class="col-span-12 lg:col-span-6">
                        <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white">
                            <?= ttl('trust.title') ?>
                        </h2>
                    </div>
                    <div class="col-span-12 lg:col-span-5 lg:col-start-8">
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('trust.text') ?>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Feature 1 -->
                    <div class="group space-y-5">
                        <div class="overflow-hidden relative">
                            <img alt="One shopper in a linen shirt, a tailored blazer and a kurta set" class="w-full h-56 lg:h-[30vh] object-cover object-top group-hover:scale-105 transition-transform duration-700" src="<?= img('trust1.image') ?>" />
                            <span class="absolute top-0 left-0 glass-card px-4 py-2 text-2xl font-800 text-white/60">01</span>
                        </div>
                        <div class="text-[10px] uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('trust1.tag') ?></div>
                        <h3 class="text-2xl font-800 text-white leading-tight"><?= e('trust1.title') ?></h3>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('trust1.text') ?>
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-4 text-sm font-medium border-b border-white/5 pb-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check_circle</span>
                                <?= e('trust1.b1') ?>
                            </li>
                            <li class="flex items-center gap-4 text-sm font-medium border-b border-white/5 pb-2">
                                <span class="material-symbols-outlined text-primary-container text-sm">check_circle</span>
                                <?= e('trust1.b2') ?>
                            </li>
                        </ul>
                    </div>
                    <!-- Feature 2 -->
                    <div class="group space-y-5">
                        <div class="overflow-hidden relative">
                            <img alt="Shopper viewing her private try-on photo on her phone" class="w-full h-56 lg:h-[30vh] object-cover object-center group-hover:scale-105 transition-transform duration-700" src="<?= img('trust2.image') ?>" />
                            <span class="absolute top-0 left-0 glass-card px-4 py-2 text-2xl font-800 text-white/60">02</span>
                        </div>
                        <div class="text-[10px] uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('trust2.tag') ?></div>
                        <h3 class="text-2xl font-800 text-white leading-tight"><?= e('trust2.title') ?></h3>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('trust2.text') ?>
                        </p>
                        <div class="p-4 border border-primary-container/30 bg-primary-container/5">
                            <p class="text-xs font-800 uppercase tracking-widest text-primary-container mb-1"><?= e('trust2.note_title') ?></p>
                            <p class="text-lg opacity-80 font-light"><?= e('trust2.note') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Brix-Tryon in numbers -->
        <section id="numbers" class="screen py-16 bg-surface">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center space-y-4 mb-14">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('num.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] font-extrabold text-white tracking-tight"><?= e('num.title') ?></h2>
                    <p class="text-lg text-on-surface-variant font-light max-w-3xl mx-auto leading-relaxed">
                        <?= e('num.text') ?>
                    </p>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12 text-center">
                    <div class="space-y-4">
                        <p class="text-6xl lg:text-8xl font-extrabold tracking-tight leading-none bg-gradient-to-r from-[#C93B83] via-[#E0609F] to-[#F58DBA] bg-clip-text text-transparent"><span data-count="<?= (int) e('num1.value') ?>" data-prefix="" data-suffix="">0</span></p>
                        <p class="text-lg text-on-surface-variant leading-snug max-w-[16rem] mx-auto"><?= e('num1.label') ?></p>
                    </div>
                    <div class="space-y-4">
                        <p class="text-6xl lg:text-8xl font-extrabold tracking-tight leading-none bg-gradient-to-r from-[#C93B83] via-[#E0609F] to-[#F58DBA] bg-clip-text text-transparent"><span data-count="<?= (int) e('num2.value') ?>" data-prefix="" data-suffix="">0</span></p>
                        <p class="text-lg text-on-surface-variant leading-snug max-w-[16rem] mx-auto"><?= e('num2.label') ?></p>
                    </div>
                    <div class="space-y-4">
                        <p class="text-6xl lg:text-8xl font-extrabold tracking-tight leading-none bg-gradient-to-r from-[#C93B83] via-[#E0609F] to-[#F58DBA] bg-clip-text text-transparent"><span data-count="<?= (int) e('num3.value') ?>" data-prefix="" data-suffix="">0</span></p>
                        <p class="text-lg text-on-surface-variant leading-snug max-w-[16rem] mx-auto"><?= e('num3.label') ?></p>
                    </div>
                    <div class="space-y-4">
                        <p class="text-6xl lg:text-8xl font-extrabold tracking-tight leading-none bg-gradient-to-r from-[#C93B83] via-[#E0609F] to-[#F58DBA] bg-clip-text text-transparent"><span data-count="<?= (int) e('num4.value') ?>" data-prefix="" data-suffix="">0</span></p>
                        <p class="text-lg text-on-surface-variant leading-snug max-w-[16rem] mx-auto"><?= e('num4.label') ?></p>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- Core features -->
        <section id="features" class="screen py-20 bg-background">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center space-y-3 mb-8">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('cf.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white"><?= ttl('cf.title') ?></h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">tune</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">01</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf1.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf1.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-center justify-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-neutral-300"></span><span class="w-6 h-6 rounded-full bg-neutral-500"></span><span class="w-6 h-6 rounded-full bg-neutral-700 ring-2 ring-white"></span>
                            <span class="text-[10px] uppercase tracking-widest border border-white/30 px-2 py-1">Desktop · Mobile</span>
                        </div></div>
                    </div>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">lock</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">02</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf2.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf2.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined text-2xl">lock</span>
                            <span class="text-[10px] uppercase tracking-widest border border-white/30 px-2 py-1">Photo never stored</span>
                        </div></div>
                    </div>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">grid_view</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">03</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf3.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf3.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-center justify-center gap-3">
                            <span class="relative w-9 h-9 bg-neutral-600"><span class="absolute -top-1 -right-1 w-4 h-4 bg-[#ffffff] text-black rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-[10px]">photo_camera</span></span></span>
                            <span class="relative w-9 h-9 bg-neutral-500"><span class="absolute -top-1 -right-1 w-4 h-4 bg-[#ffffff] text-black rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-[10px]">photo_camera</span></span></span>
                            <span class="relative w-9 h-9 bg-neutral-400"><span class="absolute -top-1 -right-1 w-4 h-4 bg-[#ffffff] text-black rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-[10px]">photo_camera</span></span></span>
                        </div></div>
                    </div>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">toggle_on</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">04</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf4.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf4.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-center justify-center gap-3 text-[10px] uppercase tracking-widest">
                            <span class="border border-white/30 px-2 py-1">Collection</span><span class="material-symbols-outlined text-sm">arrow_forward</span><span class="bg-[#ffffff] text-black px-2 py-1 font-800">Try-on on</span>
                        </div></div>
                    </div>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">insights</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">05</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf5.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf5.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-end justify-center gap-2 pb-3">
                            <span class="w-3 bg-white/30 h-4"></span><span class="w-3 bg-white/40 h-6"></span><span class="w-3 bg-white/50 h-5"></span><span class="w-3 bg-white/70 h-9"></span><span class="w-3 bg-[#ffffff] h-12"></span>
                            <span class="text-[10px] font-800 ml-2 self-start pt-2">Cart rate</span>
                        </div></div>
                    </div>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]">forum</span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30">06</span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= e('cf6.title') ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= e('cf6.text') ?></p>
                        <div class="mt-auto pt-2"><div class="h-20 bg-black/40 border border-white/5 flex items-center justify-center gap-2 text-[10px] uppercase tracking-widest">
                            <span class="border border-white/30 px-2 py-1">Email</span><span class="border border-white/30 px-2 py-1">Phone</span><span class="border border-white/30 px-2 py-1">Save</span>
                            <span class="bg-[#ffffff] text-black px-2 py-1 font-800">WhatsApp</span>
                        </div></div>
                    </div>
                </div>
                <p class="text-lg text-center mt-5"><a href="#pricing" class="text-[11px] uppercase tracking-[0.2em] font-800 text-white hover:text-primary-container transition-colors">See pricing &rarr;</a></p>
            </div>
        </section>
        <!-- Benefits: why virtual try-on pays off -->
        <section id="benefits" class="screen py-20 bg-surface">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center space-y-3 mb-8">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('benefits.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white"><?= ttl('benefits.title') ?></h2>
                    <p class="text-lg text-on-surface-variant font-light max-w-2xl mx-auto leading-relaxed"><?= e('benefits.text') ?></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach (items('benefits') as $i => $b): ?>
                    <div class="fc-card group relative overflow-hidden p-7 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <span class="fc-icon w-11 h-11 flex items-center justify-center rounded-full bg-[#ffffff] text-black"><span class="material-symbols-outlined text-[22px]"><?= h($b['icon']) ?></span></span>
                            <span class="text-[11px] font-800 tracking-[0.3em] text-white/30"><?= sprintf('%02d', $i + 1) ?></span>
                        </div>
                        <p class="text-lg font-800 text-white tracking-tight"><?= h($b['title']) ?></p>
                        <p class="text-lg text-on-surface-variant leading-relaxed"><?= h($b['text']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- The Journey: three steps in one row -->
        <section id="journey" class="screen py-20 bg-[#ffffff] text-neutral-900">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center mb-14 space-y-3">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-neutral-500"><?= e('jr.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-neutral-900"><?= ttl('jr.title', 'serif-italic font-normal') ?></h2>
                </div>
                <div class="relative grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="hidden lg:block absolute top-7 left-[16%] right-[16%] border-t border-dashed border-neutral-300"></div>
                    <div class="jr-card relative bg-neutral-50 border border-neutral-200 rounded-3xl p-8 pt-12 text-center space-y-5">
                        <span class="absolute -top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-neutral-900 text-white flex items-center justify-center text-lg font-800 ring-8 ring-white">1</span>
                        <div class="mx-auto w-20 h-20 rounded-2xl bg-[#ffffff] border border-neutral-200 flex items-center justify-center shadow-sm"><span class="material-symbols-outlined text-4xl text-neutral-900">upload_file</span></div>
                        <h3 class="text-2xl font-800 tracking-tight"><?= e('jr1.title') ?></h3>
                        <p class="text-lg text-neutral-600 leading-relaxed"><?= e('jr1.text') ?></p>
                    </div>
                    <div class="jr-card relative bg-neutral-50 border border-neutral-200 rounded-3xl p-8 pt-12 text-center space-y-5">
                        <span class="absolute -top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-neutral-900 text-white flex items-center justify-center text-lg font-800 ring-8 ring-white">2</span>
                        <div class="relative mx-auto w-full max-w-[16rem] h-20 rounded-2xl overflow-hidden border border-neutral-200 shadow-sm">
                            <img class="w-full h-full object-cover object-[50%_25%]" src="<?= img('jr2.image') ?>" alt="" />
                            <span class="absolute inset-0 flex items-center justify-center"><span class="bg-[#ffffff]/90 text-neutral-900 text-[10px] uppercase tracking-widest font-800 px-3 py-1.5 rounded-full"><?= e('jr2.badge') ?></span></span>
                        </div>
                        <h3 class="text-2xl font-800 tracking-tight"><?= e('jr2.title') ?></h3>
                        <p class="text-lg text-neutral-600 leading-relaxed"><?= e('jr2.text') ?></p>
                    </div>
                    <div class="jr-card relative bg-neutral-50 border border-neutral-200 rounded-3xl p-8 pt-12 text-center space-y-5">
                        <span class="absolute -top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-neutral-900 text-white flex items-center justify-center text-lg font-800 ring-8 ring-white">3</span>
                        <div class="mx-auto w-20 h-20 rounded-2xl bg-[#ffffff] border border-neutral-200 flex items-center justify-center shadow-sm"><span class="material-symbols-outlined text-4xl text-neutral-900">shopping_bag</span></div>
                        <h3 class="text-2xl font-800 tracking-tight serif-italic"><?= e('jr3.title') ?></h3>
                        <p class="text-lg text-neutral-600 leading-relaxed"><?= e('jr3.text') ?></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Try it free: live one-credit demo -->
        <section id="try-free" class="screen py-14 bg-surface">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center space-y-3 mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('tf.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white"><?= ttl('tf.title') ?></h2>
                    <p class="text-lg text-on-surface-variant font-light leading-relaxed max-w-2xl mx-auto"><?= e('tf.text') ?></p>
                </div>
                <div class="tf-card">
                    <div class="tf-cols">
                        <div class="tf-col">
                            <div class="tf-step"><b>1</b>Choose a piece</div>
                            <div class="tf-grid" id="tf-thumbs">
                            <button type="button" class="tf-thumb tf-sel" data-g="dress" data-name="Sage Floral Wrap Dress" data-src="assets/studio-dress-model.jpg" aria-pressed="true">
                                <span class="tfp"><img src="assets/studio-dress-model.jpg" alt="Sage Floral Wrap Dress" loading="lazy" /></span>
                                <span class="tfl">Sage Floral Wrap Dress</span>
                            </button>
                            <button type="button" class="tf-thumb" data-g="denim" data-name="Classic Denim Jacket" data-src="assets/look-w3-result.jpg" aria-pressed="false">
                                <span class="tfp"><img src="assets/look-w3-result.jpg" alt="Classic Denim Jacket" loading="lazy" /></span>
                                <span class="tfl">Classic Denim Jacket</span>
                            </button>
                            <button type="button" class="tf-thumb" data-g="suit" data-name="Navy Three-Piece Suit" data-src="assets/look-m1-result.jpg" aria-pressed="false">
                                <span class="tfp"><img src="assets/look-m1-result.jpg" alt="Navy Three-Piece Suit" loading="lazy" /></span>
                                <span class="tfl">Navy Three-Piece Suit</span>
                            </button>
                            <button type="button" class="tf-thumb" data-g="hoodie" data-name="Oversized Hoodie Set" data-src="assets/look-m2-result.jpg" aria-pressed="false">
                                <span class="tfp"><img src="assets/look-m2-result.jpg" alt="Oversized Hoodie Set" loading="lazy" /></span>
                                <span class="tfl">Oversized Hoodie Set</span>
                            </button>
                            <button type="button" class="tf-thumb" data-g="shirt" data-name="Linen Shirt" data-src="assets/studio-flat-model.jpg" aria-pressed="false">
                                <span class="tfp"><img src="assets/studio-flat-model.jpg" alt="Linen Shirt" loading="lazy" /></span>
                                <span class="tfl">Linen Shirt</span>
                            </button>
                            <button type="button" class="tf-thumb" data-g="coat" data-name="Fur-Collar Wool Coat" data-src="assets/model-fur-collar-coat.jpg" aria-pressed="false">
                                <span class="tfp"><img src="assets/model-fur-collar-coat.jpg" alt="Fur-Collar Wool Coat" loading="lazy" /></span>
                                <span class="tfl">Fur-Collar Wool Coat</span>
                            </button>
                            </div>
                        </div>
                        <div class="tf-col">
                            <div class="tf-step"><b>2</b>Your photo</div>
                            <label id="tf-drop" for="tf-file" class="tf-frame tf-drop">
                                <img id="tf-preview" alt="Your photo" class="tf-fill hidden" />
                                <span id="tf-drop-hint" class="tf-center">
                                    <span class="tf-ico"><span class="material-symbols-outlined">add_a_photo</span></span>
                                    <span class="tf-h">Upload a full-length photo</span>
                                    <span class="tf-s">Stand straight, good light, one person</span>
                                    <span class="tf-pick">Choose photo</span>
                                </span>
                                <span id="tf-scan" class="tf-scan hidden"></span>
                            </label>
                            <input id="tf-file" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" />
                        </div>
                        <div class="tf-col">
                            <div class="tf-step"><b>3</b>Your try-on</div>
                            <div class="tf-frame">
                                <img id="tf-garment" src="assets/studio-dress-model.jpg" alt="" class="tf-fill tf-ghost" />
                                <img id="tf-result" alt="Your try-on result" class="tf-fill hidden" />
                                <div id="tf-status" class="tf-center tf-status">
                                    <span id="tf-status-icon" class="material-symbols-outlined">auto_awesome</span>
                                    <p id="tf-status-text" class="tf-h">Your result appears here</p>
                                    <p id="tf-status-sub" class="tf-s"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-bar">
                        <button id="tf-go" type="button" class="tf-go" disabled>
                                    <span class="material-symbols-outlined text-base">checkroom</span>Try it on &middot; free
                                </button>
                        <a id="tf-download" class="tf-dl hidden" download="brix-tryon.png"><span class="material-symbols-outlined text-base">download</span>Save image</a>
                        <button id="tf-cta" type="button" class="tf-cta cta-button hidden">Get this on your store</button>
                        <p id="tf-msg" class="tf-msg">Your photo is used once to create the try-on and is not stored.</p>
                        <p id="tf-badge" class="tf-badge"><span class="material-symbols-outlined text-base">redeem</span><span id="tf-badge-text">1 free try available</span></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Shopify Section: Editorial Overlap -->
        <section class="screen py-20 relative overflow-hidden bg-background">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-12 gap-gutter items-center">
                    <div class="col-span-12 lg:col-span-7 relative">
                        <div class="sf-card">
                            <div class="sf-preview">
                                <div class="sf-store"><b>NORTHLINE APPAREL</b><span class="material-symbols-outlined">shopping_bag</span></div>
                                <div class="sf-prod">
                                    <div class="sf-img"><img src="assets/studio-dress-model.jpg" alt="Product page preview" loading="lazy" /></div>
                                    <div class="sf-info">
                                        <b class="sf-title">Sage Floral Wrap Dress</b>
                                        <span class="sf-price">$79.00</span>
                                        <div class="sf-sizes"><i>S</i><i class="on">M</i><i>L</i></div>
                                        <div class="sf-cart">Add to cart</div>
                                        <div class="sf-try"><span class="material-symbols-outlined">photo_camera</span>Try On This Look</div>
                                        <span class="sf-pow">Powered by Brix-Tryon</span>
                                    </div>
                                </div>
                            </div>
                            <ol class="sf-steps">
                                <li class="sf-step sf-s1">
                                    <span class="sf-num"><span class="material-symbols-outlined">download</span></span>
                                    <span class="sf-txt"><b>1. Install the app</b><small>Add Brix-Tryon from the Shopify App Store in a couple of clicks.</small></span>
                                    <span class="sf-ok"><span class="material-symbols-outlined">check_circle</span></span>
                                </li>
                                <li class="sf-step sf-s2">
                                    <span class="sf-num"><span class="material-symbols-outlined">widgets</span></span>
                                    <span class="sf-txt"><b>2. Add the app block</b><small>Drop the Try On button into your product page in the theme editor.</small></span>
                                    <span class="sf-ok"><span class="material-symbols-outlined">check_circle</span></span>
                                </li>
                                <li class="sf-step sf-s3">
                                    <span class="sf-num"><span class="material-symbols-outlined">toggle_on</span></span>
                                    <span class="sf-txt"><b>3. Enable try-on</b><small>Switch it on for a whole collection or just the products you choose.</small></span>
                                    <span class="sf-ok"><span class="material-symbols-outlined">check_circle</span></span>
                                </li>
                                <li class="sf-step sf-s4">
                                    <span class="sf-num"><span class="material-symbols-outlined">rocket_launch</span></span>
                                    <span class="sf-txt"><b>4. Go live</b><small>Shoppers can start trying on your clothes straight away.</small></span>
                                    <span class="sf-ok"><span class="material-symbols-outlined">check_circle</span></span>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-5 lg:col-start-8 space-y-5">
                        <h2 class="shop-title text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white"><?= ttl('shop.title') ?></h2>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('shop.text') ?>
                        </p>
                        <div class="space-y-3">
                            <div class="sf-feat"><span class="sf-dot"><span class="material-symbols-outlined">check</span></span><span class="text-sm tracking-widest uppercase font-700 text-on-surface/80"><?= e('shop.b1') ?></span></div>
                            <div class="sf-feat"><span class="sf-dot"><span class="material-symbols-outlined">check</span></span><span class="text-sm tracking-widest uppercase font-700 text-on-surface/80"><?= e('shop.b2') ?></span></div>
                        </div>
                        <div class="pt-1">
                            <div class="inline-block border-l-4 border-primary-container px-6 py-2 bg-white/5">
                                <p class="text-xs uppercase tracking-[0.2em] font-800 text-primary-container"><?= e('shop.note_title') ?></p>
                                <p class="text-lg text-white/100"><?= e('shop.note') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Analytics: live try-on dashboard -->
        <section id="live" class="screen py-16 bg-background relative border-y border-white/5">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-12 gap-gutter items-center">
                    <div class="col-span-12 lg:col-span-5 space-y-5">
                        <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('an.eyebrow') ?></p>
                        <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white">
                            <?= ttl('an.title') ?>
                        </h2>
                        <p class="text-lg text-on-surface-variant font-light leading-relaxed">
                            <?= e('an.text') ?>
                        </p>
                        <div class="grid grid-cols-3 gap-3 pt-2">
                            <div class="border border-white/15 bg-white/5 p-3">
                                <p class="text-lg font-extrabold tracking-tight text-white" id="kpi-today">1,299</p>
                                <p class="text-xs uppercase tracking-widest text-white/60 mt-1">Sample try-ons</p>
                            </div>
                            <div class="border border-white/15 bg-white/5 p-3">
                                <p class="text-lg font-extrabold tracking-tight text-white" id="kpi-cart">19.3%</p>
                                <p class="text-xs uppercase tracking-widest text-white/60 mt-1">Sample cart rate</p>
                            </div>
                            <div class="border border-white/15 bg-white/5 p-3">
                                <p class="text-lg font-extrabold tracking-tight text-white">100</p>
                                <p class="text-xs uppercase tracking-widest text-white/60 mt-1">Try-ons a month included</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-7">
                        <div class="glass-card overflow-hidden">
                            <div class="flex items-center justify-between px-5 py-3 border-b border-white/10">
                                <p class="text-xs uppercase tracking-[0.25em] font-800 text-white flex items-center gap-2"><span class="relative flex w-2 h-2"><span class="absolute inline-flex w-full h-full rounded-full bg-[#ffffff] opacity-70 animate-ping"></span><span class="relative inline-flex w-2 h-2 rounded-full bg-[#ffffff]"></span></span>Sample feed</p>
                                <p class="text-xs uppercase tracking-widest text-white/50">Simulated demo data</p>
                            </div>
                            <ul id="live-feed" class="divide-y divide-white/10 h-[19.5rem] overflow-hidden"></ul>
                            <div class="border-t border-white/10 px-5 pt-3 pb-4">
                                <p class="text-xs uppercase tracking-widest text-white/50 mb-2">Try-ons over time (sample)</p>
                                <svg id="live-chart" viewBox="0 0 400 60" preserveAspectRatio="none" class="w-full h-14">
                                    <polygon id="live-area" fill="rgba(254,184,215,0.35)" points="" />
                                    <polyline id="live-line" fill="none" stroke="#C93B83" stroke-width="2" stroke-linejoin="round" points="" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product DNA Comparison: Minimalist Line Art -->
        <section id="dna" class="screen py-20">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] text-center editorial-heading font-800 text-white mb-8"><?= ttl('dna.title') ?></h2>
                <div class="grid grid-cols-12 border-t border-white/10">
                    <!-- Feature Rows -->
                    <?php foreach (items('compare') as $r): ?>
                    <div class="col-span-12 py-6 border-b border-white/10 grid grid-cols-12 items-center group">
                        <div class="col-span-4 text-xs uppercase tracking-[0.3em] font-800 text-on-surface/90 group-hover:text-on-surface transition-colors"><?= h($r['feature']) ?></div>
                        <div class="col-span-4 text-center font-800 text-primary-container text-sm"><?= h($r['ours']) ?></div>
                        <div class="col-span-4 text-right text-sm text-on-surface/80 font-light"><?= h($r['theirs']) ?></div>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Testimonials: infinite wave slider -->
        <section id="stories" class="screen py-16 relative bg-surface overflow-hidden">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center space-y-3 mb-8">
                    <p class="text-xs uppercase tracking-[0.4em] font-800 text-primary-container"><?= e('stories.eyebrow') ?></p>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] font-extrabold text-white tracking-tight"><?= e('stories.title') ?></h2>
                </div>
            </div>
            <div class="wave-mask relative w-full">
                <div class="wave-track flex gap-6 w-max py-10">
                    <?php foreach (items('testimonials') as $i => $t): ?>
                    <figure class="wave-card shrink-0 w-[19rem] md:w-[22rem]" style="--i:<?= $i ?>">
                        <div class="wave-inner glass-card p-6 h-full flex flex-col justify-between gap-5">
                            <div class="space-y-3">
                                <div class="flex gap-0.5 text-white">
                                    <span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span>
                                </div>
                                <blockquote class="text-lg text-white font-light leading-relaxed">&ldquo;<?= h($t['quote']) ?>&rdquo;</blockquote>
                            </div>
                            <figcaption class="flex items-center gap-3 pt-4 border-t border-white/10">
                                <span class="w-10 h-10 rounded-full bg-[#ffffff] text-black flex items-center justify-center text-xs font-800"><?= h(initials($t['name'])) ?></span>
                                <span><span class="block text-[11px] uppercase tracking-[0.2em] font-800 text-white"><?= h($t['name']) ?></span><span class="block text-[10px] uppercase tracking-[0.15em] text-white/60"><?= h($t['role']) ?></span></span>
                            </figcaption>
                        </div>
                    </figure>
<?php endforeach; ?>
<?php foreach (items('testimonials') as $i => $t): ?>
                    <figure aria-hidden="true" class="wave-card shrink-0 w-[19rem] md:w-[22rem]" style="--i:<?= $i ?>">
                        <div class="wave-inner glass-card p-6 h-full flex flex-col justify-between gap-5">
                            <div class="space-y-3">
                                <div class="flex gap-0.5 text-white">
                                    <span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span><span class="material-symbols-outlined text-base">star</span>
                                </div>
                                <blockquote class="text-lg text-white font-light leading-relaxed">&ldquo;<?= h($t['quote']) ?>&rdquo;</blockquote>
                            </div>
                            <figcaption class="flex items-center gap-3 pt-4 border-t border-white/10">
                                <span class="w-10 h-10 rounded-full bg-[#ffffff] text-black flex items-center justify-center text-xs font-800"><?= h(initials($t['name'])) ?></span>
                                <span><span class="block text-[11px] uppercase tracking-[0.2em] font-800 text-white"><?= h($t['name']) ?></span><span class="block text-[10px] uppercase tracking-[0.15em] text-white/60"><?= h($t['role']) ?></span></span>
                            </figcaption>
                        </div>
                    </figure>
<?php endforeach; ?>
                    
                </div>
            </div>
        </section>
        <!-- Case study + blog -->
        <section id="case-studies" class="screen py-20 bg-background">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="cs-feature">
                    <div class="cs-copy">
                        <span class="cs-tag"><?= e('cs.tag') ?></span>
                        <h2 class="cs-title"><?= ttl('cs.title') ?></h2>
                        <p class="cs-text"><?= e('cs.text') ?></p>
                        <a href="#pricing" class="cs-link">Read the story <span class="material-symbols-outlined">arrow_forward</span></a>
                    </div>
                    <div class="cs-stat" aria-hidden="true">
                        <span class="cs-big">18%</span>
                        <span class="cs-cap">fewer returns</span>
                        <span class="cs-who">Brix-Tryon</span>
                    </div>
                </div>
                <div id="guides" class="cs-guides">
                    <div class="cs-head"><h3>Guides &amp; resources</h3><a href="#" class="cs-all">View all articles <span class="material-symbols-outlined">arrow_forward</span></a></div>
                    <div class="cs-grid">
<?php foreach (items('articles') as $a): ?>
                        <a href="<?= h($a['url'] ?: '#') ?>" class="cs-card">
                            <span class="cs-ico"><span class="material-symbols-outlined"><?= h($a['icon']) ?></span></span>
                            <span class="cs-pill"><?= h($a['tag']) ?></span>
                            <b class="cs-ctitle"><?= h($a['title']) ?></b>
                            <span class="cs-sum"><?= h($a['summary']) ?></span>
                            <span class="cs-foot"><span><?= h($a['meta']) ?></span><span class="material-symbols-outlined">arrow_forward</span></span>
                        </a>
<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Pricing Section -->
        <section id="pricing" class="screen py-24 bg-surface relative border-y border-white/5">
            <div class="absolute inset-0 aura-glow opacity-10"></div>
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
                <!-- Header -->
                <div class="text-center mb-6 space-y-3">
                    <div class="inline-flex items-center gap-4 text-primary-container justify-center">
                        <div class="h-[1px] w-12 bg-primary-container"></div>
                        <span class="text-[10px] uppercase tracking-[0.4em] font-800"><?= e('pr.eyebrow') ?></span>
                        <div class="h-[1px] w-12 bg-primary-container"></div>
                    </div>
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white">
                        <?= ttl('pr.title') ?>
                    </h2>
                    <p class="text-lg text-on-surface-variant font-light max-w-xl mx-auto">
                        <?= e('pr.text') ?>
                    </p>
                </div>

                <!-- Pricing Cards -->
                <?php $plans = items('plans'); ?>
                <?php if (count($plans) === 1): $p = $plans[0]; ?>
                <div class="pp-card mt-10">
                    <div class="pp-buy">
                        <span class="pp-tag"><?= h($p['name']) ?></span>
                        <div class="pp-price"><b><?= h($p['price']) ?></b><span><?= h($p['period']) ?></span></div>
                        <p class="pp-sub"><?= h($p['included']) ?></p>
                        <?php if (trim($p['extra'] ?? '') !== ''): ?><p class="pp-sub"><?= h($p['extra']) ?></p><?php endif; ?>
                        <button class="cta-button bg-primary-container pp-btn"><?= h($p['button']) ?></button>
                        <p class="pp-fine"><?= e('pr.note') ?></p>
                    </div>
                    <div class="pp-feat">
                        <h3>Everything included</h3>
                        <ul>
                            <?php foreach (lines($p['features'] ?? '') as $f): ?>
                            <li><span class="material-symbols-outlined">check</span><?= h($f) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                    <?php foreach ($plans as $p): $feat = !empty($p['featured']) && $p['featured'] !== '0'; ?>
                    <div class="glass-card p-6 flex flex-col <?= $feat ? 'border-t-4 border-primary-container shadow-[0_0_60px_rgba(255,255,255,0.12)] relative' : 'group hover:border-white/20 transition-all duration-300' ?>">
                        <?php if ($feat && trim($p['badge'] ?? '') !== ''): ?>
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span class="bg-primary-container text-on-primary-container text-[10px] uppercase tracking-[0.2em] font-800 px-5 py-1.5 whitespace-nowrap"><?= h($p['badge']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="mb-4">
                            <p class="text-xs uppercase tracking-[0.4em] font-800 <?= $feat ? 'text-primary-container' : 'text-on-surface/60' ?> mb-2"><?= h($p['name']) ?></p>
                            <div class="flex items-end gap-2 mb-2">
                                <span class="text-4xl font-800 text-white"><?= h($p['price']) ?></span>
                                <span class="text-on-surface-variant font-light pb-1"><?= h($p['period']) ?></span>
                            </div>
                            <p class="text-lg text-on-surface-variant font-light"><?= h($p['included']) ?></p>
                            <?php if (trim($p['extra'] ?? '') !== ''): ?><p class="text-lg text-on-surface/50 mt-1"><?= h($p['extra']) ?></p><?php endif; ?>
                        </div>
                        <div class="h-[1px] w-full <?= $feat ? 'bg-primary-container/30' : 'bg-white/10' ?> mb-4"></div>
                        <ul class="space-y-1.5 flex-1 mb-5">
                            <?php foreach (lines($p['features'] ?? '') as $f): ?>
                            <li class="flex items-start gap-3 text-xs text-on-surface-variant">
                                <span class="material-symbols-outlined <?= $feat ? 'text-primary-container' : 'text-primary-container/60' ?> text-sm mt-0.5 flex-shrink-0">check_circle</span>
                                <?= h($f) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <button class="cta-button w-full py-3 <?= $feat ? 'bg-primary-container text-on-primary-container hover:bg-[#ffffff] shadow-[0_10px_30px_-8px_rgba(254,184,215,0.9)]' : 'border border-white/20 text-white hover:bg-white/10' ?> text-[11px] uppercase tracking-[0.2em] font-800 transition-all">
                            <?= h($p['button']) ?>
                        </button>
                    </div>
<?php endforeach; ?>

                </div>

                <!-- Bottom note -->
                <p class="text-xs text-center text-on-surface/40 mt-5 uppercase tracking-[0.2em]">
                    <?= e('pr.note') ?>
                </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="screen py-20 bg-background">
            <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="text-center mb-8 space-y-4">
                    <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-white"><?= ttl('faq.title') ?></h2>
                    <div class="w-24 h-[1px] bg-primary-container mx-auto"></div>
                </div>
                <?php $faqs = items('faqs'); ?>
                <div class="faq-grid">
                    <?php foreach ($faqs as $f): ?>
                    <details class="faq glass-card px-6 py-4">
                        <summary class="flex items-center justify-between gap-4 text-sm font-700 text-white"><?= h($f['question']) ?>
                            <span class="material-symbols-outlined faq-icon text-primary-container">add</span></summary>
                        <p class="text-lg pt-3 text-on-surface-variant font-light leading-relaxed"><?= h($f['answer']) ?></p>
                    </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Final CTA -->
        <section class="screen cta-band relative py-24 bg-primary-container overflow-hidden group">
            <div
                class="absolute inset-0 bg-background opacity-0 group-hover:opacity-10 transition-opacity duration-1000">
            </div>
            <div class="relative z-10 max-w-[1600px] mx-auto px-margin-mobile text-center space-y-8">
                <h2 class="text-4xl lg:text-[clamp(2.5rem,6vh,4rem)] editorial-heading font-800 text-on-primary-container"><?= ttl('cta.title', 'serif-italic font-normal') ?>
                </h2>
                <p class="text-lg text-on-primary-container/70 max-w-2xl mx-auto font-light leading-relaxed">
                    <?= e('cta.text') ?>
                </p>
                <div class="flex flex-wrap justify-center gap-6 pt-2">
                    <button
                        class="cta-button px-12 py-5 bg-background text-white font-800 text-xs uppercase tracking-[0.3em] hover:bg-[#ffffff] hover:text-background transition-all shadow-[0_20px_50px_rgba(0,0,0,0.2)]">
                        <?= e('cta.btn1') ?>
                    </button>
                    <button
                        class="cta-button px-12 py-5 border-2 border-background text-background font-800 text-xs uppercase tracking-[0.3em] hover:bg-background hover:text-white transition-all">
                        <?= e('cta.btn2') ?>
                    </button>
                </div>
            </div>
            <!-- Abstract Decoration -->
            <div
                class="absolute inset-0 z-0 flex items-center justify-center whitespace-nowrap leading-none text-[clamp(64px,14vw,260px)] font-900 text-white/35 select-none pointer-events-none">
                The Brix-Tryon</div>
        </section>
    </main>
    <!-- Footer: High-End Minimalist -->
    <footer class="bg-surface py-6 border-t border-white/5">
        <div class="max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="grid grid-cols-12 gap-gutter">
                <div class="col-span-12 lg:col-span-6 space-y-4">
                    <img src="<?= img('brand.logo') ?>" alt="Brix Try On" class="h-14 w-auto" />
                    <p
                        class="text-xs text-on-surface-variant/100 max-w-sm leading-relaxed uppercase tracking-[0.1em]">
                        <?= e('footer.text') ?>
                    </p>
                    <form id="newsletter" class="max-w-sm space-y-3">
                        <label class="text-white font-800 text-[10px] uppercase tracking-[0.4em]" for="nl-email"><?= e('footer.newsletter') ?></label>
                        <div class="flex">
                            <input id="nl-email" type="email" required placeholder="you@brand.com"
                                class="flex-1 bg-white/5 border border-white/20 text-white px-3 py-2.5 text-sm focus:outline-none focus:border-white" />
                            <button type="submit" class="px-5 bg-[#ffffff] text-black text-[11px] uppercase tracking-[0.2em] font-800 hover:bg-neutral-300 transition-colors">Join</button>
                        </div>
                        <p id="nl-msg" class="text-lg text-on-surface-variant min-h-[1rem]"></p>
                    </form>

                </div>
                <div class="col-span-6 lg:col-span-3 space-y-4">
                    <h4 class="text-xs text-white font-800 uppercase tracking-[0.4em]">Navigation</h4>
                    <div class="flex flex-col gap-3">
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="#live">Intelligence</a>
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="#pricing">Pricing</a>
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="#features">Integrations</a>
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="#case-studies">Case studies</a>
                    </div>
                </div>
                <div class="col-span-6 lg:col-span-3 space-y-4">
                    <h4 class="text-xs text-white font-800 uppercase tracking-[0.4em]">Compliance</h4>
                    <div class="flex flex-col gap-3">
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="terms-of-service.html">Terms of Use</a>
                        <a class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/90 hover:text-white transition-colors"
                            href="privacy-policy.html">Privacy Policy</a>
                    </div>
                </div>
            </div>
            <div
                class="mt-6 pt-4 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs uppercase tracking-[0.3em] text-on-surface-variant/70"><?= e('footer.copyright') ?></p>

            </div>
        </div>
    </footer>
    <!-- Modal Backdrop -->
    <div id="modalBackdrop"
        class="fixed inset-0 z-[200] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <!-- Form Modal -->
        <div id="formModal" class="mdl transform scale-95 transition-transform duration-300">
            <button id="closeFormBtn" class="mdl-x" aria-label="Close"><span class="material-symbols-outlined">close</span></button>
            <aside class="mdl-side">
                <img src="<?= img('brand.logo') ?>" alt="Brix Try On" class="mdl-logo" />
                <h4>Let shoppers try it on, before they buy.</h4>
                <ul>
                    <li><span class="material-symbols-outlined">check_circle</span>100 try-ons a month for $19</li>
                    <li><span class="material-symbols-outlined">check_circle</span>Live on your Shopify store in minutes</li>
                    <li><span class="material-symbols-outlined">check_circle</span>No app for shoppers, no account</li>
                    <li><span class="material-symbols-outlined">check_circle</span>Leads captured on every try-on</li>
                </ul>
                <div class="mdl-quote"><span class="material-symbols-outlined">lock</span>Your details are only used to contact you about Brix-Tryon.</div>
            </aside>
            <div class="mdl-main">
                <div class="mdl-head">
                    <h3><?= e('modal.title') ?></h3>
                    <p><?= e('modal.text') ?></p>
                </div>
                <form id="accessForm">
                    <div class="mdl-grid">
                        <div class="mf">
                            <label for="firstName">First name</label>
                            <input required type="text" id="firstName" placeholder="Jane" />
                        </div>
                        <div class="mf">
                            <label for="lastName">Last name</label>
                            <input required type="text" id="lastName" placeholder="Doe" />
                        </div>
                        <div class="mf">
                            <label for="phone">Phone number</label>
                            <input required type="tel" id="phone" placeholder="+91 98765 43210" />
                        </div>
                        <div class="mf">
                            <label for="email">Email</label>
                            <input required type="email" id="email" placeholder="jane@yourstore.com" />
                        </div>
                        <div class="mf">
                            <label for="company">Company name</label>
                            <input required type="text" id="company" placeholder="Your store name" />
                        </div>
                        <div class="mf">
                            <label for="shopUrl">Shop URL (optional)</label>
                            <input type="url" id="shopUrl" placeholder="https://yourstore.com" />
                        </div>
                    </div>
                    <div class="mdl-actions">
                        <button type="button" id="closeFormBtnBottom" class="mdl-cancel">Close</button>
                        <button type="submit" class="mdl-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thank You Modal -->
        <div id="thankYouModal" class="mdl-thanks hidden transform scale-95 transition-transform duration-300">
            <button id="closeThanksBtn" class="mdl-x" aria-label="Close"><span class="material-symbols-outlined">close</span></button>
            <div class="mdl-tick"><span class="material-symbols-outlined">check</span></div>
            <h3><?= e('thanks.title') ?></h3>
            <p><?= e('thanks.text') ?></p>
            <button id="doneBtn" class="mdl-submit">Close</button>
        </div>
    </div>

    <script>
        (function () {
            const tg = document.getElementById('nav-toggle');
            const panel = document.getElementById('nav-panel');
            if (tg && panel) {
                const set = (open) => {
                    panel.classList.toggle('hidden', !open);
                    tg.setAttribute('aria-expanded', String(open));
                    tg.querySelector('span').textContent = open ? 'close' : 'menu';
                };
                tg.addEventListener('click', () => set(panel.classList.contains('hidden')));
                panel.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => set(false)));
                window.addEventListener('resize', () => { if (window.innerWidth >= 1280) set(false); });
            }
            const nav = document.querySelector('nav');
            const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 40);
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();
        const modalBackdrop = document.getElementById('modalBackdrop');
        const formModal = document.getElementById('formModal');
        const thankYouModal = document.getElementById('thankYouModal');
        const accessForm = document.getElementById('accessForm');
        const closeFormBtn = document.getElementById('closeFormBtn');
        const closeFormBtnBottom = document.getElementById('closeFormBtnBottom');
        const closeThanksBtn = document.getElementById('closeThanksBtn');
        const doneBtn = document.getElementById('doneBtn');

        // Get all CTAs
        const ctas = document.querySelectorAll('.cta-button');

        function openModal() {
            modalBackdrop.classList.remove('hidden');
            modalBackdrop.classList.add('flex');
            // Small delay to allow display:flex to apply before changing opacity
            setTimeout(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalBackdrop.classList.add('opacity-100');
                formModal.classList.remove('scale-95');
                formModal.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            modalBackdrop.classList.remove('opacity-100');
            modalBackdrop.classList.add('opacity-0');
            formModal.classList.remove('scale-100');
            formModal.classList.add('scale-95');
            thankYouModal.classList.remove('scale-100');
            thankYouModal.classList.add('scale-95');

            setTimeout(() => {
                modalBackdrop.classList.remove('flex');
                modalBackdrop.classList.add('hidden');
                // Reset state
                formModal.classList.remove('hidden');
                thankYouModal.classList.add('hidden');
                accessForm.reset();
            }, 300); // match transition duration
        }

        function showThankYou() {
            formModal.classList.add('hidden');
            thankYouModal.classList.remove('hidden');

            setTimeout(() => {
                thankYouModal.classList.remove('scale-95');
                thankYouModal.classList.add('scale-100');
            }, 10);
        }

        ctas.forEach(cta => {
            cta.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        });

        closeFormBtn.addEventListener('click', closeModal);
        closeFormBtnBottom.addEventListener('click', closeModal);
        closeThanksBtn.addEventListener('click', closeModal);
        doneBtn.addEventListener('click', closeModal);

        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                closeModal();
            }
        });

        const LEAD_URL = 'submit.php';

        accessForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const submitBtn = accessForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;

            const formData = new FormData();
            formData.append('firstName', document.getElementById('firstName').value);
            formData.append('lastName', document.getElementById('lastName').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('company', document.getElementById('company').value);
            formData.append('shopUrl', document.getElementById('shopUrl').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('source', 'access-form');

            fetch(LEAD_URL, { method: 'POST', body: formData })
                .then((r) => r.json())
                .then((j) => {
                    if (j && j.ok) showThankYou();
                    else alert(j && j.error === 'bad_email' ? 'Please enter a valid email address.' : 'Sorry, we could not save your details. Please try again.');
                })
                .catch(() => {
                    alert('Sorry, we could not save your details. Please check your connection and try again.');
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });
    
        // ----- Motion & gamification -----
        (function () {
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // scroll progress
            const prog = document.getElementById('scroll-progress');
            const upd = () => {
                const h = document.documentElement.scrollHeight - window.innerHeight;
                prog.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + '%';
            };
            window.addEventListener('scroll', upd, { passive: true });
            upd();

            // count-up
            const runCount = (el) => {
                const end = parseFloat(el.dataset.count);
                const dec = parseInt(el.dataset.decimals || '0', 10);
                const pre = el.dataset.prefix || '', suf = el.dataset.suffix || '';
                if (reduce) { el.textContent = pre + end.toFixed(dec) + suf; return; }
                const t0 = performance.now(), dur = 1600;
                const tick = (t) => {
                    const k = Math.min((t - t0) / dur, 1);
                    const v = end * (1 - Math.pow(1 - k, 3));
                    el.textContent = pre + v.toFixed(dec) + suf;
                    if (k < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            };

            // reveal on scroll
            const targets = Array.from(document.querySelectorAll('main section:not(.screen-hero):not(#ai-studio) > div > .grid > *, main section:not(.screen-hero):not(#ai-studio) > div > *:not(.grid):not(.absolute)')).filter((el) => !el.closest('.wave-mask'));
            targets.forEach((el, i) => {
                el.classList.add('reveal');
                el.style.transitionDelay = ((i % 4) * 90) + 'ms';
            });
            const io = new IntersectionObserver((entries) => {
                entries.forEach((e) => {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('in');
                    e.target.querySelectorAll('[data-count]').forEach(runCount);
                    e.target.querySelectorAll('[data-bar]').forEach((b) => { b.style.width = b.dataset.bar + '%'; });
                    io.unobserve(e.target);
                });
            }, { threshold: 0, rootMargin: '0px 0px -6% 0px' });
            targets.forEach((el) => io.observe(el));
            // bars/counters sitting inside elements that were not tagged
            document.querySelectorAll('[data-count], [data-bar]').forEach((el) => {
                if (el.closest('.reveal')) return;
                const o = new IntersectionObserver((en) => {
                    if (!en[0].isIntersecting) return;
                    if (el.dataset.count) runCount(el);
                    if (el.dataset.bar) el.style.width = el.dataset.bar + '%';
                    o.disconnect();
                }, { threshold: 0.3 });
                o.observe(el);
            });

            // confetti (monochrome)
            function confetti() {
                if (reduce) return;
                const c = document.createElement('canvas');
                c.style.cssText = 'position:fixed;inset:0;width:100%;height:100%;pointer-events:none;z-index:400';
                c.width = innerWidth; c.height = innerHeight;
                document.body.appendChild(c);
                const g = c.getContext('2d');
                const shades = ['#ffffff', '#d4d4d4', '#9e9e9e', '#6b6b6b'];
                const ps = Array.from({ length: 140 }, () => ({
                    x: c.width / 2, y: c.height * 0.55,
                    vx: (Math.random() - 0.5) * 16, vy: -Math.random() * 16 - 4,
                    s: 4 + Math.random() * 6, r: Math.random() * 6, vr: (Math.random() - 0.5) * 0.4,
                    c: shades[Math.floor(Math.random() * shades.length)]
                }));
                let f = 0;
                (function step() {
                    g.clearRect(0, 0, c.width, c.height);
                    ps.forEach((q) => {
                        q.vy += 0.35; q.x += q.vx; q.y += q.vy; q.r += q.vr;
                        g.save(); g.translate(q.x, q.y); g.rotate(q.r);
                        g.fillStyle = q.c; g.fillRect(-q.s / 2, -q.s / 4, q.s, q.s / 2); g.restore();
                    });
                    if (++f < 130) requestAnimationFrame(step); else c.remove();
                })();
            }

            // try-on challenge
            const items = document.querySelectorAll('[data-tryon]');
            if (items.length) {
                const bar = document.getElementById('g-bar');
                const xpEl = document.getElementById('g-xp');
                const lvl = document.getElementById('g-level');
                const msg = document.getElementById('g-msg');
                const total = items.length;
                const render = () => {
                    const n = [...items].filter((b) => b.dataset.on === '1').length;
                    bar.style.width = (n / total * 100) + '%';
                    xpEl.textContent = n * 50;
                    lvl.textContent = n >= total ? 'Icon' : n >= 2 ? 'Trendsetter' : 'Style Rookie';
                    msg.textContent = n === 0 ? 'Pick a piece to try on.'
                        : n === 1 ? 'Nice start. One more unlocks 10% off.'
                        : n < total ? '10% off unlocked. ' + (total - n) + ' more for a free gift.'
                        : 'Free gift unlocked! You are an Icon.';
                    return n;
                };
                items.forEach((b) => b.addEventListener('click', () => {
                    const on = b.dataset.on !== '1';
                    b.dataset.on = on ? '1' : '0';
                    b.classList.toggle('bg-[#FEB8D7]', on);
                    b.classList.toggle('text-black', on);
                    b.querySelector('.state').textContent = on ? 'Tried on  +50 XP' : 'Tap to try on';
                    b.classList.remove('pop'); void b.offsetWidth; b.classList.add('pop');
                    xpEl.classList.remove('pop'); void xpEl.offsetWidth; xpEl.classList.add('pop');
                    if (render() === total && on) confetti();
                }));
                document.getElementById('g-reset').addEventListener('click', () => {
                    items.forEach((b) => {
                        b.dataset.on = '0';
                        b.classList.remove('bg-[#FEB8D7]', 'text-black');
                        b.querySelector('.state').textContent = 'Tap to try on';
                    });
                    render();
                });
            }

            // newsletter (front-end only)
            const nl = document.getElementById('newsletter');
            if (nl) nl.addEventListener('submit', (e) => {
                e.preventDefault();
                const msg = document.getElementById('nl-msg');
                const fd = new FormData();
                fd.append('email', document.getElementById('nl-email').value);
                fd.append('source', 'newsletter');
                fetch(LEAD_URL, { method: 'POST', body: fd })
                    .then((r) => r.json())
                    .then((j) => { msg.textContent = j && j.ok ? 'Thanks! You are on the list.' : 'Please check your email address and try again.'; if (j && j.ok) nl.reset(); })
                    .catch(() => { msg.textContent = 'Something went wrong. Please try again.'; });
            });
        })();
    
        // ----- Hero try-on demo loop -----
        (function () {
            const demo = document.querySelector('.tryon-demo');
            if (!demo) return;
            // the screens are fixed-size pages scaled to fit the photo of the laptop / phone
            const inners = demo.querySelectorAll('.dm-inner');
            const resize = () => inners.forEach((el) => { el.style.transform = 'scale(' + (el.parentElement.clientWidth / Number(el.dataset.w)) + ')'; });
            resize();
            new ResizeObserver(resize).observe(demo);
            window.addEventListener('resize', resize);
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const pcts = demo.querySelectorAll('.demo-pct');
            const bars = demo.querySelectorAll('.demo-bar');
            const setProg = (v) => { pcts.forEach((e) => { e.textContent = v + '%'; }); bars.forEach((e) => { e.style.width = v + '%'; }); };
            const timers = demo.querySelectorAll('.demo-timer');
            const lengths = [2600, 2400, 1600, 3600, 4200];
            const emails = demo.querySelectorAll('.type-email');
            const phones = demo.querySelectorAll('.type-phone');
            let typer = null;
            function typeFields() {
                const e = 'alex@email.com', ph = '+1 555 0142';
                let i = 0;
                emails.forEach((x) => { x.textContent = ''; x.classList.add('caret'); });
                phones.forEach((x) => { x.textContent = ''; });
                clearInterval(typer);
                typer = setInterval(() => {
                    i++;
                    if (i <= e.length) {
                        emails.forEach((x) => { x.textContent = e.slice(0, i); });
                    } else if (i <= e.length + ph.length) {
                        emails.forEach((x) => x.classList.remove('caret'));
                        phones.forEach((x) => { x.classList.add('caret'); x.textContent = ph.slice(0, i - e.length); });
                    } else {
                        phones.forEach((x) => x.classList.remove('caret'));
                        clearInterval(typer);
                    }
                }, 70);
            }
            // rotating showcase: professional -> casual
            const LOOKS = [
                { id: 'm1', name: 'Navy Three-Piece Suit', slug: 'navy-three-piece-suit', price: 349 },
                { id: 'w2', name: 'Sage Floral Wrap Dress', slug: 'sage-floral-wrap-dress', price: 79 },
                { id: 'w3', name: 'Classic Denim Jacket', slug: 'classic-denim-jacket', price: 89 },
                { id: 'm2', name: 'Oversized Hoodie Set', slug: 'oversized-hoodie-set', price: 119 },
            ];
            const lookSrc = (l, k) => 'assets/look-' + l.id + '-' + k + '.jpg';
            LOOKS.forEach((l) => ['garment', 'person', 'result'].forEach((k) => { new Image().src = lookSrc(l, k); }));
            let lookIdx = 0, looped = false;
            const setLook = (i) => {
                const l = LOOKS[i];
                ['garment', 'person', 'result'].forEach((k) => demo.querySelectorAll('[data-look="' + k + '"]').forEach((im) => { im.src = lookSrc(l, k); }));
                demo.querySelectorAll('[data-look-text="name"]').forEach((e) => { e.textContent = l.name; });
                demo.querySelectorAll('[data-look-text="price"]').forEach((e) => { e.textContent = '$' + l.price; });
                demo.querySelectorAll('[data-look-text="price2"]').forEach((e) => { e.textContent = '$' + l.price + '.00'; });
                demo.querySelectorAll('[data-look-text="url"]').forEach((e) => { e.textContent = 'northlineapparel.com/products/' + l.slug; });
            };
            let step = 0, timer = null, raf = null, tick = null, left = 534;
            const fmt = (n) => String(Math.floor(n / 60)).padStart(2, '0') + ':' + String(n % 60).padStart(2, '0');
            const setTimer = () => timers.forEach((t) => { t.textContent = fmt(left); });
            if (reduce) { demo.dataset.step = '4'; setProg(100); emails.forEach((x) => { x.textContent = 'alex@email.com'; }); phones.forEach((x) => { x.textContent = '+1 555 0142'; }); return; }
            function progress(ms) {
                const t0 = performance.now();
                (function frame(t) {
                    const k = Math.max(0, Math.min((performance.now() - t0) / ms, 1));
                    setProg(Math.round(k * 100));
                    if (k < 1) raf = requestAnimationFrame(frame);
                })(t0);
            }
            function go(n) {
                step = n;
                demo.dataset.step = String(n);
                if (n === 2) progress(lengths[2] - 300);
                if (n === 3) typeFields();
                if (n === 0) { clearInterval(typer); emails.forEach((x) => { x.textContent = ''; }); phones.forEach((x) => { x.textContent = ''; }); }
                if (n === 3) {
                    left = 534; setTimer();
                    clearInterval(tick);
                    tick = setInterval(() => { left = Math.max(left - 1, 0); setTimer(); }, 1000);
                }
                if (n === 0) { clearInterval(tick); if (looped) { lookIdx = (lookIdx + 1) % LOOKS.length; setLook(lookIdx); } looped = true; }
                timer = setTimeout(() => go((n + 1) % 5), lengths[n]);
            }
            const vis = new IntersectionObserver((en) => {
                if (en[0].isIntersecting) { if (!timer) go(step); }
                else { clearTimeout(timer); timer = null; clearInterval(tick); cancelAnimationFrame(raf); }
            }, { threshold: 0.2 });
            vis.observe(demo);
        })();
    
        // ----- Why section: cycle through six looks (3 women, 3 men) -----
        (function () {
            const result = document.querySelector('.why-result-img');
            if (!result) return;
            const items = [
                { before: 'assets/look-m1-person.jpg', after: 'assets/look-m1-result.jpg', name: 'Navy Three-Piece Suit', price: '$349', color: 'Navy' },
                { before: 'assets/look-w2-person.jpg', after: 'assets/look-w2-result.jpg', name: 'Sage Floral Wrap Dress', price: '$79', color: 'Sage' },
                { before: 'assets/look-m2-person.jpg', after: 'assets/look-m2-result.jpg', name: 'Oversized Hoodie Set', price: '$119', color: 'Charcoal' },
                { before: 'assets/look-w3-person.jpg', after: 'assets/look-w3-result.jpg', name: 'Classic Denim Jacket', price: '$89', color: 'Light wash' },
            ];
            items.forEach((it) => { new Image().src = it.before; new Image().src = it.after; });
            let i = 0;
            const apply = (it) => {
                document.querySelectorAll('.why-name').forEach((e) => { e.textContent = it.name; });
                document.querySelectorAll('.why-price').forEach((e) => { e.textContent = it.price; });
                document.querySelectorAll('.why-color').forEach((e) => { e.textContent = it.color; });
                document.querySelector('.why-before-img').src = it.before;
                document.querySelector('.why-base-img').src = it.before;
                result.src = it.after;
            };
            // swap while the result is hidden (end of each 7s loop)
            result.addEventListener('animationiteration', () => { i = (i + 1) % items.length; apply(items[i]); });
        })();
    
        // ----- Conversion revenue calculator -----
        (function () {
            const vis = document.getElementById('in-vis');
            if (!vis) return;
            const aov = document.getElementById('in-aov');
            const cr = document.getElementById('in-cr');
            const $ = (id) => document.getElementById(id);
            const LIFT = 1.5;          // conversion rate goes up by 1.5 percentage points
            const LOGIN_RATE = 0.05;   // share of visitors who log in to try on
            const fmt = (n) => Math.round(n).toLocaleString('en-US');
            const cur = { now: 0, nw: 0, gain: 0, logins: 0, on: 0, nn: 0 };
            let raf = null;
            function tween(to) {
                cancelAnimationFrame(raf);
                const from = Object.assign({}, cur);
                const t0 = performance.now(), dur = 450;
                (function f(t) {
                    const k = Math.min((t - t0) / dur, 1);
                    const e = 1 - Math.pow(1 - k, 3);
                    Object.keys(cur).forEach((key) => { cur[key] = from[key] + (to[key] - from[key]) * e; });
                    $('rev-now').textContent = '$' + fmt(cur.now);
                    $('rev-new').textContent = '$' + fmt(cur.nw);
                    $('gain').textContent = '$' + fmt(cur.gain);
                    $('logins').textContent = fmt(cur.logins);
                    $('ord-now').textContent = fmt(cur.on);
                    $('ord-new').textContent = fmt(cur.nn);
                    if (k < 1) raf = requestAnimationFrame(f);
                })(t0);
            }
            function fill(el) {
                const pct = (el.value - el.min) / (el.max - el.min) * 100;
                el.style.setProperty('--p', pct + '%');
            }
            function calc() {
                const v = Number(vis.value), a = Number(aov.value), c = Number(cr.value);
                [vis, aov, cr].forEach(fill);
                $('v-vis').textContent = fmt(v);
                $('v-aov').textContent = '$' + a;
                $('v-cr').textContent = c.toFixed(1) + '%';
                $('cr-now').textContent = c.toFixed(1) + '%';
                $('cr-new').textContent = (c + LIFT).toFixed(1) + '%';
                const orders = v * (c / 100);
                const newOrders = v * ((c + LIFT) / 100);
                const now = orders * a;
                const nw = newOrders * a;
                tween({ now: now, nw: nw, gain: nw - now, logins: v * LOGIN_RATE, on: orders, nn: newOrders });
            }
            [vis, aov, cr].forEach((el) => el.addEventListener('input', calc));
            calc();
        })();
    
        // ----- Live try-on feed -----
        (function () {
            const feed = document.getElementById('live-feed');
            if (!feed) return;
            const sec = document.getElementById('live');
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const looks = [
                { n: 'Navy Three-Piece Suit', i: 'assets/look-m1-result.jpg' },
                { n: 'Sage Floral Wrap Dress', i: 'assets/look-w2-result.jpg' },
                { n: 'Oversized Hoodie Set', i: 'assets/look-m2-result.jpg' },
                { n: 'Classic Denim Jacket', i: 'assets/look-w3-result.jpg' },
            ];
            const cities = ['Mumbai', 'Berlin', 'Austin', 'Lagos', 'London', 'Dubai', 'Toronto', 'Sydney'];
            const devices = ['Mobile', 'Desktop'];
            const states = ['Tried on', 'Saved look', 'Shared', 'Tried on'];
            const pick = (a) => a[Math.floor(Math.random() * a.length)];
            let lookIdx = 0, today = 1299;
            const kToday = document.getElementById('kpi-today');
            const kCart = document.getElementById('kpi-cart');
            const line = document.getElementById('live-line');
            const area = document.getElementById('live-area');
            const series = Array.from({ length: 28 }, (_, k) => 20 + Math.round(10 * Math.sin(k / 3)) + Math.round(Math.random() * 8));

            function row(l, state) {
                const li = document.createElement('li');
                li.className = 'feed-row flex items-center gap-4 px-5 py-2.5';
                li.innerHTML =
                    '<img src="' + l.i + '" alt="" class="w-10 h-12 object-cover shrink-0" />' +
                    '<div class="flex-1 min-w-0"><p class="text-lg font-800 text-white truncate">' + l.n + '</p>' +
                    '<p class="text-lg text-white/55">' + pick(devices) + ' &middot; ' + pick(cities) + ' &middot; just now</p></div>' +
                    '<span class="text-[10px] uppercase tracking-widest font-800 px-2.5 py-1 ' +
                    (state === 'Shared' ? 'bg-[#FEB8D7] text-[#2B2440]' : 'border border-white/30 text-white') + '">' + state + '</span>';
                return li;
            }
            function draw() {
                const max = Math.max.apply(null, series), min = Math.min.apply(null, series);
                const pts = series.map((v, k) => {
                    const x = (k / (series.length - 1)) * 400;
                    const y = 54 - ((v - min) / Math.max(max - min, 1)) * 46;
                    return x.toFixed(1) + ',' + y.toFixed(1);
                });
                line.setAttribute('points', pts.join(' '));
                area.setAttribute('points', '0,60 ' + pts.join(' ') + ' 400,60');
            }
            function push() {
                const l = looks[lookIdx++ % looks.length];
                feed.insertBefore(row(l, pick(states)), feed.firstChild);
                while (feed.children.length > 5) feed.removeChild(feed.lastChild);
                today += 1;
                kToday.textContent = today.toLocaleString('en-US');
                kCart.textContent = (19 + Math.random() * 0.6).toFixed(1) + '%';
                series.shift(); series.push(20 + Math.round(10 * Math.sin(lookIdx / 2)) + Math.round(Math.random() * 10));
                draw();
            }
            for (let k = 0; k < 4; k++) push();
            if (reduce) return;
            let timer = null;
            new IntersectionObserver((en) => {
                clearInterval(timer);
                if (en[0].isIntersecting) timer = setInterval(push, 2300);
            }, { threshold: 0.2 }).observe(sec);
        })();
    
        // ----- Try it free (one credit per visitor, enforced on the server) -----
        (function () {
            const $ = (id) => document.getElementById(id);
            const go = $('tf-go');
            if (!go) return;
            const file = $('tf-file'), preview = $('tf-preview'), hint = $('tf-drop-hint'), scan = $('tf-scan');
            const result = $('tf-result'), garmentImg = $('tf-garment');
            const stText = $('tf-status-text'), stSub = $('tf-status-sub'), stIcon = $('tf-status-icon'), st = $('tf-status');
            const msg = $('tf-msg'), badgeText = $('tf-badge-text'), dl = $('tf-download'), cta = $('tf-cta');
            const thumbs = document.querySelectorAll('.tf-thumb');
            let photo = null, garment = thumbs.length ? thumbs[0].dataset.g : 'dress', used = false, busy = false, timer = null;

            function refresh() { go.disabled = !(photo && !used && !busy); }
            function setUsed() {
                used = true;
                badgeText.textContent = 'Free try used';
                msg.textContent = used && result.src ? 'That was your free try. Want this on your own store?' : 'You have already used your free try.';
                cta.classList.remove('hidden');
                refresh();
            }
            function idle(text, sub, icon) {
                st.classList.remove('hidden');
                stText.textContent = text; stSub.textContent = sub || '';
                stIcon.textContent = icon || 'auto_awesome';
            }

            thumbs.forEach((t) => t.addEventListener('click', () => {
                thumbs.forEach((x) => { x.classList.remove('tf-sel'); x.setAttribute('aria-pressed', 'false'); });
                t.classList.add('tf-sel'); t.setAttribute('aria-pressed', 'true');
                garment = t.dataset.g;
                garmentImg.src = t.dataset.src;
            }));

            // resize on the device first: smaller upload, faster try-on
            function readAndResize(f) {
                return new Promise((resolve, reject) => {
                    const fr = new FileReader();
                    fr.onerror = reject;
                    fr.onload = () => {
                        const img = new Image();
                        img.onerror = reject;
                        img.onload = () => {
                            const max = 1024, k = Math.min(1, max / Math.max(img.width, img.height));
                            const c = document.createElement('canvas');
                            c.width = Math.round(img.width * k); c.height = Math.round(img.height * k);
                            c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
                            resolve(c.toDataURL('image/jpeg', 0.9));
                        };
                        img.src = fr.result;
                    };
                    fr.readAsDataURL(f);
                });
            }
            file.addEventListener('change', async () => {
                const f = file.files && file.files[0];
                if (!f) return;
                if (!/^image\//.test(f.type)) { msg.textContent = 'Please choose a photo (JPG, PNG or WebP).'; return; }
                try {
                    photo = await readAndResize(f);
                    preview.src = photo; preview.classList.remove('hidden'); hint.classList.add('hidden');
                    result.classList.add('hidden'); dl.classList.add('hidden');
                    idle('Ready when you are', 'Press "Try it on"', 'checkroom');
                    msg.textContent = 'Your photo is used once to create the try-on and is not stored.';
                } catch (e) { msg.textContent = 'Could not read that photo. Try another one.'; photo = null; }
                refresh();
            });

            const STEPS = ['Reading your photo', 'Finding your shape and pose', 'Fitting the garment', 'Adjusting drape and light', 'Almost there'];
            function startWaiting() {
                const t0 = Date.now();
                scan.classList.remove('hidden');
                st.classList.remove('hidden'); result.classList.add('hidden');
                stIcon.textContent = 'hourglass_top'; stIcon.classList.add('tf-pulse');
                timer = setInterval(() => {
                    const sec = Math.round((Date.now() - t0) / 1000);
                    stText.textContent = STEPS[Math.min(Math.floor(sec / 7), STEPS.length - 1)] + '\u2026';
                    stSub.textContent = sec + 's \u00b7 this can take up to a minute';
                }, 500);
            }
            function stopWaiting() {
                clearInterval(timer); scan.classList.add('hidden'); stIcon.classList.remove('tf-pulse');
            }

            async function status() {
                try {
                    const r = await fetch('/api/tryon/status', { cache: 'no-store', credentials: 'same-origin' });
                    if (!r.ok) throw new Error('x');
                    const j = await r.json();
                    if (j.used) { setUsed(); idle('Free try used', 'Thanks for trying it!', 'lock'); }
                } catch (e) {
                    msg.textContent = 'The live try-on is unavailable right now. Please check back soon.';
                    idle('Try-on unavailable', 'Please check back soon', 'cloud_off');
                    badgeText.textContent = 'Demo offline';
                    go.disabled = true;
                    used = true; // nothing can be spent
                }
            }

            go.addEventListener('click', async () => {
                if (!photo || used || busy) return;
                busy = true; refresh();
                msg.textContent = 'Creating your try-on\u2026';
                startWaiting();
                try {
                    const r = await fetch('/api/tryon', {
                        method: 'POST', credentials: 'same-origin',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ image: photo, garmentId: garment })
                    });
                    const j = await r.json().catch(() => ({}));
                    stopWaiting();
                    if (r.status === 429) { setUsed(); idle('Free try used', 'You have already used your free try.', 'lock'); busy = false; return; }
                    if (r.status === 409) { idle('Still working on your try-on', 'Please wait a moment', 'hourglass_top'); busy = false; refresh(); return; }
                    if (!r.ok || !j.image) throw new Error(j.error || 'failed');
                    result.src = j.image; result.classList.remove('hidden'); st.classList.add('hidden');
                    dl.href = j.image; dl.classList.remove('hidden');
                    busy = false;
                    setUsed();
                    msg.textContent = 'Here it is! That was your free try. Want this on your own store?';
                } catch (e) {
                    stopWaiting();
                    busy = false;
                    idle('That did not work', 'Your free try was not used. Please try again.', 'error');
                    msg.textContent = 'Something went wrong. Your free try was not used.';
                    refresh();
                }
            });

            status();
        })();
    </script>
    <script>
        (function () {
            const t = document.getElementById('rating-toast');
            const hero = document.querySelector('.screen-hero');
            if (!t || !hero) return;
            const OUT = ['translate-x-[130%]', 'opacity-0'];
            let ready = false, inHero = true;
            const sync = () => { if (ready && inHero) t.classList.remove(...OUT); else t.classList.add(...OUT); };
            // slides in from the right once the page has settled, stays while the main section is on screen,
            // slides away when you scroll past it and returns when you come back to it
            setTimeout(() => { ready = true; sync(); }, 1500);
            let raf = 0;
            const check = () => {
                raf = 0;
                const r = hero.getBoundingClientRect();
                // only while the main section still fills the bottom of the screen (next section not showing yet)
                inHero = window.scrollY < 40 || (r.bottom >= window.innerHeight - 8 && r.bottom > 0 && r.top < window.innerHeight * 0.6);
                sync();
            };
            const onMove = () => { if (!raf) raf = requestAnimationFrame(check); };
            window.addEventListener('scroll', onMove, { passive: true });
            window.addEventListener('resize', onMove);
            check();
        })();
    </script>
</body>

</html>