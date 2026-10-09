<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Akademiyolum — Akademik Kariyer Platformu</title>
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=playfair-display:400,700,900|dm-sans:300,400,500,600" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--navy:#0a1628;--blue:#1a56db;--blue-light:#3b82f6;--gold:#c9a84c;--gold-light:#e8c96d;--bg:#f8f9ff;--surface:#fff;--border:#e2e8f0;--t1:#0a1628;--t2:#4a5568;--t3:#718096;}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',system-ui,sans-serif;color:var(--t1);background:var(--surface);overflow-x:hidden}
a{text-decoration:none}
nav{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(255,255,255,0.92);backdrop-filter:blur(12px);border-bottom:1px solid var(--border);padding:0 5%;height:68px;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:10px}
.nav-logo-icon{width:36px;height:36px;background:var(--navy);border-radius:8px;display:flex;align-items:center;justify-content:center}
.nav-logo-icon svg{width:20px;height:20px;fill:var(--gold)}
.nav-logo-text{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--navy)}
.nav-links{display:flex;align-items:center;gap:8px}
.nav-links a{font-size:14px;font-weight:500;color:var(--t2);padding:8px 14px;border-radius:8px;transition:all .2s}
.nav-links a:hover{color:var(--navy);background:#f1f5f9}
.nav-cta{display:flex;align-items:center;gap:10px}
.btn-outline{font-size:14px;font-weight:500;color:var(--navy);border:1.5px solid var(--navy);padding:8px 20px;border-radius:8px;transition:all .2s;cursor:pointer;background:transparent}
.btn-outline:hover{background:var(--navy);color:white}
.btn-primary{font-size:14px;font-weight:600;color:white;background:var(--blue);padding:9px 22px;border-radius:8px;transition:all .2s;cursor:pointer;border:none}
.btn-primary:hover{background:#1447c0}
.hero{min-height:100vh;display:flex;align-items:center;padding:100px 5% 80px;background:linear-gradient(135deg,#f8f9ff 0%,#eef2ff 40%,#fafaf8 100%);position:relative;overflow:hidden}
.hero-grid-bg{position:absolute;inset:0;opacity:0.04;background-image:linear-gradient(var(--navy) 1px,transparent 1px),linear-gradient(90deg,var(--navy) 1px,transparent 1px);background-size:60px 60px}
.hero-content{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;width:100%;position:relative}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(26,86,219,0.08);border:1px solid rgba(26,86,219,0.2);color:var(--blue);font-size:13px;font-weight:500;padding:6px 14px;border-radius:100px;margin-bottom:24px}
.badge-dot{width:6px;height:6px;background:var(--blue);border-radius:50%;animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
h1{font-family:'Playfair Display',serif;font-size:56px;font-weight:900;line-height:1.1;color:var(--navy);margin-bottom:24px}
h1 em{font-style:normal;color:var(--blue)}
.hero-desc{font-size:18px;color:var(--t2);line-height:1.7;margin-bottom:36px}
.hero-actions{display:flex;align-items:center;gap:16px;margin-bottom:48px;flex-wrap:wrap}
.btn-hero{font-size:16px;font-weight:600;color:white;background:var(--blue);padding:14px 32px;border-radius:10px;transition:all .25s;display:inline-flex;align-items:center;gap:10px;border:none;cursor:pointer}
.btn-hero:hover{background:#1447c0;transform:translateY(-2px);box-shadow:0 8px 24px rgba(26,86,219,0.3)}
.btn-hero-ghost{font-size:16px;font-weight:500;color:var(--navy);padding:14px 24px;border-radius:10px;display:inline-flex;align-items:center;gap:8px;transition:all .2s}
.btn-hero-ghost:hover{background:#f1f5f9}
.hero-stats{display:flex;align-items:center;gap:32px;flex-wrap:wrap}
.stat-num{font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:var(--navy)}
.stat-label{font-size:13px;color:var(--t3);margin-top:2px}
.stat-divider{width:1px;height:40px;background:var(--border)}
.hero-visual{position:relative}
.dashboard-mock{background:white;border:1px solid var(--border);border-radius:16px;box-shadow:0 20px 60px rgba(10,22,40,0.12);overflow:hidden;animation:float 4s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
.mock-header{background:var(--navy);padding:14px 18px;display:flex;align-items:center;justify-content:space-between}
.mock-logo{font-family:'Playfair Display',serif;font-size:13px;font-weight:700;color:white}
.mock-tabs{display:flex;border-bottom:1px solid var(--border);padding:0 18px;background:#f8f9fc}
.mock-tab{font-size:10px;padding:9px 12px;color:var(--t3);border-bottom:2px solid transparent}
.mock-tab.active{color:var(--blue);border-color:var(--blue);font-weight:500}
.mock-body{padding:18px}
.mock-status{background:var(--navy);color:#4ade80;font-size:9px;font-family:monospace;padding:7px 12px;border-radius:5px;margin-bottom:14px;display:flex;justify-content:space-between}
.mock-cards{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:8px;margin-bottom:14px}
.mock-card{background:#f8f9fc;border-radius:7px;padding:10px}
.mock-card-label{font-size:8px;color:var(--t3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px}
.mock-card-val{font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--navy)}
.mock-card-sub{font-size:8px;margin-top:3px}
.sub-ok{color:#16a34a}.sub-warn{color:#d97706}
.mock-chart-area{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.mock-chart{background:#f8f9fc;border-radius:7px;padding:12px}
.mock-chart-title{font-size:9px;font-weight:500;color:var(--t2);margin-bottom:8px}
.bar-group{display:flex;align-items:flex-end;gap:4px;height:50px}
.bar{border-radius:2px 2px 0 0;min-width:14px}
.b1{background:var(--blue);height:80%}.b2{background:rgba(26,86,219,0.4);height:45%}.b3{background:var(--blue);height:65%}.b4{background:rgba(26,86,219,0.4);height:30%}.b5{background:var(--blue);height:90%}
.prog-list{display:flex;flex-direction:column;gap:7px}
.prog-item-label{display:flex;justify-content:space-between;font-size:8px;color:var(--t3);margin-bottom:2px}
.prog-track{background:#e2e8f0;border-radius:100px;height:4px;overflow:hidden}
.prog-fill{height:100%;border-radius:100px}
.pf-blue{background:var(--blue);width:65%}.pf-gold{background:var(--gold);width:28%}.pf-green{background:#16a34a;width:45%}
.floating-pill{position:absolute;background:white;border:1px solid var(--border);border-radius:100px;padding:7px 13px;font-size:11px;font-weight:500;color:var(--navy);box-shadow:0 4px 16px rgba(0,0,0,0.08);display:flex;align-items:center;gap:6px;white-space:nowrap}
.fp1{top:-14px;left:-18px;animation:float2 3.5s ease-in-out infinite}
.fp2{bottom:-10px;right:-14px;animation:float2 4s ease-in-out infinite .8s}
@keyframes float2{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
.pill-dot{width:7px;height:7px;border-radius:50%}.pd-green{background:#22c55e}.pd-gold{background:var(--gold)}
.logos-section{padding:36px 5%;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:#f8f9ff}
.logos-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px}
.logos-label{font-size:13px;color:var(--t3);font-weight:500;margin-right:40px;white-space:nowrap}
.logo-items{display:flex;align-items:center;gap:32px;flex-wrap:wrap}
.logo-item{font-size:13px;font-weight:600;color:var(--t3);opacity:.6}
.features{padding:100px 5%;background:white}
.section-inner{max-width:1200px;margin:0 auto}
.section-tag{display:inline-block;background:rgba(26,86,219,0.08);color:var(--blue);font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;padding:5px 13px;border-radius:100px;margin-bottom:14px}
.section-title{font-family:'Playfair Display',serif;font-size:44px;font-weight:700;color:var(--navy);margin-bottom:14px;max-width:600px;line-height:1.15}
.section-sub{font-size:17px;color:var(--t2);max-width:540px;line-height:1.7;margin-bottom:60px}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.feature-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:26px;transition:all .25s;position:relative;overflow:hidden}
.feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--blue),var(--blue-light));transform:scaleX(0);transform-origin:left;transition:transform .3s}
.feature-card:hover{border-color:rgba(26,86,219,0.3);box-shadow:0 8px 32px rgba(26,86,219,0.08);transform:translateY(-2px)}
.feature-card:hover::before{transform:scaleX(1)}
.feature-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;font-size:20px}
.fi-blue{background:rgba(26,86,219,0.08)}.fi-gold{background:rgba(201,168,76,0.1)}.fi-green{background:rgba(22,163,74,0.08)}
.feature-card h3{font-size:17px;font-weight:600;color:var(--navy);margin-bottom:9px}
.feature-card p{font-size:14px;color:var(--t2);line-height:1.65}
.how-section{padding:100px 5%;background:var(--navy)}
.how-title{font-family:'Playfair Display',serif;font-size:44px;font-weight:700;color:white;margin-bottom:14px}
.how-sub{font-size:17px;color:rgba(255,255,255,0.6);max-width:500px;line-height:1.7;margin-bottom:60px}
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;position:relative}
.steps::before{content:'';position:absolute;top:30px;left:10%;right:10%;height:1px;background:rgba(255,255,255,0.15)}
.step{text-align:center;padding:0 18px;position:relative}
.step-num{width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 22px;font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--gold);position:relative;z-index:1}
.step h4{font-size:15px;font-weight:600;color:white;margin-bottom:9px}
.step p{font-size:13px;color:rgba(255,255,255,0.5);line-height:1.6}
.testimonials{padding:100px 5%;background:#f8f9ff}
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.testi-card{background:white;border:1px solid var(--border);border-radius:16px;padding:26px}
.testi-stars{display:flex;gap:3px;margin-bottom:14px;color:var(--gold);font-size:13px}
.testi-text{font-size:14px;color:var(--t2);line-height:1.7;margin-bottom:18px;font-style:italic}
.testi-author{display:flex;align-items:center;gap:11px}
.testi-avatar{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600}
.ta1{background:rgba(26,86,219,0.1);color:var(--blue)}.ta2{background:rgba(201,168,76,0.15);color:#92741a}.ta3{background:rgba(22,163,74,0.1);color:#16a34a}
.testi-name{font-size:13px;font-weight:600;color:var(--navy)}
.testi-role{font-size:11px;color:var(--t3)}
.pricing{padding:100px 5%;background:white}
.pricing-grid{display:grid;grid-template-columns:repeat(var(--paket-sayisi,3),1fr);gap:22px;max-width:960px;margin:0 auto}
.price-card{border:1px solid var(--border);border-radius:16px;padding:30px;position:relative}
.price-card.featured{border-color:var(--blue);border-width:2px;box-shadow:0 8px 32px rgba(26,86,219,0.12)}
.price-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--blue);color:white;font-size:10px;font-weight:600;padding:4px 14px;border-radius:100px;letter-spacing:.5px;text-transform:uppercase;white-space:nowrap}
.price-plan{font-size:12px;font-weight:600;color:var(--t3);text-transform:uppercase;letter-spacing:1px;margin-bottom:10px}
.price-amount{display:flex;align-items:baseline;gap:4px;margin-bottom:7px}
.price-num{font-family:'Playfair Display',serif;font-size:38px;font-weight:700;color:var(--navy)}
.price-period{font-size:13px;color:var(--t3)}
.price-desc{font-size:13px;color:var(--t2);margin-bottom:22px;line-height:1.5}
.price-divider{height:1px;background:var(--border);margin-bottom:22px}
.price-features{list-style:none;display:flex;flex-direction:column;gap:11px;margin-bottom:26px}
.price-features li{font-size:13px;color:var(--t2);display:flex;align-items:center;gap:9px}
.check{color:#16a34a;font-size:13px;font-weight:700}
.price-btn{display:block;width:100%;padding:11px;border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;border:none;transition:all .2s;font-family:'DM Sans',sans-serif;text-align:center}
.price-btn-outline{background:transparent;border:1.5px solid var(--navy)!important;color:var(--navy)}
.price-btn-outline:hover{background:var(--navy);color:white}
.price-btn-primary{background:var(--blue);color:white}
.price-btn-primary:hover{background:#1447c0}
.cta-section{padding:100px 5%;background:var(--navy);text-align:center;position:relative;overflow:hidden}
.cta-section h2{font-family:'Playfair Display',serif;font-size:50px;font-weight:700;color:white;margin-bottom:18px}
.cta-section p{font-size:17px;color:rgba(255,255,255,0.6);max-width:500px;margin:0 auto 36px;line-height:1.7}
.cta-actions{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}
.btn-cta-primary{font-size:15px;font-weight:600;background:var(--gold);color:var(--navy);padding:13px 34px;border-radius:10px;transition:all .25s;display:inline-flex;align-items:center;gap:9px}
.btn-cta-primary:hover{background:var(--gold-light);transform:translateY(-2px)}
.btn-cta-ghost{font-size:15px;font-weight:500;color:rgba(255,255,255,0.7);padding:13px 26px;border-radius:10px;border:1px solid rgba(255,255,255,0.2);transition:all .2s}
.btn-cta-ghost:hover{background:rgba(255,255,255,0.08);color:white}
footer{background:#060f1e;padding:56px 5% 28px}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-top{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:44px;margin-bottom:44px}
.footer-brand p{font-size:13px;color:rgba(255,255,255,0.4);line-height:1.7;margin-top:13px;max-width:250px}
.footer-col h5{font-size:11px;font-weight:600;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;margin-bottom:14px}
.footer-col a{display:block;font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:9px;transition:color .2s}
.footer-col a:hover{color:white}
.footer-bottom{border-top:1px solid rgba(255,255,255,0.08);padding-top:24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px}
.footer-copy{font-size:12px;color:rgba(255,255,255,0.3)}
.footer-legal{display:flex;gap:22px}
.footer-legal a{font-size:12px;color:rgba(255,255,255,0.3)}
.footer-legal a:hover{color:rgba(255,255,255,0.6)}
@media (max-width:900px){
  .nav-links{display:none}
  .hero-content{grid-template-columns:1fr;gap:48px}
  .hero-visual{display:none}
  h1{font-size:40px}
  .features-grid,.testi-grid,.pricing-grid{grid-template-columns:1fr}
  .steps{grid-template-columns:1fr 1fr;gap:32px}
  .steps::before{display:none}
  .footer-top{grid-template-columns:1fr 1fr}
  .section-title,.how-title,.cta-section h2{font-size:32px}
}
</style>
</head>
<body>
<nav>
  <a class="nav-logo" href="{{ route('home') }}">
    <div class="nav-logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
    <span class="nav-logo-text">Akademiyolum</span>
  </a>
  <div class="nav-links">
    <a href="#features">Özellikler</a><a href="#how">Nasıl Çalışır</a><a href="#pricing">Fiyatlandırma</a><a href="#testimonials">Yorumlar</a>
  </div>
  <div class="nav-cta">
    @auth
      <a class="btn-primary" href="{{ route('dashboard') }}">Panele Git</a>
    @else
      <a class="btn-outline" href="{{ route('login') }}">Giriş Yap</a>
      <a class="btn-primary" href="{{ route('register') }}">Ücretsiz Başla</a>
    @endauth
  </div>
</nav>

<section class="hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-content">
    <div>
      <div class="hero-badge"><span class="badge-dot"></span>Doçentlik Sürecini Yönet</div>
      <h1>Akademik<br>Kariyerinizin<br><em>Kontrol Merkezi</em></h1>
      <p class="hero-desc">Faaliyetlerinizi takip edin, doçentlik puanlarınızı hesaplayın ve akademik hedefinize en hızlı yoldan ulaşın. Tüm Türk üniversite yönergeleriyle uyumlu.</p>
      <div class="hero-actions">
        <a class="btn-hero" href="{{ route('register') }}">Hemen Başla — Ücretsiz ›</a>
        <a class="btn-hero-ghost" href="#features">▶ Özellikleri Gör</a>
      </div>
      <div class="hero-stats">
        <div><div class="stat-num">4,200+</div><div class="stat-label">Aktif Akademisyen</div></div>
        <div class="stat-divider"></div>
        <div><div class="stat-num">87</div><div class="stat-label">Üniversite</div></div>
        <div class="stat-divider"></div>
        <div><div class="stat-num">%94</div><div class="stat-label">Başarı Oranı</div></div>
      </div>
    </div>
    <div class="hero-visual">
      <div class="floating-pill fp1"><span class="pill-dot pd-green"></span>Hedefe %65 ulaştınız</div>
      <div class="dashboard-mock">
        <div class="mock-header"><span class="mock-logo">Akademiyolum</span><span style="font-size:11px;color:rgba(255,255,255,.5)">Dr. Ahmet K.</span></div>
        <div class="mock-tabs"><span class="mock-tab active">Dashboard</span><span class="mock-tab">Faaliyetler</span><span class="mock-tab">Yönerge</span><span class="mock-tab">YZ</span></div>
        <div class="mock-body">
          <div class="mock-status"><span>● İLAHİYAT 2026 AKTİF</span><span>v1.1.0</span></div>
          <div class="mock-cards">
            <div class="mock-card"><div class="mock-card-label">Toplam Puan</div><div class="mock-card-val">124</div><div class="mock-card-sub sub-ok">↑ +18</div></div>
            <div class="mock-card"><div class="mock-card-label">Faaliyet</div><div class="mock-card-val">16</div><div class="mock-card-sub sub-ok">4 onaylı</div></div>
            <div class="mock-card"><div class="mock-card-label">Doçentlik</div><div class="mock-card-val" style="font-size:13px;padding-top:3px">Devam</div><div class="mock-card-sub sub-warn">2 eksik</div></div>
            <div class="mock-card"><div class="mock-card-label">ÜAK</div><div class="mock-card-val">82</div><div class="mock-card-sub sub-ok">/100</div></div>
          </div>
          <div class="mock-chart-area">
            <div class="mock-chart"><div class="mock-chart-title">Puan Gelişimi</div><div class="bar-group"><div class="bar b2"></div><div class="bar b1"></div><div class="bar b2"></div><div class="bar b3"></div><div class="bar b4"></div><div class="bar b5"></div></div></div>
            <div class="mock-chart"><div class="mock-chart-title">Kategori Dağılımı</div><div class="prog-list"><div class="prog-item"><div class="prog-item-label"><span>Makale</span><span>65%</span></div><div class="prog-track"><div class="prog-fill pf-blue"></div></div></div><div class="prog-item"><div class="prog-item-label"><span>Atıf</span><span>28%</span></div><div class="prog-track"><div class="prog-fill pf-gold"></div></div></div><div class="prog-item"><div class="prog-item-label"><span>Eğitim</span><span>45%</span></div><div class="prog-track"><div class="prog-fill pf-green"></div></div></div></div></div>
          </div>
        </div>
      </div>
      <div class="floating-pill fp2"><span class="pill-dot pd-gold"></span>YZ: 3 öneri hazır</div>
    </div>
  </div>
</section>

<section class="logos-section">
  <div class="logos-inner">
    <span class="logos-label">Kullanılan üniversiteler</span>
    <div class="logo-items"><span class="logo-item">ODTÜ</span><span class="logo-item">BOĞAZİÇİ</span><span class="logo-item">MERSİN ÜNİV.</span><span class="logo-item">ANKARA ÜNİV.</span><span class="logo-item">İTÜ</span><span class="logo-item">HACETTEPE</span></div>
  </div>
</section>

<section class="features" id="features">
  <div class="section-inner">
    <div class="section-tag">Özellikler</div>
    <h2 class="section-title">Akademik kariyer yönetiminin tüm araçları</h2>
    <p class="section-sub">Doktora mezuniyetinden profesörlüğe, her adımda ihtiyacınız olan analiz, takip ve yapay zeka desteği.</p>
    <div class="features-grid">
      <div class="feature-card"><div class="feature-icon fi-blue">📊</div><h3>Otomatik Puan Hesaplama</h3><p>Makale, bildiri, kitap, proje, patent — tüm faaliyetlerinizi ekleyin; ÜAK ve üniversite yönergelerine göre puanlarınız anında hesaplansın. Tez dışı bağımsız / tezden üretilmiş ayrımı otomatik uygulanır.</p></div>
      <div class="feature-card"><div class="feature-icon fi-gold">🤖</div><h3>YZ Akademik Danışman</h3><p>Yapay zeka destekli danışmanınız, hangi faaliyetlere odaklanmanız gerektiğini ve eksiklerinizi açıklar.</p></div>
      <div class="feature-card"><div class="feature-icon fi-green">📋</div><h3>Yönerge Analizi</h3><p>Türkiye'deki tüm üniversite yönergelerini analiz edin. Doktora mezunundan profesörlüğe dört kariyer basamağı.</p></div>
      <div class="feature-card"><div class="feature-icon fi-blue">📚</div><h3>AVESİS & Scholar Entegrasyonu</h3><p>Faaliyet listenizi manuel girmek zorunda değilsiniz. AVESİS ve Google Scholar'dan otomatik içe aktarın.</p></div>
      <div class="feature-card"><div class="feature-icon fi-gold">⚖️</div><h3>YZ Jüri Analizi</h3><p>YZ, dosyanızı gerçek bir jüri üyesi gibi 10 maddede değerlendirir. Net karar: Başvurabilir / Başvuramaz.</p></div>
      <div class="feature-card"><div class="feature-icon fi-green">📄</div><h3>CV & Çıktı Yönetimi</h3><p>Tüm akademik dosyanızı PDF veya Word formatında, başvuruya hazır şekilde bir tıklamayla oluşturun.</p></div>
    </div>
  </div>
</section>

<section class="how-section" id="how">
  <div class="section-inner">
    <div style="text-align:center">
      <div class="section-tag" style="background:rgba(201,168,76,0.15);color:var(--gold)">Nasıl Çalışır</div>
      <h2 class="how-title">4 adımda akademik hedefinize</h2>
      <p class="how-sub" style="margin:0 auto 60px">Kayıt olun, üniversitenizi seçin, faaliyetlerinizi ekleyin, hedefinizi takip edin.</p>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><h4>Kayıt & Profil</h4><p>Üniversitenizi, temel alanınızı ve kariyer basamağınızı seçin.</p></div>
      <div class="step"><div class="step-num">2</div><h4>Faaliyetleri İçe Aktar</h4><p>AVESİS veya Scholar'dan mevcut faaliyetlerinizi otomatik alın.</p></div>
      <div class="step"><div class="step-num">3</div><h4>Analizi Görün</h4><p>Puan dağılımınızı, eksik kriterlerinizi anlık takip edin.</p></div>
      <div class="step"><div class="step-num">4</div><h4>Hedefe Ulaş</h4><p>YZ rehberliğinde dosyanızı hazırlayın ve başvurunuzu yapın.</p></div>
    </div>
  </div>
</section>

<section class="testimonials" id="testimonials">
  <div class="section-inner">
    <div style="margin-bottom:44px"><div class="section-tag">Akademisyenler Anlatıyor</div><h2 class="section-title">Binlerce akademisyen güveniyor</h2></div>
    <div class="testi-grid">
      <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"Hangi kategoride kaç puanım eksik olduğunu anlayamıyordum. Akademiyolum sayesinde 3 ayda eksiğimi tamamladım."</p><div class="testi-author"><div class="testi-avatar ta1">MK</div><div><div class="testi-name">Dr. Mehmet Kaya</div><div class="testi-role">Doç. Dr. Aday, Ankara Üniversitesi</div></div></div></div>
      <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"YZ Jüri Analizi inanılmaz gerçekçi. Doktora sonrasında hangi üniversitelere başvurabileceğimi anında gördüm."</p><div class="testi-author"><div class="testi-avatar ta2">FT</div><div><div class="testi-name">Dr. Fatma Taşçı</div><div class="testi-role">Dr. Öğr. Üyesi, Hacettepe Üniversitesi</div></div></div></div>
      <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"AVESİS entegrasyonu hayat kurtardı. 60 faaliyeti tek tıkla aktardım, hepsi anında puanlandı."</p><div class="testi-author"><div class="testi-avatar ta3">AY</div><div><div class="testi-name">Prof. Dr. Ali Yıldırım</div><div class="testi-role">İTÜ, Mühendislik Fakültesi</div></div></div></div>
    </div>
  </div>
</section>

<section class="pricing" id="pricing">
  <div class="section-inner">
    <div style="text-align:center;margin-bottom:52px"><div class="section-tag">Fiyatlandırma</div><h2 class="section-title" style="margin:0 auto 14px">Şeffaf ve erişilebilir</h2></div>
    {{-- Kartlar Yönetim → Paketler'den: ad, fiyat, açıklama, özellikler ve
         rozet orada düzenleniyor; satışta olmayan paket görünmez. --}}
    @php $satistakiPaketler = app(\App\Services\Abonelik\PaketKatalogu::class)->satistakiler(); @endphp
    <div class="pricing-grid" style="--paket-sayisi: {{ max(1, $satistakiPaketler->count()) }}">
      @foreach ($satistakiPaketler as $paket)
      <div @class(['price-card', 'featured' => $paket->one_cikan])>
        @if ($paket->one_cikan)<div class="price-badge">En Popüler</div>@endif
        <div class="price-plan">{{ $paket->ad }}</div>
        <div class="price-amount"><span class="price-num">{{ \App\Models\Paket::fiyatMetni($paket->aylik_fiyat_kurus) }}</span><span class="price-period">/ ay</span></div>
        @if ($paket->yillik_fiyat_kurus !== null)
        <p class="price-desc" style="margin-bottom:6px">Yıllık {{ \App\Models\Paket::fiyatMetni($paket->yillik_fiyat_kurus) }}@if ($paket->yillikIndirim()) · %{{ $paket->yillikIndirim() }} indirim @endif</p>
        @endif
        @if ($paket->aciklama)<p class="price-desc">{{ $paket->aciklama }}</p>@endif
        <div class="price-divider"></div>
        <ul class="price-features">@foreach ($paket->ozellikler as $ozellik)<li><span class="check">✓</span>{{ $ozellik }}</li>@endforeach</ul>
        <a @class(['price-btn', 'price-btn-primary' => $paket->one_cikan, 'price-btn-outline' => ! $paket->one_cikan]) href="{{ route('register', ['paket' => $paket->plan->value]) }}">{{ $paket->buton_metni }}</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="cta-section">
  <h2>Akademik hedefinize<br>bugün başlayın</h2>
  <p>Kredi kartı gerekmez. 5 dakikada kurulum.</p>
  <div class="cta-actions">
    <a class="btn-cta-primary" href="{{ route('register') }}">Ücretsiz Hesap Oluştur ›</a>
    <a class="btn-cta-ghost" href="#features">Özellikleri Gör</a>
  </div>
</section>

<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="nav-logo"><div class="nav-logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><span style="font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:white;margin-left:8px">Akademiyolum</span></div>
        <p>Türkiye'nin akademik kariyer yönetim platformu.</p>
      </div>
      <div class="footer-col"><h5>Platform</h5><a href="#features">Özellikler</a><a href="#pricing">Fiyatlandırma</a><a href="#how">Nasıl Çalışır</a></div>
      <div class="footer-col"><h5>Şirket</h5><a href="#">Hakkımızda</a><a href="#">Blog</a><a href="#">İletişim</a></div>
      <div class="footer-col"><h5>Destek</h5><a href="#">Yardım Merkezi</a><a href="#">Durum Sayfası</a><a href="#">KVKK</a></div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">© {{ date('Y') }} Akademiyolum. Tüm hakları saklıdır.</span>
      <div class="footer-legal"><a href="#">Gizlilik</a><a href="#">Kullanım Şartları</a><a href="#">KVKK</a></div>
    </div>
  </div>
</footer>
</body>
</html>
